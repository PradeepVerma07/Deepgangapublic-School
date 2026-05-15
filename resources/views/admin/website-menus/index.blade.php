@extends('admin.layouts.app')
@section('title', $title)
@section('comp', 'website-menu')
@section('css')
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5>Website Menus</h5>
        <form method="GET" action="{{ route('admin.website-menus.index') }}" class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
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
            <a href="{{ route('admin.website-menus.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table no-footer">
                <thead class="thead-light">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Parent Menu</th>
                        <th>Sequence</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $srNo = ($menus->currentPage() - 1) * $menus->perPage() + 1; @endphp
                    @foreach($menus as $menu)
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>{{ $menu->title }}</td>
                            <td>{{ $menu->slug }}</td>
                            <td>{{ $menu->parent ? $menu->parent->title : 'None' }}</td>
                            <td>
                                <input type="number" value="{{ $menu->seq}}" data="{{ $menu->id }},website_menus,id,seq" class="change-indexing form-control text-center" style="width:80px" min="0">
                            </td>
                            <td>
                                <span class="changeStatus"
                                    data-toggle="change-status"
                                    value="{{ ($menu->active == 1) ? 0 : 1 }}"
                                    data="{{ $menu->id }},website_menus,id,active">
                                    <i class="{{ ($menu->active == 1) ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark' }}"
                                    title="Click to change status"></i>
                                </span>
                            </td>
                            <td>
                                <div class="action-icon d-inline-flex">
                                    <a href="{{ route('admin.website-menus.edit', $menu->id) }}" class="me-2"><i class="ti ti-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="_delete(this)"
                                        url="{{ route('admin.website-menus.destroy', $menu->id) }}"
                                        type="button" title="Delete {{ $menu->title }}">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row p-4">
                <div class="col-sm-12 col-md-5" style="float: left">
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                        Showing {{ $menus->firstItem() }} - {{ $menus->lastItem() }} of {{ $menus->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    {{ $menus->links('admin.layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-buttons')
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="mb-2">
            <a href="{{ route('admin.website-menus.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Menu</a>
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
