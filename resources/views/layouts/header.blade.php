 <header class="header">
        <!-- header top -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrap">
                    <div class="header-top-left">
                        <div class="header-top-social">
                            <span>Follow Us: </span>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                    <div class="header-top-right">
                        <div class="header-top-contact">
                            <ul>
                                <li>
                                    <a href="#"><i class="far fa-location-dot"></i> 25/B Milford Road, New York</a>
                                </li>
                                <li>
                                    <a href="https://live.themewild.com/cdn-cgi/l/email-protection#e1888f878ea18499808c918d84cf828e8c"><i class="far fa-envelopes"></i> <span class="__cf_email__" data-cfemail="9cf5f2faf3dcf9e4fdf1ecf0f9b2fff3f1">[email&#160;protected]</span></a>
                                </li>
                                <li>
                                    <a href="tel:+21236547898"><i class="far fa-phone-volume"></i> +2 123 654 7898</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container position-relative">
                    <a class="navbar-brand" href="index.html">
                        <img src="assets/img/logo/logo.png" alt="logo">
                    </a>
                    <div class="mobile-menu-right">
                        <div class="search-btn">
                            <button type="button" class="nav-right-link search-box-outer"><i
                                    class="far fa-search"></i></button>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-mobile-icon"><i class="far fa-bars"></i></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('academics') }}">Academics</a>
                            </li>
                
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('about') }}">About Us</a>

                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Admissions</a>
                                <ul class="dropdown-menu fade-down">
                                    <li><a class="dropdown-item" href="{{ route('how.to.apply') }}">How To Apply</a></li>
                                    
                                    <li><a class="dropdown-item" href="{{ route('tuition.fee') }}">Tuition Fees</a></li>
                                    <li><a class="dropdown-item" href="{{ route('facilities') }}">Our Facilities</a></li>

                                    <li><a class="dropdown-item" href="{{ route('excellence') }}">Student Excellence</a></li>
                                </ul>
                            </li>

                            <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact Us</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('media') }}">Media gallery</a></li>
                        </ul>
                        <div class="nav-right">

                            <div class="nav-right-btn mt-2">
                                <a href="{{ route('application') }}" class="theme-btn"><span
                                        class="fal fa-pencil"></span>Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>