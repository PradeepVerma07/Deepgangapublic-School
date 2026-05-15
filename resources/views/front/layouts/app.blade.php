<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ getImageUrl(getSetting('favicon')) }}">
    <title>Deep Ganga Public School</title>
<meta name="description" content="Deep Ganga Public School was established in 2016 at Malap Harsenpur, Nagra Ballia.">
   
    @include('front.layouts.css')
    @stack('css')
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

</head>

<body id="bg">

    <div class="page-wraper">
        @include('front.layouts.header')
        @yield('content')
        @include('front.layouts.footer')
        <button class="scroltop"><span class=" iconmoon-house relative" id="btn-vibrate"></span>Top</button>
    </div>


    <!-- LOADING AREA START ===== -->
    <!-- @if (request()->is('/'))
<div class="preloader">
    <div class="loader-logo">
        <img src="{{ getImageUrl($school->photo) }}" alt="Logo">
    </div>
</div>
@endif -->



    <!-- LOADING AREA  END ====== -->



    @include('front.layouts.scripts')
    @stack('scripts')

    <a href="https://api.whatsapp.com/send?phone=91{{ $school->whatsapp_no }}&text=Hello%20I%20want%20admission%20details"
        target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>

    <style>
        .whatsapp-float {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #25d366, #20b858);
            color: #fff;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            text-decoration: none;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.35);
            z-index: 9999;
            animation: whatsappBounce 2s infinite;
        }

        /* Pulse ring */
        .whatsapp-float::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(37, 211, 102, 0.35);
            animation: whatsappPulse 2s infinite;
            z-index: -1;
        }

        /* Bounce effect */
        @keyframes whatsappBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        /* Pulse ripple */
        @keyframes whatsappPulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.6);
                opacity: 0;
            }
        }

        /* Hover effect */
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.45);
        }

        /* Mobile adjustment */
        @media (max-width: 767px) {
            .whatsapp-float {
                width: 50px;
                height: 50px;
                font-size: 26px;
                bottom: 15px;
                right: 15px;
            }
        }
    </style>


    <div style="
    position:fixed;
    top:140px;
    right:-2px;
    background: linear-gradient(135deg, #012758, #0a4da2);
    color:#fff;
    padding:14px 20px;
    font-size:14px;
    font-weight:800;
    letter-spacing:0.6px;
    border-radius:8px 0 0 8px;
    box-shadow:0 8px 22px rgba(0,0,0,0.35);
    z-index:9999;
    animation: slideInBadge 1.2s ease-out, pulseGlow 2s infinite;
">
        Admissions Open <span style="color:#ffeb3b;">2026</span>
    </div>

    <style>
        @keyframes slideInBadge {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 0 rgba(255, 255, 255, 0.0);
            }

            50% {
                box-shadow: 0 0 18px rgba(255, 255, 255, 0.5);
            }

            100% {
                box-shadow: 0 0 0 rgba(255, 255, 255, 0.0);
            }
        }

        /* Mobile optimization */
        @media (max-width: 767px) {
            div[style*="Admissions Open"] {
                top: 90px !important;
                font-size: 12px !important;
                padding: 10px 14px !important;
            }
        }
    </style>

    <!-- ADMISSION POPUP -->
    <div id="admissionPopup" class="admission-popup">
        <div class="popup-overlay"></div>

        <div class="popup-card">
            <button class="popup-close" onclick="closeAdmissionPopup()">&times;</button>

            <img src="{{ getImageUrl(getSetting('logo')) }}" alt="Deep Ganga Public School">

            <div class="popup-content">
                <h3>Admissions Open 2026</h3>
                <p>Limited seats available. Apply now for quality education.</p>

                <a href="https://api.whatsapp.com/send?phone=91{{ $school->whatsapp_no }}&text=Hello%20I%20want%20admission%20details"
                    target="_blank" class="popup-btn">
                    Enquire on WhatsApp
                </a>
            </div>
        </div>


    </div>
    <style>
        /* Popup wrapper */
        .admission-popup {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: none;
        }

        /* Dark background */
        .popup-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
        }

        /* Card */
        .popup-card {
            position: relative;
            width: 90%;
            max-width: 380px;
            margin: auto;
            top: 50%;
            transform: translateY(-50%) scale(0.9);
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            animation: popupZoom 0.6s ease forwards;
        }

        /* Image */
        .popup-card img {
            width: 100%;
            display: block;
        }

        /* Content */
        .popup-content {
            padding: 18px;
            text-align: center;
        }

        .popup-content h3 {
            margin: 0 0 6px;
            color: #012758;
            font-weight: 800;
        }

        .popup-content p {
            font-size: 14px;
            color: #555;
            margin-bottom: 14px;
        }

        /* Button */
        .popup-btn {
            display: inline-block;
            padding: 10px 18px;
            background: linear-gradient(135deg, #25d366, #20b858);
            color: #fff;
            font-weight: 700;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
        }

        /* Close button */
        .popup-close {
            position: absolute;
            top: 8px;
            right: 10px;
            background: #fff;
            border: none;
            font-size: 22px;
            cursor: pointer;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Animation */
        @keyframes popupZoom {
            from {
                transform: translateY(-50%) scale(0.7);
                opacity: 0;
            }

            to {
                transform: translateY(-50%) scale(1);
                opacity: 1;
            }
        }

        /* Mobile */
        @media(max-width:767px) {
            .popup-card {
                max-width: 320px;
            }
        }
    </style>
    <!-- BOTTOM NEWS TICKER -->
    <div class="bottom-ticker">
        <div class="ticker-label">NOTICE</div>
            <div class="ticker-wrap">
                <div class="ticker-move">
                    <span>Admissions Open for Session 2026</span>
                    <span>Call Us: +91 9839933425</span>
                    <span>Email: dgpsmalap@gmail.com</span>
                    <span>Limited Seats Available - Apply Now</span>

                    <!-- duplicate for seamless loop -->
                    <span>Admissions Open for Session 2026</span>
                    <span>Call Us: +91 9839933425</span>
                    <span>Email: dgpsmalap@gmail.com</span>
                    <span>Limited Seats Available - Apply Now</span>
                </div>
            </div>
    </div>
    <style>
        /* Bottom ticker container */
        .bottom-ticker {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(135deg, #012758, #0a4da2);
            color: #fff;
            display: flex;
            align-items: center;
            z-index: 9998;
            height: 62px;
            font-size: 14px;
            overflow: hidden;
        }

        /* Left label */
        .ticker-label {
            background: #ffcc00;
            color: #000;
            font-weight: 800;
            padding: 0 14px;
            height: 100%;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        /* Scrolling area */
        .ticker-wrap {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        /* Moving text */
        .ticker-move {
            display: flex;
            align-items: center;
            gap: 60px;
            white-space: nowrap;
            width: max-content;
            animation: tickerScroll 25s linear infinite;
        }

       


        .ticker-move span {
            font-weight: 600;
        }

        /* Animation */
        @keyframes tickerScroll {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-50%);
    }
}


        /* Mobile adjustment */
        @media(max-width:767px) {
            .bottom-ticker {
                font-size: 12px;
                height: 38px;
            }

            .ticker-label {
                padding: 0 10px;
            }
        }
    </style>
    <style>
        body {
            padding-bottom: 70px;
        }

        @media(max-width:767px) {
            body {
                padding-bottom: 46px;
            }
        }
    </style>
    <script>


        window.addEventListener("load", function () {

            if (!sessionStorage.getItem("admissionPopupShown")) {
                setTimeout(function () {
                    document.getElementById("admissionPopup").style.display = "block";
                }, 2000);

                sessionStorage.setItem("admissionPopupShown", "yes");
            }
        });

        function closeAdmissionPopup() {
            document.getElementById("admissionPopup").style.display = "none";
        }
    </script>




</body>


</html>
