@extends('front.layouts.app')
@section('title', $title)
@section('comp', $comp)

@section('content')
    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url({{ asset('public/assets/img/breadcrumb/01.jpg') }})">
            <div class="container">
                <h2 class="breadcrumb-title">Gallery</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Gallery</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- gallery-area -->
        <div class="gallery-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="far fa-book-open-reader"></i> Gallery</span>
                            <h2 class="site-title">Our Photo <span>Gallery</span></h2>
                            <p>Explore memorable moments from our school life — from academic achievements and cultural
                                events to sports, celebrations, and everyday learning. Each picture tells a story of joy,
                                growth, and togetherness at our school.</p>
                        </div>
                    </div>

                </div>
                <div class="row popup-gallery">
                    @forelse ($images as $image)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="gallery-item">
                                <div class="gallery-img position-relative overflow-hidden rounded shadow-sm">
                                    <img src="{{ getImageUrl($image->image) }}"
                                        alt="{{ $image->category->title ?? 'Gallery Image' }}" class="gallery-photo">
                                    <div class="gallery-content d-flex justify-content-center align-items-center">
                                        <a class="popup-img gallery-link" href="{{ getImageUrl($image->image) }}">
                                            <i class="fal fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No images available for this category.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- gallery-area end -->

    </main>
@endsection



@push('scripts')
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
        $(document).ready(function () {
            var $grid = $('#masonry-container').isotope({
                itemSelector: '.masonry-item',
                layoutMode: 'masonry'
            });
        });
    </script>
@endpush