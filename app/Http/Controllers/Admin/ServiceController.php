<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Service;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ServiceController extends MainController
{
    public function index(Request $request)
    {
        $query = Service::query();
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
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
        $services = $query->paginate(10);
        $services->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Services';
        $page = 'admin.services.index';
        return $this->template($page, compact('services', 'title'));
    }

    public function create()
    {
        $title = 'Create Service';
        return $this->template('admin.services.create', compact('title'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a service.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            while (Service::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data = [
                'title' => $request->input('title'),
                'slug' => $slug,
                'short_description' => $request->input('short_description'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
                'school_id' => $user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'services', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Service::create($data);
            Toastr::success('Service created successfully.', 'Success');
            return redirect()->route('admin.services.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create service: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Service $service)
    {
        $title = 'Edit Service';
        return $this->template('admin.services.edit', compact('service', 'title'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a service.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data = [
                'title' => $request->input('title'),
                'slug' => $slug,
                'short_description' => $request->input('short_description'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $service->image, 'services', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $service->update($data);
            Toastr::success('Service updated successfully.', 'Success');
            return redirect()->route('admin.services.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update service: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Service $service)
    {
        try {
            if ($service->image && $service->image !== config('app.DEFAULT_IMAGE') . 'default-service.jpg') {
                UploadImage::deleteFile($service->image);
            }
            $service->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Service deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete service: ' . $e->getMessage(),
            ]);
        }
    }
}