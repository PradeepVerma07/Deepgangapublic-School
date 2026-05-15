@extends('front.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('content')

<div class="page-banner-area bg-2">
    <div class="container">
        <div class="page-banner-content">
            <h1>Privacy Policy</h1>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Privacy Policy</li>
            </ul>
        </div>
    </div>
</div>

<div class="legal-content-area pt-100 pb-70">
    <div class="container">
        <h2>1. Introduction</h2>
        <p>At Udyam Public School, we are committed to protecting the privacy and security of our website users. This privacy policy explains how we collect, use, and protect your information.</p>

        <h2>2. Information We Collect</h2>
        <ul>
            <li>Personal Information (Name, Email, Phone Number) submitted via forms</li>
            <li>Usage Data (IP address, browser type, visit duration)</li>
        </ul>

        <h2>3. How We Use Your Information</h2>
        <p>We use your information to:</p>
        <ul>
            <li>Respond to inquiries or requests</li>
            <li>Improve our website and services</li>
            <li>Communicate with you regarding school updates or events</li>
        </ul>

        <h2>4. Information Sharing</h2>
        <p>We do not sell, rent, or trade your personal information. We may share data with trusted service providers to help us operate the website.</p>

        <h2>5. Cookies</h2>
        <p>Our website may use cookies to enhance your experience. You can set your browser to refuse cookies or alert you when cookies are being sent.</p>

        <h2>6. Data Security</h2>
        <p>We implement industry-standard measures to protect your information against unauthorized access, alteration, or destruction.</p>

        <h2>7. Your Rights</h2>
        <p>You have the right to access, correct, or request deletion of your personal information.</p>

        <h2>8. Changes to This Policy</h2>
        <p>We may update this privacy policy from time to time. Updates will be posted here with the date of revision.</p>

        <p class="mt-4">Last Updated: September 26, 2025</p>
    </div>
</div>

@endsection
