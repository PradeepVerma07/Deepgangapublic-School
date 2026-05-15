<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\BrandPartner;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class BrandPartnerController extends MainController
{
    public function index(Request $request)
    {
        $query = BrandPartner::query();
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
        $brandPartners = $query->paginate(10);
        $brandPartners->appends($request->only(['date_range', 'status']));

        $title = 'Brand Partners';
        $page = 'admin.brand-partners.index';
        return $this->template($page, compact('brandPartners', 'title'));
    }

    public function create()
    {
        $title = 'Create Brand Partner';
        return $this->template('admin.brand-partners.create', compact('title'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a brand partner.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'seq' => $request->input('seq'),
                'school_id' => $user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'brand-partners', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            BrandPartner::create($data);
            Toastr::success('Brand partner created successfully.', 'Success');
            return redirect()->route('admin.brand-partners.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create brand partner: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(BrandPartner $brandPartner)
    {
        $title = 'Edit Brand Partner';
        return $this->template('admin.brand-partners.edit', compact('brandPartner', 'title'));
    }

    public function update(Request $request, BrandPartner $brandPartner)
    {
        $request->validate([
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a brand partner.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $brandPartner->image, 'brand-partners', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $brandPartner->update($data);
            Toastr::success('Brand partner updated successfully.', 'Success');
            return redirect()->route('admin.brand-partners.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update brand partner: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(BrandPartner $brandPartner)
    {
        try {
            if ($brandPartner->image && $brandPartner->image !== config('app.DEFAULT_IMAGE') . 'default-brand-partner.jpg') {
                UploadImage::deleteFile($brandPartner->image);
            }
            $brandPartner->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Brand partner deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete brand partner: ' . $e->getMessage(),
            ]);
        }
    }
}