<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Student;
use App\Models\Classes;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class StudentController extends MainController
{
    public function index(Request $request)
    {
        $query = Student::query()->with('class');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
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
        $students = $query->paginate(10);
        $students->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Students';
        $page = 'admin.students.index';
        return $this->template($page, compact('students', 'title'));
    }

    public function create()
    {
        $title = 'Create Student';
        $comp = 'student';
        $classes = Classes::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.students.create', compact('title', 'comp', 'classes'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'mobile' => 'required|string|max:15',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'address' => 'required|string|max:500',
            'dob' => 'required|date_format:d/m/Y',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a student.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'class_id' => $request->input('class_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
                'dob' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('dob'))->toDateString(),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'students', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Student::create($data);
            Toastr::success('Student created successfully.', 'Success');
            return redirect()->route('students.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create student: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Student $student)
    {
        $title = 'Edit Student';
        $comp = 'student';
        $classes = Classes::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.students.edit', compact('student', 'title', 'comp', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'mobile' => 'required|string|max:15',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'address' => 'required|string|max:500',
            'dob' => 'required|date_format:d/m/Y',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a student.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'class_id' => $request->input('class_id'),
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'address' => $request->input('address'),
                'dob' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('dob'))->toDateString(),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $student->image, 'students', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $student->update($data);
            Toastr::success('Student updated successfully.', 'Success');
            return redirect()->route('students.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update student: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Student $student)
    {
        try {
            if ($student->image && $student->image !== config('app.DEFAULT_IMAGE') . 'default-student.jpg') {
                UploadImage::deleteFile($student->image);
            }
            $student->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Student deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete student: ' . $e->getMessage(),
            ]);
        }
    }
}
