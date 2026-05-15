@extends('front.layouts.app')
@section('title', $title)
@section('comp', $comp)

@section('content')

<main class="main">

    <!-- breadcrumb -->
    <div class="site-breadcrumb" style="background: url('{{ asset('public/assets/img/breadcrumb/01.jpg') }}')">
        <div class="container">
            <h2 class="breadcrumb-title">Notices</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Notices</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->


    <!-- NOTICE LIST SECTION -->
    <section class="py-120">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <span class="site-title-tagline"><i class="far fa-bell"></i> School Notices</span>
                        <h2 class="site-title">All <span>Notices</span></h2>
                        <p>Here you can find the latest updates and announcements from the school.</p>
                    </div>
                </div>
            </div>

            <div class="row">

                @forelse ($notices as $notice)
                    <div class="col-lg-12 mb-4">
                        <div class="p-4 rounded shadow-sm d-flex justify-content-between align-items-center notice-box">
                            
                            <div>
                                <h4 class="mb-1">{{ $notice->title }}</h4>
                                <p class="mb-1 text-muted">{{ $notice->short_description }}</p>
                                <small class="text-secondary">
                                    <i class="far fa-calendar"></i> 
                                    {{ $notice->created_at->format('d M, Y') }}
                                </small>
                            </div>

                            <a href="{{ getImageUrl($notice->file) }}" target="_blank" class="theme-btn">
                                View
                            </a>

                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No notices available right now.</p>
                    </div>
                @endforelse

            </div>

        </div>
    </section>
    <!-- NOTICE LIST SECTION END -->

</main>

@endsection
