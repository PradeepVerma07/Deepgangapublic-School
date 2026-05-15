<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="{{ $comp }} - School Administration Login">
    <meta name="keywords" content="school, administrator, login, students, teachers, management, {{ $comp }}">
    <meta name="author" content="{{ $comp }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} - {{ $comp }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ getImageUrl(getSetting('favicon')) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ getImageUrl(getSetting('favicon')) }}">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/plugins/icons/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/assets/css/style.css') }}">
    <style>
        .custom-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            z-index: 99999;
            left: 69%;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body class="bg-white">
    <div id="custom-loader" style="display: none;">
        <div class="spinner"></div>
    </div>
    <div class="main-wrapper">
        <div class="container-fuild">
            <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="login-background position-relative d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100">
                            <div class="bg-overlay-img">
                                <img src="{{ asset('public/backend/assets/img/bg/bg-01.png') }}" class="bg-1" alt="Img">
                                <img src="{{ asset('public/backend/assets/img/bg/bg-02.png') }}" class="bg-2" alt="Img">
                                <img src="{{ asset('public/backend/assets/img/bg/bg-03.png') }}" class="bg-3" alt="Img">
                            </div>
                            <div class="authentication-card w-100">
                                <div class="authen-overlay-item border w-100">
                                    <h1 class="text-white display-1">Shaping the future <br> through seamless <br> School Management.</h1>
                                    <div class="my-4 mx-auto authen-overlay-img">
                                        <img src="{{ asset('public/backend/assets/img/bg/authentication-bg-01.png') }}" alt="Img">
                                    </div>
                                    <div>
                                        <p class="text-white fs-20 fw-semibold text-center">Manage academics <br> effortlessly with {{ $comp }}.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                            <div class="col-md-7 mx-auto vh-100">
                                <div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
                                    <div class="mx-auto mb-5 text-center w-50">
                                        <img src="{{ getImageUrl(getSetting('logo')) }}" class="img-fluid" style="height: 200px" alt="{{ $comp }} Logo">
                                    </div>

                                    <div class="">
                                        <div class="text-center mb-3">
                                            <h2 class="mb-2">Administrator Login</h2>
                                            <p class="mb-0">Access the {{ $comp }} Salon Management System</p>
                                        </div>

                                        <div id="error-message" class="text-danger mb-3" style="display: none;"></div>

                                        <form id="login-form" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label">Email Address</label>
                                                <div class="input-group">
                                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control border-end-0" placeholder="Enter your email">
                                                    <span class="input-group-text border-start-0">
                                                        <i class="ti ti-mail"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <div class="pass-group">
                                                    <input type="password" name="password" class="pass-input form-control" placeholder="Enter your password">
                                                    <span class="ti toggle-password ti-eye-off"></span>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-check-md mb-0">
                                                        <input class="form-check-input" id="remember_me" type="checkbox" name="remember">
                                                        <label for="remember_me" class="form-check-label mt-0">Remember Me</label>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <a href="javascript:void(0);" class="link-danger">Forgot Password?</a>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary w-100">Login</button>
                                            </div>
                                        </form>

                                        <div id="school-selection" style="display: none;">
                                            <div class="mb-3">
                                                <label class="form-label">Select Salon</label>
                                                <select name="school_id" id="school_id" class="form-control">
                                                    <option value="">Select a Salon</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button type="button" id="school-submit" class="btn btn-primary w-100">Continue</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5 pb-4 text-center">
                                        <p class="mb-0 text-gray-9">Copyright &copy; {{ date('Y') }} - {{ $comp }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/backend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/backend/assets/js/feather.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#login-form').on('submit', function (e) {
                e.preventDefault();
                $('#error-message').hide().text('');
                $('#custom-loader').show();

                $.ajax({
                    url: "{{ route('admin.login.post') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#custom-loader').hide();
                        if (response.status === 'success') {
                            window.location.href = response.redirect;
                        } else if (response.status === 'school_selection') {
                            $('#login-form').hide();
                            $('#school-selection').show();
                            $('#school_id').empty().append('<option value="">Select a Salon</option>');
                            response.schools.forEach(function (school) {
                                $('#school_id').append('<option value="' + school.id + '">' + school.name + '</option>');
                            });
                        } else {
                            $('#error-message').text(response.message).show();
                        }
                    },
                    error: function (xhr) {
                        $('#custom-loader').hide();
                        $('#error-message').text(xhr.responseJSON?.message || 'An error occurred').show();
                    }
                });
            });

            $('#school-submit').on('click', function () {
                var schoolId = $('#school_id').val();
                if (!schoolId) {
                    $('#error-message').text('Please select a Salon').show();
                    return;
                }

                $('#custom-loader').show();
                $.ajax({
                    url: '{{ route("admin.select.school") }}',
                    method: 'POST',
                    data: {
                        school_id: schoolId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#custom-loader').hide();
                        if (response.status === 'success') {
                            window.location.href = response.redirect;
                        } else {
                            $('#error-message').text(response.message).show();
                        }
                    },
                    error: function (xhr) {
                        $('#custom-loader').hide();
                        $('#error-message').text(xhr.responseJSON?.message || 'An error occurred').show();
                    }
                });
            });
            $('.toggle-password').on('click', function () {
                var input = $(this).siblings('.pass-input');
                var icon = $(this);
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ti-eye-off').addClass('ti-eye');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ti-eye').addClass('ti-eye-off');
                }
            });
        });
    </script>
</body>
</html>
