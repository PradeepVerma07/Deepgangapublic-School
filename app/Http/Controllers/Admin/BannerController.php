<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Banner;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class BannerController extends MainController
{
    public function index(Request $request)
    {
        $query = Banner::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title1', 'like', "%{$search}%")
                  ->orWhere('title2', 'like', "%{$search}%")
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
        $banners = $query->paginate(10);
        $banners->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Banners';
        $page = 'admin.banners.index';
        return $this->template($page, compact('banners', 'title'));
    }

    public function create()
    {
        $title = 'Create Banner';
        $comp = 'banner';
        return $this->template('admin.banners.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'title1' => 'nullable|string|max:255',
            'title2' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a banner.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title1' => $request->input('title1'),
                'title2' => $request->input('title2'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'banners', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Banner::create($data);
            Toastr::success('Banner created successfully.', 'Success');
            return redirect()->route('admin.banners.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create banner: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Banner $banner)
    {
        $title = 'Edit Banner';
        $comp = 'banner';
        return $this->template('admin.banners.edit', compact('banner', 'title', 'comp'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'title1' => 'nullable|string|max:255',
            'title2' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a banner.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title1' => $request->input('title1'),
                'title2' => $request->input('title2'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $banner->image, 'banners', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $banner->update($data);
            Toastr::success('Banner updated successfully.', 'Success');
            return redirect()->route('admin.banners.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update banner: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Banner $banner)
    {
        try {
            if ($banner->image && $banner->image !== config('app.DEFAULT_IMAGE') . 'default-banner.jpg') {
                UploadImage::deleteFile($banner->image);
            }
            $banner->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Banner deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' =>'Failed to delete banner: ' . $e->getMessage(),
            ]);
        }
    }
}
