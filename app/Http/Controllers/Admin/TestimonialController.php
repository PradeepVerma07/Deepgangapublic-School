<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class TestimonialController extends MainController
{
    public function index(Request $request)
    {
        $query = Testimonial::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
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
        $testimonials = $query->paginate(10);
        $testimonials->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Testimonials';
        $page = 'admin.testimonials.index';
        return $this->template($page, compact('testimonials', 'title'));
    }

    public function create()
    {
        $title = 'Create Testimonial';
        $comp = 'testimonial';
        return $this->template('admin.testimonials.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',

        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a testimonial.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
                'active' => 1,
                'school_id' =>$user->school_id,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'testimonials', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Testimonial::create($data);
            Toastr::success('Testimonial created successfully.', 'Success');
            return redirect()->route('admin.testimonials.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create testimonial: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Testimonial $testimonial)
    {
        $title = 'Edit Testimonial';
        $comp = 'testimonial';
        return $this->template('admin.testimonials.edit', compact('testimonial', 'title', 'comp'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a testimonial.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $testimonial->image, 'testimonials', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $testimonial->update($data);
            Toastr::success('Testimonial updated successfully.', 'Success');
            return redirect()->route('admin.testimonials.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update testimonial: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            if ($testimonial->image && $testimonial->image !== config('app.DEFAULT_IMAGE') . 'default-testimonial.jpg') {
                UploadImage::deleteFile($testimonial->image);
            }
            $testimonial->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Testimonial deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete testimonial: ' . $e->getMessage(),
            ]);
        }
    }
}
