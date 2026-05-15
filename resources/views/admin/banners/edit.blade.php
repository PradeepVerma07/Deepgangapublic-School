@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
<style>
    .banner-image {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }
</style>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6"><h5>Edit Banner</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @if($banner->image)
                            <img style="height: 100px" src="{{ getImageUrl($banner->image) }}" alt="Current Image" class="banner-image mt-2">
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="title1" class="form-label">Title 1</label>
                        <input type="text" class="form-control @error('title1') is-invalid @enderror" id="title1" name="title1" value="{{ old('title1', $banner->title1) }}">
                        @error('title1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="title2" class="form-label">Title 2</label>
                        <input type="text" class="form-control @error('title2') is-invalid @enderror" id="title2" name="title2" value="{{ old('title2', $banner->title2) }}">
                        @error('title2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control @error('seq') is-invalid @enderror" id="seq" name="seq" value="{{ old('seq', $banner->seq) }}" min="0">
                        @error('seq')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $banner->description) }}</textarea>
                        @error('description')
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
