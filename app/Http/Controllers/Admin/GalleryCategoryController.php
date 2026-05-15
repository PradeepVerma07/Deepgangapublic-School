<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Log;

class GalleryCategoryController extends MainController
{
    public function index(Request $request)
    {
        $query = GalleryCategory::query();
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
        $categories = $query->paginate(10);
        $categories->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Gallery Categories';
        $page = 'admin.gallery-categories.index';
        return $this->template($page, compact('categories', 'title'));
    }

    public function create()
    {
        $title = 'Create Gallery Category';
        $comp = 'gallery-category';
        return $this->template('admin.gallery-categories.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'title' => 'required|string|max:255|unique:gallery_categories,title',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a gallery category.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            GalleryCategory::create($data);
            Toastr::success('Gallery category created successfully.', 'Success');
            return redirect()->route('admin.gallery-categories.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create gallery category: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(GalleryCategory $gallery_category)
    {
        $title = 'Edit Gallery Category';
        $comp = 'gallery-category';
        return $this->template('admin.gallery-categories.edit', compact('gallery_category', 'title', 'comp'));
    }

    public function update(Request $request, GalleryCategory $gallery_category)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:gallery_categories,title,' . $gallery_category->id,
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a gallery category.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'seq' => $request->input('seq'),
            ];

            $gallery_category->update($data);
            Toastr::success('Gallery category updated successfully.', 'Success');
            return redirect()->route('admin.gallery-categories.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update gallery category: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(GalleryCategory $gallery_category)
    {
        try {
            $gallery_category->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Gallery category deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete Gallery category: ' . $e->getMessage(),
            ]);
        }
    }
}
