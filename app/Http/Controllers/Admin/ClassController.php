<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Classes;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Log;

class ClassController extends MainController
{
    public function index(Request $request)
    {
        $query = Classes::query();
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
        $classes = $query->paginate(10);
        $classes->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Classes';
        $page = 'admin.classes.index';
        return $this->template($page, compact('classes', 'title'));
    }

    public function create()
    {
        $title = 'Create Class';
        $comp = 'class';
        return $this->template('admin.classes.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'title' => 'required|string|max:255',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a class.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ];

            Classes::create($data);
            Toastr::success('Class created successfully.', 'Success');
            return redirect()->route('admin.classes.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create class: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Classes $class)
    {
        $title = 'Edit Class';
        $comp = 'class';
        return $this->template('admin.classes.edit', compact('class', 'title', 'comp'));
    }

    public function update(Request $request, Classes $class)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a class.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'seq' => $request->input('seq'),
            ];

            $class->update($data);
            Toastr::success('Class updated successfully.', 'Success');
            return redirect()->route('admin.classes.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update class: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Classes $class)
    {
        try {
            $class->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Class deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete class: ' . $e->getMessage(),
            ]);
        }
    }
}
