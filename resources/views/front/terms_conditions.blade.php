@extends('front.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('content')

<div class="page-banner-area bg-2">
    <div class="container">
        <div class="page-banner-content">
            <h1>Terms & Conditions</h1>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Terms & Conditions</li>
            </ul>
        </div>
    </div>
</div>

<div class="legal-content-area pt-100 pb-70">
    <div class="container">
        <h2>1. Introduction</h2>
        <p>Welcome to Udyam Public School. By accessing our website, you agree to be bound by the following terms and conditions.</p>

        <h2>2. Use of Website</h2>
        <p>This website is intended for general informational purposes. Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offense.</p>

        <h2>3. Intellectual Property</h2>
        <p>All content on this website, including text, images, graphics, and logos, is the property of Udyam Public School and is protected by copyright laws.</p>

        <h2>4. Limitation of Liability</h2>
        <p>We are not liable for any indirect, incidental, or consequential damages arising out of the use or inability to use this website.</p>

        <h2>5. Third-Party Links</h2>
        <p>Our website may contain links to third-party websites. We do not endorse or take responsibility for the content or practices of these sites.</p>

        <h2>6. Governing Law</h2>
        <p>These terms are governed by the laws of India. Any disputes will be handled in the courts of the jurisdiction in which the school is located.</p>

        <h2>7. Changes to Terms</h2>
        <p>We may revise these terms from time to time. The updated terms will be posted on this page with the date of the latest revision.</p>

        <p class="mt-4">Last Updated: September 26, 2025</p>
    </div>
</div>

@endsection
