@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
@endsection
@section('content')
    <div class="card" data-select2-id="select2-data-18-n73k">
        <div class="card-body" data-select2-id="select2-data-17-uvh6">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    Please correct the errors below.
                </div>
            @endif
            <div class="border-bottom mb-3 pb-3">
                <h4>Profile</h4>
            </div>
            <form action="{{ route('admin.profile.update') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="border-bottom mb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h6 class="mb-3">Basic Information</h6>
                                <div class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                    <div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                        <img src="{{ getIMageUrl($user->photo) }}" alt="">
                                    </div>
                                    <div class="profile-upload">
                                        <div class="mb-2">
                                            <h6 class="mb-1">Profile Photo</h6>
                                            <p class="fs-12">Recommended image size is 40px x 40px</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Photo/Logo</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="file" name="photo" id="photo" class="form-control">
                                    @if ($errors->has('photo'))
                                        <span class="text-danger">{{ $errors->first('photo') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Name</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Email</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Mobile</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" name="mobile" id="mobile" value="{{ old('mobile', $user->mobile) }}" class="form-control">
                                    @if ($errors->has('mobile'))
                                        <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($user->role_id == 2)
                <div class="border-bottom mb-3" data-select2-id="select2-data-15-43cf">
                    <h6 class="mb-3">Address Information</h6>
                    <div class="row" data-select2-id="select2-data-14-gv4m">
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Address</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $user->address) }}">
                                    @if ($errors->has('address'))
                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Pincode</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="pincode" id="pincode" value="{{ old('pincode', $user->pincode) }}">
                                    @if ($errors->has('pincode'))
                                        <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-1">
                                    <label class="form-label mb-md-0">Map Link</label>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="map_link" id="map_link" value="{{ old('map_link', $user->map_link) }}">
                                    @if ($errors->has('map_link'))
                                        <span class="text-danger">{{ $errors->first('map_link') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Secondary Mobile</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="mobile2" id="mobile2" value="{{ old('mobile2', $user->mobile2) }}">
                                    @if ($errors->has('mobile2'))
                                        <span class="text-danger">{{ $errors->first('mobile2') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Secondary Email</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="email" class="form-control" name="secondary_email" id="secondary_email" value="{{ old('secondary_email', $user->secondary_email) }}">
                                    @if ($errors->has('secondary_email'))
                                        <span class="text-danger">{{ $errors->first('secondary_email') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Facebook</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="facebook" id="facebook" value="{{ old('facebook', $user->facebook) }}">
                                    @if ($errors->has('facebook'))
                                        <span class="text-danger">{{ $errors->first('facebook') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Instagram</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="instagram" id="instagram" value="{{ old('instagram', $user->instagram) }}">
                                    @if ($errors->has('instagram'))
                                        <span class="text-danger">{{ $errors->first('instagram') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Youtube</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="youtube" id="youtube" value="{{ old('youtube', $user->youtube) }}">
                                    @if ($errors->has('youtube'))
                                        <span class="text-danger">{{ $errors->first('youtube') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="form-label mb-md-0">Whatsapp No</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" name="whatsapp_no" id="whatsapp_no" value="{{ old('whatsapp_no', $user->whatsapp_no) }}">
                                    @if ($errors->has('whatsapp_no'))
                                        <span class="text-danger">{{ $errors->first('whatsapp_no') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            <form action="{{ route('admin.profile.change_password') }}" class="form" method="POST">
                @csrf
                <div class="border-bottom mb-3">
                    <h6 class="mb-3">Change Password</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-5">
                                    <label class="form-label mb-md-0">Current Password</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="pass-group">
                                        <input type="password" id="password" name="password" class="pass-input form-control" value="{{ old('password') }}">
                                        <span class="ti toggle-password ti-eye-off"></span>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-5">
                                    <label class="form-label mb-md-0">New Password</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="pass-group">
                                        <input type="password" name="new_password" id="new_password" class="pass-inputs form-control" value="{{ old('new_password') }}">
                                        <span class="ti toggle-passwords ti-eye-off"></span>
                                        @if ($errors->has('new_password'))
                                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-5">
                                    <label class="form-label mb-md-0">Confirm Password</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="pass-group">
                                        <input type="password" name="new_password_confirmation" id="confirm_password" class="pass-inputa form-control" value="{{ old('new_password_confirmation') }}">
                                        <span class="ti toggle-passworda ti-eye-off"></span>
                                        @if ($errors->has('confirm_password'))
                                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
