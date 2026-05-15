<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\LatestNews;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class LatestNewsController extends MainController
{
    public function index(Request $request)
    {
        $query = LatestNews::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
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
        $newsItems = $query->paginate(10);
        $newsItems->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Latest News';
        $page = 'admin.latest-news.index';
        return $this->template($page, compact('newsItems', 'title'));
    }

    public function create()
    {
        $title = 'Create News Item';
        $comp = 'latest-news';
        return $this->template('admin.latest-news.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'date' => 'required|date_format:d/m/Y',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a news item.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('date'))->toDateString(),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'latest-news', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            LatestNews::create($data);
            Toastr::success('News item created successfully.', 'Success');
            return redirect()->route('admin.latest-news.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create news item: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(LatestNews $latestNews)
    {
        $title = 'Edit News Item';
        $comp = 'latest-news';
        return $this->template('admin.latest-news.edit', compact('latestNews', 'title', 'comp'));
    }

    public function update(Request $request, LatestNews $latestNews)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'date' => 'required|date_format:d/m/Y',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a news item.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('date'))->toDateString(),
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $latestNews->image, 'latest-news', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $latestNews->update($data);
            Toastr::success('News item updated successfully.', 'Success');
            return redirect()->route('admin.latest-news.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update news item: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(LatestNews $latestNews)
    {
        try {
            if ($latestNews->image && $latestNews->image !== config('app.DEFAULT_IMAGE') . 'default-news.jpg') {
                UploadImage::deleteFile($latestNews->image);
            }
            $latestNews->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'News deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete news: ' . $e->getMessage(),
            ]);
        }
    }
}
