@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
<style>
    .news-image {
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
            <div class="col-lg-6"><h5>Edit News Item</h5></div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('admin.latest-news.index') }}" class="btn btn-sm btn-danger">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.latest-news.update', $latestNews->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="title" class="form-label required">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $latestNews->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="date" class="form-label required">Date</label>
                        <input type="text" class="form-control datepicker @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($latestNews->date)->format('d/m/Y')) }}" placeholder="dd/mm/yyyy">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label for="description" class="form-label required">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $latestNews->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @if($latestNews->image)
                            <img style="height: 100px" src="{{ getImageUrl($latestNews->image) }}" alt="Current Image" class="news-image mt-2">
                        @endif
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-group">
                        <label for="seq" class="form-label required">Sequence</label>
                        <input type="number" class="form-control @error('seq') is-invalid @enderror" id="seq" name="seq" value="{{ old('seq', $latestNews->seq) }}" min="0">
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
