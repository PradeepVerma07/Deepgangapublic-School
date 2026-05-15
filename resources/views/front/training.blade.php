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
            <h2 class="breadcrumb-title">How To Apply</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">How To Apply</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- how apply -->
    <div class="how-apply pt-120 pb-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content-info wow fadeInUp" data-wow-delay=".25s">
                        <div class="site-heading mb-3">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> How To Apply</span>
                            <h2 class="site-title">
                                Step-by-Step Guide to <span>Applying atDeep Ganga Public School</span>
                            </h2>
                        </div>
                        <p class="content-text">
                            Applying toDeep Ganga Public School is simple and transparent. Follow the steps to complete your application and start your academic journey with us.
                        </p>
                        <p class="content-text mt-2">
                            Please ensure that you have all required documents ready before starting your online application. Our admissions team is here to assist you throughout the process.
                        </p>
                        <div class="row my-3">
                            <div class="col-md-6">
                                <ul class="content-list">
                                    <li><i class="fas fa-check-circle"></i>Start Online Submission</li>
                                    <li><i class="fas fa-check-circle"></i>Submit the Form</li>
                                    <li><i class="fas fa-check-circle"></i>Review Your Application</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="content-list">
                                    <li><i class="fas fa-check-circle"></i>Upload Required Documents</li>
                                    <li><i class="fas fa-check-circle"></i>Attend Interview (if applicable)</li>
                                    <li><i class="fas fa-check-circle"></i>Receive Admission Confirmation</li>
                                </ul>
                            </div>
                        </div>
                        <div class="content-btn">
                            <a href="" class="theme-btn">Apply Now <i class="fas fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-img wow fadeInRight" data-wow-delay=".25s">
                        <img src="{{ asset('public/assets/img/apply/01.jpg') }}" alt="How to Apply">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- how apply end-->

    <!-- apply details -->
    <div class="apply-details">
        <div class="container">
            <div class="details-wrapper">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="details-left">
                            <h3 class="mb-3">Things To Know First</h3>
                            <p>
                                Before applying, please review our admission requirements and eligibility criteria for each academic level. Ensure that all information provided is accurate and authentic.
                            </p>
                            <p class="mt-2">
                                Admission decisions are based on merit, performance in entrance assessments (if any), and availability of seats. Early applications are encouraged.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="details-right">
                            <h3 class="mb-3">Documents and Financial Aid</h3>
                            <p>
                                The following documents are typically required for admission consideration:
                            </p>
                            <ul class="content-list mt-2">
                                <li><i class="fas fa-check-circle"></i>Recent passport-size photographs</li>
                                <li><i class="fas fa-check-circle"></i>Copy of birth certificate or passport</li>
                                <li><i class="fas fa-check-circle"></i>Previous academic transcripts or certificates</li>
                                <li><i class="fas fa-check-circle"></i>Proof of address and parent ID</li>
                                <li><i class="fas fa-check-circle"></i>Financial aid form (if applying for scholarship)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- apply details end -->

    <!-- feature area -->
    <div class="feature-area fa2 py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Features</span>
                        <h2 class="site-title">Why Choose <span>Deep Ganga Public School</span></h2>
                        <p>We provide an enriching academic environment, world-class facilities, and a focus on holistic student development.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item wow fadeInUp" data-wow-delay=".25s">
                        <span class="count">01</span>
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/img/icon/scholarship.svg') }}" alt="Scholarship">
                        </div>
                        <div class="feature-content">
                            <h4 class="feature-title">Scholarship Programs</h4>
                            <p>Merit-based scholarships are available to reward academic excellence.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item active wow fadeInDown" data-wow-delay=".25s">
                        <span class="count">02</span>
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/img/icon/teacher.svg') }}" alt="Lecturers">
                        </div>
                        <div class="feature-content">
                            <h4 class="feature-title">Experienced Faculty</h4>
                            <p>Learn from passionate educators committed to student success.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item wow fadeInUp" data-wow-delay=".25s">
                        <span class="count">03</span>
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/img/icon/library.svg') }}" alt="Library">
                        </div>
                        <div class="feature-content">
                            <h4 class="feature-title">Modern Library</h4>
                            <p>Access a wide range of academic books, journals, and e-learning materials.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-item wow fadeInUp" data-wow-delay=".25s">
                        <span class="count">04</span>
                        <div class="feature-icon">
                            <img src="{{ asset('public/assets/img/icon/money.svg') }}" alt="Affordable">
                        </div>
                        <div class="feature-content">
                            <h4 class="feature-title">Affordable Education</h4>
                            <p>We offer quality education at an affordable fee structure.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature area end -->

    <!-- video-area -->
    <div class="video-area">
        <div class="container">
            <div class="video-content" style="background-image: url({{ asset('public/assets/img/video/01.jpg') }});">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="video-wrapper">
                            <a class="play-btn popup-youtube" href="https://www.youtube.com/watch?v=ckHzmP1evNU">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- video-area end -->

    <!-- faq area -->
    <div class="faq-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="faq-right">
                        <div class="site-heading mb-3">
                            <span class="site-title-tagline justify-content-start"><i class="far fa-book-open-reader"></i> FAQ's</span>
                            <h2 class="site-title my-3">General <span>Frequently</span> Asked Questions</h2>
                        </div>
                        <p class="mb-3">Find answers to common questions about admissions, fees, and academic life atDeep Ganga Public School.</p>
                        <p class="mb-4">
                            For more information, contact our admissions office or reach us at our official email.
                        </p>
                        <a href="" class="theme-btn mt-2">Have Any Question?</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span><i class="far fa-question"></i></span> How can I apply for admission?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Visit our online application page, fill in your details, upload required documents, and submit your application securely.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span><i class="far fa-question"></i></span> Do you offer scholarships?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Yes, we offer merit-based and need-based scholarships to deserving students.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    <span><i class="far fa-question"></i></span> Can international students apply?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Absolutely. We welcome international students from all backgrounds with open arms and dedicated support.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    <span><i class="far fa-question"></i></span> How can I contact the admission office?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse"
                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    You can contact our admissions team directly via the Contact page or by emailing us at info@UDGAM.com.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- faq area end -->

</main>

@endsection

@push('scripts')
@endpush
