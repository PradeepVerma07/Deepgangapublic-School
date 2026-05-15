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
                <h2 class="breadcrumb-title">About Us</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">About Us</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- about area -->
        <div class="about-area py-120">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <img class="img-1" src="public/assets/img/about/01.jpg" alt="">
                                        <div class="about-experience mt-4">
                                            <div class="about-experience-icon">
                                                <img src="public/assets/img/icon/exchange-idea.svg" alt="">
                                            </div>
                                            <b class="text-start">Establish year- 2016</b>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img class="img-2" src="public/assets/img/about/02.jpg" alt="">
                                        <img class="img-3 mt-4" src="public/assets/img/about/03.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> About Us</span>
                                <h2 class="site-title">
                                    A Place Where <span>Learning</span> Inspires Growth
                                </h2>
                            </div>
                            <p class="about-text">
                               Deep Ganga Public School is committed to providing quality education that nurtures
                                curiosity,
                                creativity, and confidence in every student. Our approach to learning blends academics,
                                technology, and values to help students become responsible and successful individuals.
                            </p>
                            <div class="about-content">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="about-item">
                                            <div class="about-item-icon">
                                                <img src="public/assets/img/icon/open-book.svg" alt="">
                                            </div>
                                            <div class="about-item-content">
                                                <h5>Comprehensive Education</h5>
                                                <p>We provide a balanced academic curriculum enriched with co-curricular and
                                                    extracurricular programs for holistic development.</p>
                                            </div>
                                        </div>
                                        <div class="about-item">
                                            <div class="about-item-icon">
                                                <img src="public/assets/img/icon/global-education.svg" alt="">
                                            </div>
                                            <div class="about-item-content">
                                                <h5>Global Learning Vision</h5>
                                                <p>Our programs encourage global awareness, cultural understanding, and
                                                    lifelong learning beyond the classroom.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="about-quote">
                                            <p>“Education is the most powerful tool that shapes the future — at TDL, we
                                                shape
                                                leaders with knowledge and integrity.”</p>
                                            <i class="far fa-quote-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="about-bottom">
                                <a href="about.html" class="theme-btn">Discover More<i
                                        class="fas fa-arrow-right-long"></i></a>
                                <div class="about-phone">
                                    <div class="icon"><i class="fal fa-headset"></i></div>
                                    <div class="number">
                                        <span>Call Now</span>
                                        <h6><a href="tel:+919630209612">+91 9630209612</a></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- testimonial area -->
        <div class="testimonial-area bg py-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="site-heading text-center">
                    <span class="site-title-tagline">
                        <i class="far fa-book-open-reader"></i> Testimonials
                    </span>
                    <h2 class="site-title">
                        What Our Students <span>Say</span>
                    </h2>
                    <p>
                        Hear from our students about their experience at Deep Ganga Public School,
                        where learning meets growth and success.
                    </p>
                </div>
            </div>
        </div>

        <div class="testimonial-slider owl-carousel owl-theme">

            <!-- Testimonial 1 -->
            <div class="testimonial-item">
                <div class="testimonial-rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="testimonial-quote">
                    <p>
                        Deep Ganga Public School has provided me with a strong academic foundation
                        along with valuable life skills. The teachers are very supportive and always
                        encourage us to do our best.
                    </p>
                </div>
                <div class="testimonial-content">
                    <div class="testimonial-author-img">
                        <img src="public/assets/img/testimonial/01.jpg" alt="">
                    </div>
                    <div class="testimonial-author-info">
                        <h4>Rahul Sharma</h4>
                        <p>Student</p>
                    </div>
                </div>
                <span class="testimonial-quote-icon">
                    <i class="far fa-quote-right"></i>
                </span>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-item">
                <div class="testimonial-rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="testimonial-quote">
                    <p>
                        I feel proud to be a student of Deep Ganga Public School. The environment
                        is friendly, and the teaching methods make learning interesting and easy
                        to understand.
                    </p>
                </div>
                <div class="testimonial-content">
                    <div class="testimonial-author-img">
                        <img src="public/assets/img/testimonial/02.jpg" alt="">
                    </div>
                    <div class="testimonial-author-info">
                        <h4>Priya Verma</h4>
                        <p>Student</p>
                    </div>
                </div>
                <span class="testimonial-quote-icon">
                    <i class="far fa-quote-right"></i>
                </span>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-item">
                <div class="testimonial-rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="testimonial-quote">
                    <p>
                        The school focuses not only on studies but also on personality development.
                        I have gained confidence and improved my communication skills here.
                    </p>
                </div>
                <div class="testimonial-content">
                    <div class="testimonial-author-img">
                        <img src="public/assets/img/testimonial/03.jpg" alt="">
                    </div>
                    <div class="testimonial-author-info">
                        <h4>Aman Singh</h4>
                        <p>Student</p>
                    </div>
                </div>
                <span class="testimonial-quote-icon">
                    <i class="far fa-quote-right"></i>
                </span>
            </div>

            <!-- Testimonial 4 -->
            <div class="testimonial-item">
                <div class="testimonial-rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="testimonial-quote">
                    <p>
                        Deep Ganga Public School offers excellent facilities and a safe environment.
                        The teachers guide us at every step and help us achieve our goals.
                    </p>
                </div>
                <div class="testimonial-content">
                    <div class="testimonial-author-img">
                        <img src="public/assets/img/testimonial/04.jpg" alt="">
                    </div>
                    <div class="testimonial-author-info">
                        <h4>Neha Patel</h4>
                        <p>Student</p>
                    </div>
                </div>
                <span class="testimonial-quote-icon">
                    <i class="far fa-quote-right"></i>
                </span>
            </div>

            <!-- Testimonial 5 -->
            <div class="testimonial-item">
                <div class="testimonial-rate">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <div class="testimonial-quote">
                    <p>
                        It is one of the best schools for overall development. The combination of
                        academics, discipline, and extracurricular activities is truly impressive.
                    </p>
                </div>
                <div class="testimonial-content">
                    <div class="testimonial-author-img">
                        <img src="public/assets/img/testimonial/05.jpg" alt="">
                    </div>
                    <div class="testimonial-author-info">
                        <h4>Rohit Kumar</h4>
                        <p>Student</p>
                    </div>
                </div>
                <span class="testimonial-quote-icon">
                    <i class="far fa-quote-right"></i>
                </span>
            </div>

        </div>
    </div>
</div>
        <!-- testimonial area end -->


        <!-- team-area -->
        <div class="team-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Our Teachers</span>
                            <h2 class="site-title">Meet With Our <span>Teachers</span></h2>
                            <p>It is a long established fact that a reader will be distracted by the readable content of
                                a page when looking at its layout.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse($teachers as $index => $teacher)
                        <div class="col-md-6 col-lg-3">
                            <div class="team-item wow fadeInUp" data-wow-delay="{{ 0.25 * ($index + 1) }}s">
                                <div class="team-img">
                                    <img src="{{ asset('public/storage/uploads/teachers/' . basename($teacher->image)) }}"
                                        alt="{{ $teacher->name }}" class="img-fluid rounded shadow-sm">
                                </div>

                                <div class="team-content text-center mt-3">
                                    <div class="team-bio">
                                        <h5 class="mb-1">{{ $teacher->name }}</h5>
                                        <span class="text-muted d-block">{{ $teacher->subject }}</span>
                                        <small class="text-secondary">{{ $teacher->qualification }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No teachers available right now.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- team-area end -->
    </main>
@endsection
@push('scripts')

@endpush