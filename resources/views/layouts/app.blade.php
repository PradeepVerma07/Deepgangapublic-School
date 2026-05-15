<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'NoLaundry | Admin Panel')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Include stylesheets --}}
     <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- title -->
    <title>Eduka - School, College, University And Courses HTML5 Template</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.png">

    <!-- css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    @stack('head')
</head>

<body>
    {{-- Add sidebar/header here if needed globally --}}
        @include('layouts.header')

        <div class="d-flex">
            {{-- Sidebar section: either default or custom --}}

            {{-- Page content --}}
            <div class="main-area flex-grow-1">
                @yield('content')
            </div>

    {{-- Global scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery library js -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Apex Chart js -->
    <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
    <!-- Data Table js -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>

    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Popup js -->
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <!-- prism js -->
    <script src="{{ asset('assets/js/lib/prism.js') }}"></script>
    <!-- file upload js -->
    <script src="{{ asset('assets/js/lib/file-upload.js') }}"></script>
    <!-- audioplayer -->
    <script src="{{ asset('assets/js/lib/audioplayer.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('mapbox-scripts')
    {{-- Page-specific scripts --}}
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    // Start fade out
                    alert.classList.remove('show');
                    alert.classList.add('hide');

                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                });
            }, 3000);
        });
    </script>
</body>


</html>
