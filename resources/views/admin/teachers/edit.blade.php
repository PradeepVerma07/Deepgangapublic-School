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
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6"><h5>Edit Teacher</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="class_id" class="form-label required">Class</label>
                        <select class="form-control @error('class_id') is-invalid @enderror" id="class_id" name="class_id">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $teacher->class_id) == $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $teacher->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="form-group">
                        <label for="dob" class="form-label required">Date of Birth</label>
                        <input type="text" class="form-control datepicker @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob', \Carbon\Carbon::parse($teacher->dob)->format('d/m/Y')) }}" placeholder="dd/mm/yyyy">
                        @error('dob')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $teacher->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="mobile" class="form-label required">Mobile</label>
                        <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $teacher->mobile) }}">
                        @error('mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="subject" class="form-label required">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', $teacher->subject) }}">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="qualification" class="form-label required">Qualification</label>
                        <input type="text" class="form-control @error('qualification') is-invalid @enderror" id="qualification" name="qualification" value="{{ old('qualification', $teacher->qualification) }}">
                        @error('qualification')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @if($teacher->image)
                            <img src="{{ getImageUrl($teacher->image) }}" alt="Current Image" class="teacher-image mt-2" style="height:100px;">
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control @error('seq') is-invalid @enderror" id="seq" name="seq" value="{{ old('seq', $teacher->seq) }}" min="0">
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
<script>
    $(document).ready(function() {
        $('.datepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
    });
</script>
@endpush
