@extends('front.layouts.app')
@section('title', $title)
@section('comp', $comp)

@section('css')
@endsection

@section('content')

<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url({{ asset('public/assets/img/breadcrumb/01.jpg') }})">
        <div class="container">
            <h2 class="breadcrumb-title">Student Excellence</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Student Excellence</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- alumni section -->
    <div class="alumni pt-120 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-img wow fadeInLeft" data-wow-delay=".25s">
                        <img src="{{ asset('public/assets/img/alumni/01.jpg') }}" alt="Student Excellence">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Our Stars</span>
                            <h2 class="site-title">
                                Celebrating <span>Outstanding Students</span> of 2024
                            </h2>
                        </div>
                        <p class="content-text">
                            AtDeep Ganga Public School, we take immense pride in the achievements of our students who have excelled in academics, sports, innovation, and community service. Each success story is a reflection of dedication and hard work.
                        </p>
                        <p class="content-text mt-2">
                            Our alumni continue to make us proud, achieving milestones in universities, professional careers, and leadership roles around the world.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- alumni end-->

    <!-- alumni details -->
    <div class="alumni-details pb-80">
        <div class="container">
            <div class="details-wrapper">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="details-item">
                            <h3 class="mb-3">Welcome To Our Student Excellence Community</h3>
                            <p>
                                The Student Excellence community ofDeep Ganga Public School recognizes students who demonstrate academic brilliance, creativity, and leadership. These achievements serve as an inspiration for others.
                            </p>
                            <p class="mt-2">
                                We believe in nurturing potential through continuous motivation, modern teaching methods, and co-curricular opportunities for overall development.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="details-item">
                            <h3 class="mb-3">Achievements & Awards</h3>
                            <p>
                                Here are some of the notable achievements by our students in recent years:
                            </p>
                            <ul class="content-list mt-2">
                                <li><i class="fas fa-check-circle"></i>Top 1% scorers in National Board Examinations.</li>
                                <li><i class="fas fa-check-circle"></i>Winners of State-level Science and Innovation Awards.</li>
                                <li><i class="fas fa-check-circle"></i>Represented India in International Olympiads.</li>
                                <li><i class="fas fa-check-circle"></i>National-level champions in sports and arts.</li>
                                <li><i class="fas fa-check-circle"></i>100% higher education placements in reputed universities.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-12 mt-4">
                        <div class="details-item text-center">
                            <img src="{{ asset('public/assets/img/alumni/02.jpg') }}" alt="Excellence Highlights" class="img-fluid rounded shadow">
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4">
                        <div class="details-item">
                            <h3 class="my-3">Inspiring Success Stories</h3>
                            <p>
                                Our alumni are spread across the globe, excelling in fields such as medicine, engineering, arts, and entrepreneurship. Their stories serve as a source of inspiration for our current students.
                            </p>
                            <p class="mt-2">
                                Each journey begins here at TDL — where we nurture confidence, curiosity, and compassion to shape world-ready individuals.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="details-item">
                            <h3 class="my-3">Our Core Values</h3>
                            <p>
                                We believe true excellence comes from passion and perseverance. Our students are guided by the principles of honesty, discipline, and creativity.
                            </p>
                            <p class="mt-2">
                                AtDeep Ganga Public School, we create an environment that encourages students to challenge themselves, achieve their goals, and contribute positively to society.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- alumni details end -->

    <!-- testimonials area -->
     <div class="testimonial-area bg py-120">
            <div class="container">

                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">
                                <i class="far fa-book-open-reader"></i> Testimonials
                            </span>
                            <h2 class="site-title">What <span>Parents Say</span></h2>
                            <p>See how our school has created a positive impact on students and parents.</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-slider owl-carousel owl-theme">

                    @forelse($testimonials as $testimonial)
                        <div class="testimonial-item">

                            <!-- Rating -->
                            <div class="testimonial-rate">
                                @for($i = 1; $i <= ($testimonial->rating ?? 5); $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>

                            <!-- Message -->
                            <div class="testimonial-quote">
                                <p>{{ $testimonial->description }}</p>
                            </div>

                            <!-- Author Info -->
                            <div class="testimonial-content">
                                <div class="testimonial-author-img">
                                    <img src="{{ getImageUrl($testimonial->image) }}" alt="{{ $testimonial->name }}">
                                </div>

                                <div class="testimonial-author-info">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p>{{ $testimonial->designation ?? 'Parent' }}</p>
                                </div>
                            </div>

                            <span class="testimonial-quote-icon">
                                <i class="far fa-quote-right"></i>
                            </span>
                        </div>
                    @empty
                        <p class="text-center">No testimonials available right now.</p>
                    @endforelse

                </div>

            </div>
        </div>

    <!-- testimonials end -->

</main>

@endsection

@push('scripts')
@endpush
