@extends('front.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
@endsection
@section('content')

    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url(public/assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title">Contact Us</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->
        <!-- contact area -->
        <div class="contact-area py-120">
            <div class="container">
                <div class="contact-content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-map-location-dot"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Office Address</h5>
                                    <p>{{$school->address}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-phone-volume"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Call Us</h5>
                                    <p>+91{{$school->mobile}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-envelopes"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Email Us</h5>
                                    <p><a href="https://live.themewild.com/cdn-cgi/l/email-protection" class="__cf_email__"
                                            data-cfemail="2841464e47684d50494558444d064b4745">{{$school->email}}</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-alarm-clock"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Open Time</h5>
                                    <p>Mon - Sat (10.00AM - 05.30PM)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-wrapper">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="contact-img">
                                <img src="public/assets/img/contact/01.jpg" alt="">
                            </div>
                        </div>

                        <div class="col-lg-7 align-self-center">
                            <div class="contact-form">
                                <div class="contact-form-header">
                                    <h2>Get In Touch</h2>
                                    <p>It is a long established fact that a reader will be distracted by the readable
                                        content of a page randomised words which don't look even slightly when looking at
                                        its layout.
                                    </p>
                                </div>

                                <form method="post" action="{{ route('contact-us-submit') }}" id="contact-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-success" id="success-message" style="display: none;">
                                                Contact submitted successfully
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="alert alert-danger" id="error-message" style="display: none;">
                                                An error occurred
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" placeholder="Your Name"
                                                    value="{{ old('name') }}" required>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="Your Email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="phone"
                                                    placeholder="Your Phone Number" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Subject -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="subject"
                                                    placeholder="Your Subject" value="{{ old('subject') }}" required>
                                                @error('subject')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Message -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea name="message" cols="30" rows="5" class="form-control"
                                                    placeholder="Write Your Message">{{ old('message') }}</textarea>
                                                @error('message')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Hidden School ID -->
                                        <input type="hidden" name="school_id" value="{{ $school->id }}">

                                        <!-- Submit -->
                                        <div class="col-md-12">
                                            <button type="submit" class="theme-btn">
                                                Send Message <i class="far fa-paper-plane"></i>
                                            </button>
                                        </div>

                                        <!-- Form message -->
                                        <div class="col-md-12 mt-3">
                                            <div class="form-messege text-success"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end contact area -->

        <!-- map -->

        
       <div class="contact-map">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3587.1251347729267!2d83.8218095!3d25.963936099999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39923c499a84d22d%3A0x3c29b0c3fb747322!2sDeep%20Ganga%20Public%20School!5e0!3m2!1sen!2sin!4v1775912058268!5m2!1sen!2sin" 
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>


    </main>
@endsection
@push('scripts')
    <script>

        $(document).ready(function () {
            $('#contact-form').submit(function (e) {
                e.preventDefault();
                var $form = $('#contact-form');
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $('#error-message').hide().text('');
                $('#success-message').hide().text('');

                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    data: $form.serialize(),
                    success: function (response) {
                        if (response && response.status === 'success') {
                            $form[0].reset();
                            $('#success-message').text(response.message || 'Contact submitted successfully').show();
                            $('#error-message').hide();
                        } else {
                            var msg = (response && response.message) ? response.message : 'Please fix the highlighted errors.';
                            $('#error-message').text(msg).show();
                            $('#success-message').hide();
                            if (response && response.errors) {
                                Object.keys(response.errors).forEach(function (field) {
                                    var messages = response.errors[field];
                                    var $input = $form.find('[name="' + field + '"]');
                                    if ($input.length) {
                                        $input.addClass('is-invalid');
                                        $input.closest('.form-group').append('<div class="invalid-feedback" style="display:block;">' + (messages && messages[0] ? messages[0] : 'This field is invalid') + '</div>');
                                    }
                                });
                            }
                        }
                    },
                    error: function (xhr) {
                        if (xhr && xhr.status === 422 && xhr.responseJSON) {
                            var res = xhr.responseJSON;
                            var msg = res.message || 'Please fix the highlighted errors.';
                            $('#error-message').text(msg).show();
                            $('#success-message').hide();
                            if (res.errors) {
                                Object.keys(res.errors).forEach(function (field) {
                                    var messages = res.errors[field];
                                    var $input = $form.find('[name="' + field + '"]');
                                    if ($input.length) {
                                        $input.addClass('is-invalid');
                                        $input.closest('.form-group').append('<div class="invalid-feedback" style="display:block;">' + (messages && messages[0] ? messages[0] : 'This field is invalid') + '</div>');
                                    }
                                });
                            }
                        } else {
                            $('#error-message').text('An error occurred').show();
                            $('#success-message').hide();
                        }
                    }
                });
            });
        });
    </script>
@endpush