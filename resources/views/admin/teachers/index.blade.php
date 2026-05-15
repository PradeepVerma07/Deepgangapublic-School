@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
<style>
    .teacher-image {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5>Teachers</h5>
        <form method="GET" action="{{ route('admin.teachers.index') }}" class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
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
                    {{ request('status') ? (request('status') == 1 ? 'Active' : 'Inactive') : 'Select Status' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" onclick="this.closest('form').querySelector('[name=status]').value='1';this.closest('form').submit();">Active</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item rounded-1" onclick="this.closest('form').querySelector('[name=status]').value='0';this.closest('form').submit();">Inactive</a>
                    </li>
                </ul>
                <input type="hidden" name="status" value="{{ request('status') }}">
            </div>
            <button type="submit" class="btn btn-primary">Apply Filters</button>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table no-footer">
                <thead class="thead-light">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Image</th>
                        <th>Class</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Subject</th>
                        <th>Qualification</th>
                        <th>D.O.B</th>
                        <th>Sequence</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $srNo = ($teachers->currentPage() - 1) * $teachers->perPage() + 1; @endphp
                    @foreach($teachers as $teacher)
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>
                                @if($teacher->image)
                                <a href="javascript:void(0);" class="avatar avatar-md border avatar-rounded">
                                    <img src="{{ getImageUrl($teacher->image) }}" alt="Teacher Image" class="img-fluid">
                                </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $teacher->class ? $teacher->class->title : 'N/A' }}</td>
                            <td>{{ $teacher->name }}</td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->mobile }}</td>
                            <td>{{ $teacher->subject }}</td>
                            <td>{{ $teacher->qualification }}</td>
                            <td>{{ \Carbon\Carbon::parse($teacher->dob)->format('d/m/Y') }}</td>
                            <td>
                                <input type="number" value="{{ $teacher->seq}}" data="{{ $teacher->id }},teachers,id,seq" class="change-indexing form-control text-center" style="width:80px" min="0">
                            </td>
                            <td>
                                <span class="changeStatus"
                                    data-toggle="change-status"
                                    value="{{ ($teacher->active == 1) ? 0 : 1 }}"
                                    data="{{ $teacher->id }},teachers,id,active">
                                    <i class="{{ ($teacher->active == 1) ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark' }}"
                                    title="Click to change status"></i>
                                </span>
                            </td>
                            <td>
                                <div class="action-icon d-inline-flex">
                                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="me-2"><i class="ti ti-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="_delete(this)"
                                        url="{{ route('admin.teachers.destroy', $teacher->id) }}"
                                        type="button" title="Delete {{ $teacher->name }}">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row p-4">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                        Showing {{ $teachers->firstItem() }} - {{ $teachers->lastItem() }} of {{ $teachers->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    {{ $teachers->links('admin.layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-buttons')
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="mb-2">
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Teacher</a>
        </div>
        <div class="head-icons ms-2">
            <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
                <i class="ti ti-chevrons-up"></i>
            </a>
        </div>
    </div>
@endpush
@push('scripts')
@endpush
