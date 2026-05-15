@extends('admin.layouts.app')
@section('title', $title)
@section('comp', 'section')
@section('css')
<style>
    .content-column {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .files-column {
        max-width: 300px;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
        <h5>Sections</h5>
        <form method="GET" action="{{ route('admin.sections.index') }}" class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
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
            <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary ms-2">Reset</a>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table no-footer">
                <thead class="thead-light">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Menu</th>
                        <th>Type</th>
                        <th>Content/Headings</th>
                        <th>Files</th>
                        <th>Sequence</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $srNo = ($sections->currentPage() - 1) * $sections->perPage() + 1; @endphp
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $srNo++ }}</td>
                            <td>{{ $section->menu ? $section->menu->title : 'N/A' }}</td>
                            <td>{{ ucfirst($section->type) }}</td>
                            <td class="content-column" title="{{ $section->content ?? ($section->files ? implode(', ', array_column($section->files, 'heading')) : '') }}">
                                {{ $section->content ? Str::limit(strip_tags($section->content), 50) : ($section->files ? Str::limit(implode(', ', array_column($section->files, 'heading')), 50) : 'N/A') }}
                            </td>
                            <td class="files-column">
                                @if($section->files)
                                    @foreach($section->files as $file)
                                        <div>
                                            <a href="{{ asset($file['file_path']) }}" target="_blank">{{ $file['heading'] }} ({{ pathinfo($file['file_path'], PATHINFO_EXTENSION) }})</a>
                                        </div>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $section->seq }}</td>
                            <td>
                                <span class="changeStatus"
                                    data-toggle="change-status"
                                    value="{{ ($section->active == 1) ? 0 : 1 }}"
                                    data="{{ $section->id }},sections,id,active">
                                    <i class="{{ ($section->active == 1) ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark' }}"
                                    title="Click to change status"></i>
                                </span>
                            </td>
                            <td>
                                <div class="action-icon d-inline-flex">
                                    <a href="{{ route('admin.sections.edit', $section->id) }}" class="me-2"><i class="ti ti-edit"></i></a>
                                    <a href="javascript:void(0);" onclick="_delete(this)"
                                        url="{{ route('admin.sections.destroy', $section->id) }}"
                                        type="button" title="Delete Section">
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
                        Showing {{ $sections->firstItem() }} - {{ $sections->lastItem() }} of {{ $sections->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    {{ $sections->links('admin.layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-buttons')
    <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
        <div class="mb-2">
            <a href="{{ route('admin.sections.create') }}" class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Section</a>
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
