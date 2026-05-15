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

                    <div class="notice-box p-4 rounded shadow-sm d-flex justify-content-between align-items-center">

                        <div class="d-flex">

                            {{-- Notice Image Thumbnail --}}
                            <div class="me-3">
                                <img src="{{ getImageUrl($notice->image) }}" 
                                     alt="Notice Image" 
                                     style="width: 90px; height: 90px; object-fit: cover; border-radius: 6px;">
                            </div>

                            {{-- Notice Content --}}
                            <div>
                                <h4 class="mb-1">{{ $notice->title }}</h4>

                                <p class="mb-1 text-muted" style="max-width: 600px;">
                                    {{ \Illuminate\Support\Str::limit($notice->description, 120) }}
                                </p>

                                <small class="text-secondary">
                                    <i class="far fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($notice->date)->format('d M, Y') }}
                                </small>
                            </div>

                        </div>

                        {{-- View Button --}}
                        <a href="{{ getImageUrl($notice->image) }}" 
                           target="_blank" 
                           class="theme-btn">
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
