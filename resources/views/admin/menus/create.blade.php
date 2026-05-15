@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6"><h5>Create Menu</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.menus.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.menus.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="parent" class="form-label">Parent Menu</label>
                        <select class="form-select" id="parent" name="parent">
                            <option value="0" {{ old('parent') == 0 ? 'selected' : '' }}>None</option>
                            @foreach($menus as $parentMenu)
                                <option value="{{ $parentMenu->id }}" {{ old('parent') == $parentMenu->id ? 'selected' : '' }}>{{ $parentMenu->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="url" class="form-label required">URL</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="icon" class="form-label required">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}" placeholder="e.g., ti ti-settings">
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control" id="seq" name="seq" value="{{ old('seq') }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
@endpush
