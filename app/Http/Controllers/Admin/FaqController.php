<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Faq;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class FaqController extends MainController
{
    public function index(Request $request)
    {
        $query = Faq::query();
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
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
        $faqs = $query->paginate(10);
        $faqs->appends($request->only(['search', 'date_range', 'status']));

        $title = 'FAQs';
        $page = 'admin.faqs.index';
        return $this->template($page, compact('faqs', 'title'));
    }

    public function create()
    {
        $title = 'Create FAQ';
        $comp = 'faq';
        return $this->template('admin.faqs.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'title' => 'required|string|max:255|unique:faqs,title',
            'description' => 'required|string',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create an FAQ.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
                'school_id' => $user->school_id,
                'active' => 1,
            ];

            Faq::create($data);
            Toastr::success('FAQ created successfully.', 'Success');
            return redirect()->route('admin.faqs.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create FAQ: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Faq $faq)
    {
        $title = 'Edit FAQ';
        $comp = 'faq';
        return $this->template('admin.faqs.edit', compact('faq', 'title', 'comp'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:faqs,title,' . $faq->id,
            'description' => 'required|string',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update an FAQ.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
            ];

            $faq->update($data);
            Toastr::success('FAQ updated successfully.', 'Success');
            return redirect()->route('admin.faqs.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update FAQ: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'FAQ deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete FAQ: ' . $e->getMessage(),
            ]);
        }
    }
}
