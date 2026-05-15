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
            <h2 class="breadcrumb-title">School Admission Form</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Application Form</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- application -->
    <div class="application py-120">
        <div class="container">
            <div class="application-form">
                <h3>School Admission Form</h3>

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- Student Information -->
                        <h5 class="mb-3">Student Information</h5>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="firstname" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lastname" required>
                            </div>
                        </div>

                        <!-- ✅ INPUT FIELD INSTEAD OF DROPDOWN -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Class Applying For</label>
                                <input type="text" class="form-control" name="class" placeholder="e.g. Nursery / Class 1" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Previous Class</label>
                                <input type="text" class="form-control" name="previous_class" placeholder="Last studied class">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date Of Birth</label>
                                <input type="date" class="form-control" name="dob" required>
                            </div>
                        </div>

                       

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Student Photo</label>
                                <input type="file" class="form-control" name="photo" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Birth Certificate / Aadhar</label>
                                <input type="file" class="form-control" name="document" required>
                            </div>
                        </div>

                        <!-- Parent Information -->
                        <h5 class="mt-4 mb-3">Parent Information</h5>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Father's Name</label>
                                <input type="text" class="form-control" name="fathername" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mother's Name</label>
                                <input type="text" class="form-control" name="mothername">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="text" class="form-control" name="number" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Email (Optional)</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address (Village / Area)</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Aadhar Number (Optional)</label>
                                <input type="text" class="form-control" name="aadhar">
                            </div>
                        </div>

                       

                        <!-- Previous School -->
                        <h5 class="mt-4 mb-3">Previous School Details</h5>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Previous School Name</label>
                                <input type="text" class="form-control" name="school">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Last Class Passed</label>
                                <input type="text" class="form-control" name="qualification">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Last Class Passed Year</label>
                                <input type="text" class="form-control" name="yoc">
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="col-lg-12 mt-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                                <label class="form-check-label" for="agree">
                                    I confirm that all details are correct.
                                </label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="col-lg-12 mt-3">
                            <button type="submit" class="theme-btn">
                                Submit Application
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

</main>

@endsection

@push('scripts')
@endpush
