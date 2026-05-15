@extends('admin.layouts.app')
@section('title', $title)
@section('comp', 'admission-request')
@section('css')
<style>
    .address-column {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5>Admission Requests</h5>
        <form method="GET" action="{{ route('admin.admission-requests.index') }}" class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
            <div class="me-3">
                <div class="input-icon-end position-relative">
                    <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
                </div>
            </div>
            <div class="me-3">
                <div class="input-icon-end position-relative">
                    <input type="text" class="form-control date-range bookingrange" placeholder="dd/mm/yyyy - dd/mm/yyyy" name="date_range" value="{{ request('date_range') }}">
                    <span class="input-icon-addon">
                        <i class="ti ti-chevron-down"></i>
                    </span>
                </div>
            </div>
            <div class="dropdown me-3">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                    {{ request('status') ? request('status') : 'Select Status' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" onclick="this.closest('form').querySelector('[name=status]').value='Pending';this.closest('form').submit();">Pending</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" onclick="this.closest('form').querySelector('[name=status]').value='Approved';this.closest('form').submit();">Approved</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" onclick="this.closest('form').querySelector('[name=status]').value='Rejected';this.closest('form').submit();">Rejected</a>
                    </li>
                </ul>
                <input type="hidden" name="status" value="{{ request('status') }}">
            </div>
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="{{ route('admin.admission-requests.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table no-footer">
                <thead class="thead-light">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Class</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Date of Birth</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $srNo = ($admissionRequests->currentPage() - 1) * $admissionRequests->perPage() + 1; @endphp
                    @foreach($admissionRequests as $request)
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>{{ $request->class ? $request->class->title : 'N/A' }}</td>
                            <td>{{ $request->name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->mobile }}</td>
                            <td class="address-column" title="{{ $request->address }}">{{ \Illuminate\Support\Str::limit($request->address, 50) }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->dob)->format('d/m/Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        {{ $request->status }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1 changeStatus"
                                               data-toggle="change-status"
                                               value="Pending"
                                               data="{{ $request->id }},admission_requests,id,status">Pending</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1 changeStatus"
                                               data-toggle="change-status"
                                               value="Approved"
                                               data="{{ $request->id }},admission_requests,id,status">Approved</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1 changeStatus"
                                               data-toggle="change-status"
                                               value="Rejected"
                                               data="{{ $request->id }},admission_requests,id,status">Rejected</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row p-4">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                        Showing {{ $admissionRequests->firstItem() }} - {{ $admissionRequests->lastItem() }} of {{ $admissionRequests->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    {{ $admissionRequests->links('admin.layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush
