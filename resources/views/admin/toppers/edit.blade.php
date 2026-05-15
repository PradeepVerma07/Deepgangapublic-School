@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
<style>
    .topper-image {
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
            <div class="col-lg-6"><h5>Edit Topper</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.toppers.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.toppers.update', $topper->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="class_id" class="form-label required">Class</label>
                        <select class="form-control @error('class_id') is-invalid @enderror" id="class_id" name="class_id">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $topper->class_id) == $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $topper->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="marks" class="form-label required">Marks</label>
                        <input type="text" class="form-control @error('marks') is-invalid @enderror" id="marks" name="marks" value="{{ old('marks', $topper->marks) }}">
                        @error('marks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="year" class="form-label required">Year</label>
                        <input type="text" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', $topper->year) }}" maxlength="4">
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @if($topper->image)
                            <img src="{{ getImageUrl($topper->image) }}" alt="Current Image" class="topper-image mt-2" style="height:100px;">
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control @error('seq') is-invalid @enderror" id="seq" name="seq" value="{{ old('seq', $topper->seq) }}" min="0">
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
