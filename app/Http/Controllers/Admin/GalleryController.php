<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class GalleryController extends MainController
{
    public function index(Request $request)
    {
        $query = Gallery::with('category');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('category', function ($q2) use ($search) {
                    $q2->where('title', 'like', "%{$search}%");
                });
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
        $galleryItems = $query->paginate(10);
        $galleryItems->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Gallery Items';
        $page = 'admin.gallery.index';
        return $this->template($page, compact('galleryItems', 'title'));
    }

    public function create()
    {
        $title = 'Create Gallery Item';
        $comp = 'gallery';
        $categories = GalleryCategory::where('active', 1)->get();
        return $this->template('admin.gallery.create', compact('title', 'categories', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'category_id' => 'required|exists:gallery_categories,id',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a gallery item.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'category_id' => $request->input('category_id'),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'gallery', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            Gallery::create($data);
            Toastr::success('Gallery item created successfully.', 'Success');
            return redirect()->route('admin.gallery.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create gallery item: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Gallery $gallery)
    {
        $title = 'Edit Gallery Item';
        $comp = 'gallery';
        $categories = GalleryCategory::where('active', 1)->get();
        return $this->template('admin.gallery.edit', compact('gallery', 'title', 'categories', 'comp'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'category_id' => 'required|exists:gallery_categories,id',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a gallery item.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'category_id' => $request->input('category_id'),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $gallery->image, 'gallery', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $gallery->update($data);
            Toastr::success('Gallery item updated successfully.', 'Success');
            return redirect()->route('admin.gallery.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update gallery item: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Gallery $gallery)
    {
        try {
            if ($gallery->image && $gallery->image !== config('app.DEFAULT_IMAGE') . 'default-gallery.jpg') {
                UploadImage::deleteFile($gallery->image);
            }
            $gallery->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Gallery item deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete gallery item: ' . $e->getMessage(),
            ]);
        }
    }
}
