<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Teacher;
use App\Models\Classes;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class TeacherController extends MainController
{
    public function index(Request $request)
    {
        $query = Teacher::query()->with('class');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('qualification', 'like', "%{$search}%");
            });
        }
        if ($dateRange = $request->input('date_range')) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }
        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('active', $status);
        }
        $query->orderBy('seq', 'asc');
        $teachers = $query->paginate(10);
        $teachers->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Teachers';
        $page = 'admin.teachers.index';
        return $this->template($page, compact('teachers', 'title'));
    }

    public function create()
    {
        $title = 'Create Teacher';
        $comp = 'teacher';
        $classes = Classes::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.teachers.create', compact('title', 'comp', 'classes'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email',
            'mobile' => 'required|string|max:15',
            'subject' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'dob' => 'required|date_format:d/m/Y',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',

        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a teacher.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'class_id' => $request->input('class_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'subject' => $request->input('subject'),
                'qualification' => $request->input('qualification'),
                'seq' => $request->input('seq'),
                'dob' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('dob'))->toDateString(),
                'active' => 1,
                'school_id' =>$user->school_id,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'teachers', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Teacher::create($data);
            Toastr::success('Teacher created successfully.', 'Success');
            return redirect()->route('admin.teachers.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Teacher $teacher)
    {
        $title = 'Edit Teacher';
        $comp = 'teacher';
        $classes = Classes::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.teachers.edit', compact('teacher', 'title', 'comp', 'classes'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'mobile' => 'required|string|max:15',
            'subject' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'dob' => 'required|date_format:d/m/Y',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a teacher.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'class_id' => $request->input('class_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'subject' => $request->input('subject'),
                'qualification' => $request->input('qualification'),
                'seq' => $request->input('seq'),
                'dob' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('dob'))->toDateString(),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $teacher->image, 'teachers', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $teacher->update($data);
            Toastr::success('Teacher updated successfully.', 'Success');
            return redirect()->route('admin.teachers.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update teacher: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Teacher $teacher)
    {
        try {
            if ($teacher->image && $teacher->image !== config('app.DEFAULT_IMAGE') . 'default-teacher.jpg') {
                UploadImage::deleteFile($teacher->image);
            }
            $teacher->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Teacher deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete teacher: ' . $e->getMessage(),
            ]);
        }
    }
}
