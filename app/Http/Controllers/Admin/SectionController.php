<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Section;
use App\Models\WebsiteMenu;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class SectionController extends MainController
{
    public function index(Request $request)
    {
        $query = Section::query()->with('menu');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereRaw('JSON_CONTAINS(files, ?)', ['[{"heading": "' . $search . '"}]']);
            })->orWhereHas('menu', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
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
        $sections = $query->paginate(10);
        $sections->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Sections';
        $page = 'admin.sections.index';
        return $this->template($page, compact('sections', 'title'));
    }

    public function create()
    {
        $title = 'Create Section';
        $comp = 'section';
        $menus = WebsiteMenu::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.sections.create', compact('title', 'comp', 'menus'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'menu_id' => 'required|exists:website_menus,id',
            'type' => 'required|in:editor,images_pdf',
            'content' => 'required_if:type,editor|nullable|string',
            'headings.*' => 'required_if:type,images_pdf|string|max:255',
            'files.*' => 'required_if:type,images_pdf|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a section.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'menu_id' => $request->input('menu_id'),
                'type' => $request->input('type'),
                'content' => $request->input('type') === 'editor' ? $request->input('content') : null,
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            if ($request->input('type') === 'images_pdf' && $request->hasFile('files')) {
                $fileData = [];
                $headings = $request->input('headings', []);
                foreach ($request->file('files') as $index => $file) {
                    $upload = UploadImage::upload($request, 'files.' . $index, null, 'sections', 2048);
                    if ($upload['res'] === 'error') {
                        Toastr::error($upload['msg'], 'Error');
                        return redirect()->back()->withInput();
                    }
                    $fileData[] = [
                        'heading' => $headings[$index] ?? '',
                        'file_path' => $upload['file_path'],
                    ];
                }
                $data['files'] = json_encode($fileData);
            } else {
                $data['files'] = null;
            }

            Section::create($data);
            Toastr::success('Section created successfully.', 'Success');
            return redirect()->route('admin.sections.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create section: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Section $section)
    {
        $title = 'Edit Section';
        $comp = 'section';
        $menus = WebsiteMenu::where('active', 1)->orderBy('title')->get();
        return $this->template('admin.sections.edit', compact('section', 'title', 'comp', 'menus'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'menu_id' => 'required|exists:website_menus,id',
            'type' => 'required|in:editor,images_pdf',
            'content' => 'required_if:type,editor|nullable|string',
            'headings.*' => 'required_if:type,images_pdf|string|max:255',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a section.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'menu_id' => $request->input('menu_id'),
                'type' => $request->input('type'),
                'content' => $request->input('type') === 'editor' ? $request->input('content') : null,
                'seq' => $request->input('seq'),
            ];

            if ($request->input('type') === 'images_pdf') {
                $fileData = [];
                $existingFiles = $section->files ?? [];
                $headings = $request->input('headings', []);
                $deleteFiles = $request->input('delete_files', []);

                // Delete specified files
                foreach ($existingFiles as $index => $file) {
                    if (in_array($index, $deleteFiles)) {
                        UploadImage::deleteFile($file['file_path']);
                    } else {
                        $fileData[] = $file;
                    }
                }

                // Add new files
                if ($request->hasFile('files')) {
                    foreach ($request->file('files') as $index => $file) {
                        $upload = UploadImage::upload($request, 'files.' . $index, null, 'sections', 2048);
                        if ($upload['res'] === 'error') {
                            Toastr::error($upload['msg'], 'Error');
                            return redirect()->back()->withInput();
                        }
                        $fileData[] = [
                            'heading' => $headings[$index] ?? '',
                            'file_path' => $upload['file_path'],
                        ];
                    }
                }
                $data['files'] = $fileData ? json_encode($fileData) : null;
            } else {
                // Delete all files if switching to editor
                if ($section->files) {
                    foreach ($section->files as $file) {
                        UploadImage::deleteFile($file['file_path']);
                    }
                }
                $data['files'] = null;
            }

            $section->update($data);
            Toastr::success('Section updated successfully.', 'Success');
            return redirect()->route('admin.sections.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update section: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Section $section)
    {
        try {
            if ($section->files) {
                foreach ($section->files as $file) {
                    UploadImage::deleteFile($file['file_path']);
                }
            }
            $section->delete();
            Toastr::success('Section deleted successfully.', 'Success');
            return redirect()->route('admin.sections.index');
        } catch (Exception $e) {
            Toastr::error('Failed to delete section: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
