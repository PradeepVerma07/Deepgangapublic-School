<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\MembershipOffer;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Helpers\UploadImage;
use Exception;
use Illuminate\Support\Facades\Log;

class MembershipOfferController extends MainController
{
    public function index(Request $request)
    {
        $query = MembershipOffer::query();
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
        $membershipOffers = $query->paginate(10);
        $membershipOffers->appends($request->only(['date_range', 'status']));

        $title = 'Membership Offers';
        $page = 'admin.membership-offers.index';
        return $this->template($page, compact('membershipOffers', 'title'));
    }

    public function create()
    {
        $title = 'Create Membership Offer';
        return $this->template('admin.membership-offers.create', compact('title'));
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
            Toastr::error('You do not have permission to create a membership offer.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'seq' => $request->input('seq'),
                'school_id' => $user->school_id,
                'active' => 1,
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', null, 'membership-offers', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            MembershipOffer::create($data);
            Toastr::success('Membership offer created successfully.', 'Success');
            return redirect()->route('admin.membership-offers.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create membership offer: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(MembershipOffer $membershipOffer)
    {
        $title = 'Edit Membership Offer';
        return $this->template('admin.membership-offers.edit', compact('membershipOffer', 'title'));
    }

    public function update(Request $request, MembershipOffer $membershipOffer)
    {
        $request->validate([
            'image' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a membership offer.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'seq' => $request->input('seq'),
            ];

            if ($request->hasFile('image')) {
                $upload = UploadImage::upload($request, 'image', $membershipOffer->image, 'membership-offers', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['image'] = $upload['file_path'];
            }

            $membershipOffer->update($data);
            Toastr::success('Membership offer updated successfully.', 'Success');
            return redirect()->route('admin.membership-offers.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update membership offer: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(MembershipOffer $membershipOffer)
    {
        try {
            if ($membershipOffer->image && $membershipOffer->image !== config('app.DEFAULT_IMAGE') . 'default-membership-offer.jpg') {
                UploadImage::deleteFile($membershipOffer->image);
            }
            $membershipOffer->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Membership offer deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete membership offer: ' . $e->getMessage(),
            ]);
        }
    }
}