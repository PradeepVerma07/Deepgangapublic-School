@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6"><h5>Edit Menu</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.menus.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="parent" class="form-label">Parent Menu</label>
                        <select class="form-select @error('parent') is-invalid @enderror" id="parent" name="parent">
                            <option value="" {{ old('parent', $menu->parent) == 0 ? 'selected' : '' }}>None</option>
                            @foreach($menus as $parentMenu)
                                <option value="{{ $parentMenu->id }}" {{ old('parent', $menu->parent) == $parentMenu->id ? 'selected' : '' }}>{{ $parentMenu->title }}</option>
                            @endforeach
                        </select>
                        @error('parent')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $menu->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="url" class="form-label required">URL</label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" value="{{ old('url', $menu->url) }}">
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="icon" class="form-label required">Icon</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $menu->icon) }}" placeholder="e.g., ti ti-settings">
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control @error('seq') is-invalid @enderror" id="seq" name="seq" value="{{ old('seq', $menu->seq) }}">
                        @error('seq')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
</script>
@endpush
