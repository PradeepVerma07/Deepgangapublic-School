@extends('admin.layouts.app')
@section('title', $title)
@section('comp', 'website-menu')
@section('css')
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6"><h5>Edit Website Menu</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.website-menus.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.website-menus.update', $websiteMenu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $websiteMenu->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="parent_id" class="form-label">Parent Menu</label>
                        <select class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                            <option value="">None (Main Menu)</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $websiteMenu->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control @error('seq') is-invalid @enderror" id="seq" name="seq" value="{{ old('seq', $websiteMenu->seq) }}" min="0">
                        @error('seq')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
@endpush
