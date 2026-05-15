<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Topper;
use App\Models\Classes;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class TopperController extends MainController
{
    public function index(Request $request)
    {
        $query = Topper::query()->with('class');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('marks', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%");
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
        $toppers = $query->paginate(10);
        $toppers->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Toppers';
        $page = 'admin.toppers.index';
        return $this->template($page, compact('toppers', 'title'));
    }

    public function create()
    {
        $title = 'Create Topper';
        $comp = 'topper';
        $classes = Classes::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.toppers.create', compact('title', 'comp', 'classes'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'marks' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a topper.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'class_id' => $request->input('class_id'),
                'name' => $request->input('name'),
                'marks' => $request->input('marks'),
                'year' => $request->input('year'),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'toppers', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Topper::create($data);
            Toastr::success('Topper created successfully.', 'Success');
            return redirect()->route('admin.toppers.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create topper: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Topper $topper)
    {
        $title = 'Edit Topper';
        $comp = 'topper';
        $classes = Classes::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.toppers.edit', compact('topper', 'title', 'comp', 'classes'));
    }

    public function update(Request $request, Topper $topper)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:255',
            'marks' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a topper.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'class_id' => $request->input('class_id'),
                'name' => $request->input('name'),
                'marks' => $request->input('marks'),
                'year' => $request->input('year'),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $topper->image, 'toppers', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $topper->update($data);
            Toastr::success('Topper updated successfully.', 'Success');
            return redirect()->route('admin.toppers.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update topper: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Topper $topper)
    {
        try {
            if ($topper->image && $topper->image !== config('app.DEFAULT_IMAGE') . 'default-topper.jpg') {
                UploadImage::deleteFile($topper->image);
            }
            $topper->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Topper deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete topper: ' . $e->getMessage(),
            ]);
        }
    }
}
