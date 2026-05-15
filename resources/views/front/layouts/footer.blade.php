 <!-- footer area -->
    <footer class="footer-area">
        <div class="footer-shape">
            <img src="assets/img/shape/03.png" alt="">
        </div>
        <div class="footer-widget">
            <div class="container">
                <div class="row footer-widget-wrapper pt-100 pb-70">
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget-box about-us">
                            <a href="#" class="footer-logo">
                                <img src="assets/img/logo/logo-light.png" alt="">
                            </a>
                            <p class="mb-3">
                               Deep Ganga Public School is dedicated to nurturing young minds, fostering academic excellence, and inspiring lifelong learning in a safe and supportive environment.
                            </p>
                            <ul class="footer-contact">
                                <li><a href="tel:+21236547898"><i class="far fa-phone"></i>+91{{$school->mobile}}</a></li>
                                <li><i class="far fa-map-marker-alt"></i>{{ $school->address }}</li>
                                <li><a href="https://live.themewild.com/cdn-cgi/l/email-protection#deb7b0b8b19ebba6bfb3aeb2bbf0bdb1b3"><i
                                            class="far fa-envelope"></i><span class="__cf_email__" data-cfemail="94fdfaf2fbd4f1ecf5f9e4f8f1baf7fbf9">{{ $school->email }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Quick Links</h4>
                            <ul class="footer-list">
                                <li><a href="{{url('about-us')}}"><i class="fas fa-caret-right"></i> About Us</a></li>
                                <li><a href="{{url('/')}}"><i class="fas fa-caret-right"></i> Home</a></li>
                                <li><a href="{{url('academics')}}"><i class="fas fa-caret-right"></i>Academics</a></li>
                                <li><a href="{{ url('terms-conditions') }}"><i class="fas fa-caret-right"></i> Terms Of Service</a></li>
                                <li><a href="#"><i class="fas fa-caret-right"></i> Privacy policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Our Campus</h4>
                            <ul class="footer-list">
                             
                                <li><a href="{{url('admissions')}}"><i class="fas fa-caret-right"></i> Admissions</a></li>
                                <li><a href="{{url('contact-us')}}"><i class="fas fa-caret-right"></i> Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Newsletter</h4>
                            <div class="footer-newsletter">
                                <p>Subscribe Our Newsletter To Get Latest Update And News</p>
                                <div class="subscribe-form">
                                    <form action="#">
                                        <input type="email" class="form-control" placeholder="Your Email">
                                        <button class="theme-btn" type="submit">
                                            Subscribe Now <i class="far fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="copyright-wrapper">
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <p class="copyright-text">
                                &copy; Copyright <span id="date"></span> <a href="#">Deep Ganga Public School</a> All Rights Reserved.
                            </p>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <ul class="footer-social">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a href="{{$school->whatsapp_no}}"><i class="fab fa-whatsapp"></i></a></li>
                                <li><a href="{{$school->youtube}}"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>