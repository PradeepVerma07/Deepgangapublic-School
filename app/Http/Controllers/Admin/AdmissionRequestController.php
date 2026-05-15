<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\AdmissionRequest;
use Illuminate\Http\Request;

class AdmissionRequestController extends MainController
{
    public function index(Request $request)
    {
        $query = AdmissionRequest::query()->with('class');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
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
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        $query->orderBy('created_at', 'desc');
        $admissionRequests = $query->paginate(10);
        $admissionRequests->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Admission Requests';
        $page = 'admin.admission-requests.index';
        return $this->template($page, compact('admissionRequests', 'title'));
    }
}
