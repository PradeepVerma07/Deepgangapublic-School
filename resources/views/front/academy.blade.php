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
                <h2 class="breadcrumb-title">Academics Department</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Academics Department</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- department area -->
        <div class="department-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">
                                <i class="far fa-book-open-reader"></i> Our Academics
                            </span>
                            <h2 class="site-title">
                                Classes at <span>Deep Ganga Public School</span>
                            </h2>
                            <p>
                                At Deep Ganga Public School, we provide quality education from Nursery to Class 8,
                                focusing on strong fundamentals, creativity, and overall development of every child.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Nursery -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/art.svg') }}" alt="Nursery">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">Nursery</a></h4>
                                <p>Fun-based learning with activities, games, and creativity to build a strong foundation.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- LKG -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/human.svg') }}" alt="LKG">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">LKG</a></h4>
                                <p>Introduction to basic concepts through interactive learning and playful activities.</p>
                            </div>
                        </div>
                    </div>

                    <!-- UKG -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/monitor.svg') }}" alt="UKG">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">UKG</a></h4>
                                <p>Preparing students for primary education with reading, writing, and basic math skills.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Primary (1-5) -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/data.svg') }}" alt="Primary Classes">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">Classes 1 - 5</a></h4>
                                <p>Strong focus on academics, creativity, and building fundamental knowledge.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Middle (6-8) -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/information.svg') }}" alt="Middle Classes">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">Classes 6 - 8</a></h4>
                                <p>Advanced learning with focus on subjects, discipline, and preparing for higher education.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Activities -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/acting.svg') }}" alt="Activities">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">Co-Curricular Activities</a></h4>
                                <p>Sports, arts, music, and cultural activities for overall personality development.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Computer -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/law.svg') }}" alt="Computer Education">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">Computer Education</a></h4>
                                <p>Basic computer knowledge to make students digitally aware from an early age.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Health -->
                    <div class="col-lg-3 col-md-6">
                        <div class="department-item">
                            <div class="department-icon">
                                <img src="{{ asset('public/assets/img/icon/health.svg') }}" alt="Health & Sports">
                            </div>
                            <div class="department-info">
                                <h4 class="department-title"><a href="#">Health & Sports</a></h4>
                                <p>Encouraging fitness, teamwork, and healthy habits through sports and physical activities.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- department area end -->

    </main>

@endsection

@push('scripts')
@endpush