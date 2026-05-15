@extends('front.layouts.app')
@section('title', $title)
@section('comp', $comp)

@section('content')

    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url('{{ asset('public/assets/img/breadcrumb/01.jpg') }}')">
            <div class="container">
                <h2 class="breadcrumb-title">{{ $year ?? '2024 - 2025' }}</h2>

                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Toppers</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- TOPPER LIST -->
        <section class="py-120">
            <div class="container">

                <div class="text-center mb-5">
                    <h2 class="site-title">{{ $year ?? '2024 - 2025' }}</h2>
                </div>

                <div class="row">

                    @forelse($toppers as $topper)
                        <div class="col-md-3 col-sm-6 mb-5 text-center">

                            <div class="topper-card" style="padding:15px; border:3px solid #0A4C7E; border-radius:6px;">

                                <img src="{{ getImageUrl($topper->image) }}" alt="{{ $topper->name }}"
                                    style="width:100%; height:250px; object-fit:cover; border-radius:4px;">

                            </div>

                            <h5 class="mt-3" style="font-weight:700;">
                                {{ strtoupper($topper->name) }}
                            </h5>

                            {{-- Class Name --}}
                            <p style="font-size:16px; font-weight:600; margin-bottom:5px; color:#0A4C7E;">
                                Class: {{ $topper->class->title ?? 'N/A' }}
                            </p>


                            {{-- Marks --}}
                            <p style="font-size:18px; font-weight:600;">
                                {{ $topper->marks }}%
                            </p>

                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No toppers found.</p>
                        </div>
                    @endforelse

                </div>

            </div>
        </section>

    </main>

@endsection