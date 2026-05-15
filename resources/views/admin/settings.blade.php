@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('content')
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    Please correct the errors below.
                </div>
            @endif
            <div class="border-bottom mb-3 pb-3">
                <h4>Settings</h4>
            </div>
            <form action="{{ route('admin.settings.update') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="border-bottom mb-3">
                    <h6 class="mb-3">General Settings</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label mb-md-0">App Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="app_name" id="app_name" value="{{ old('app_name', $settings['app_name'] ?? '') }}" class="form-control">
                                    @if ($errors->has('app_name'))
                                        <span class="text-danger">{{ $errors->first('app_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label mb-md-0">Pagination Settings</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" name="pagination_settings" id="pagination_settings" value="{{ old('pagination_settings', $settings['pagination_settings'] ?? '') }}" class="form-control">
                                    @if ($errors->has('pagination_settings'))
                                        <span class="text-danger">{{ $errors->first('pagination_settings') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label mb-md-0">Images URL</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="imgs_url" id="imgs_url" value="{{ old('imgs_url', $settings['imgs_url'] ?? '') }}" class="form-control">
                                    @if ($errors->has('imgs_url'))
                                        <span class="text-danger">{{ $errors->first('imgs_url') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label mb-md-0">Default Image Path</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="default_image_path" id="default_image_path" value="{{ old('default_image_path', $settings['default_image_path'] ?? '') }}" class="form-control">
                                    @if ($errors->has('default_image_path'))
                                        <span class="text-danger">{{ $errors->first('default_image_path') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label mb-md-0">Upload Path</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="upload_path" id="upload_path" value="{{ old('upload_path', $settings['upload_path'] ?? '') }}" class="form-control">
                                    @if ($errors->has('upload_path'))
                                        <span class="text-danger">{{ $errors->first('upload_path') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="form-label mb-md-0">Delete Path</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="delete_path" id="delete_path" value="{{ old('delete_path', $settings['delete_path'] ?? '') }}" class="form-control">
                                    @if ($errors->has('delete_path'))
                                        <span class="text-danger">{{ $errors->first('delete_path') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-bottom mb-3">
                    <h6 class="mb-3">Appearance Settings</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="logo">Logo (250x60 px)</label>
                                <img src="{{ getImageUrl($settings['logo'] ?? '') }}" alt="Logo" class="img-fluid mb-2" style="max-height: 60px; max-width: 250px; display: block;">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ri-image-line"></i>
                                    </span>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                    @if ($errors->has('logo'))
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label" for="favicon">Favicon (32x32 px)</label>
                                <img src="{{ getImageUrl($settings['favicon'] ?? '') }}" alt="Favicon" class="img-fluid mb-2" style="max-height: 60px; max-width: 250px; display: block;">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ri-image-line"></i>
                                    </span>
                                    <input type="file" class="form-control" id="favicon" name="favicon" accept="image/*">
                                    @if ($errors->has('favicon'))
                                        <span class="text-danger">{{ $errors->first('favicon') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
