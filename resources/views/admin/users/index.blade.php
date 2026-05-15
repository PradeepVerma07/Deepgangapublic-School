@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5>User List</h5>
        <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
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
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table no-footer">
                <thead class="thead-light">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Role</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $srNo = ($users->currentPage() - 1) * $users->perPage() + 1; @endphp
                    @foreach($users as $userRow)
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>{{ $userRow->name }}</td>
                            <td>{{ $userRow->email }}</td>
                            <td>{{ $userRow->mobile ?? 'N/A' }}</td>
                            <td>{{ $userRow->role ? $userRow->role->title : 'None' }}</td>
                            <td>
                                @if($userRow->photo)
                                    <img src="{{ getImageUrl($userRow->photo) }}" alt="User Photo" style="max-width: 50px;">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <span class="changeStatus"
                                    data-toggle="change-status"
                                    value="{{ ($userRow->active == 1) ? 0 : 1 }}"
                                    data="{{ $userRow->id }},users,id,active">
                                    <i class="{{ ($userRow->active == 1) ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark' }}"
                                    title="Click to change status"></i>
                                </span>
                            </td>
                            <td>
                                <div class="action-icon d-inline-flex">
                                    <a href="{{ route('admin.users.edit', $userRow->id) }}" class="me-2"><i class="ti ti-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="_delete(this)"
                                        url="{{ route('admin.users.destroy', $userRow->id) }}"
                                        type="button" title="Delete {{ $userRow->name }}">
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
                        Showing {{ $users->firstItem() }} - {{ $users->lastItem() }} of {{ $users->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    {{ $users->links('admin.layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-buttons')
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="mb-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add User</a>
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
