@extends('front.layouts.app')

@section('title', $title)
@section('comp', $comp)

@section('content')
    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb" style="background: url(public/assets/img/breadcrumb/01.jpg)">
            <div class="container">
                <h2 class="breadcrumb-title">Mandatory Public Disclosure</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Disclosure</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb end -->

        <div class="py-120" style="background:#fff7e6;">

            <div class="container">

                <!-- Download PDF Button -->
                <div class="text-end mb-4">
                    <a href="{{ asset('public/assets/pdf/mandatory-disclosure.pdf') }}" target="_blank" class="theme-btn">
                        <i class="far fa-file-pdf"></i> Download Disclosure PDF
                    </a>
                </div>

                <!-- A : GENERAL INFORMATION -->
                <h4 class="mb-3">A : General Information</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Name of the School</th>
                        <td>SCHOLARS SENIOR SECONDARY SCHOOL</td>
                    </tr>
                    <tr>
                        <th>Affiliation No.</th>
                        <td>2132754</td>
                    </tr>
                    <tr>
                        <th>School Code</th>
                        <td>70331</td>
                    </tr>
                    <tr>
                        <th>Complete Address</th>
                        <td>Near SBI Raghav Nagar, Deoria (U.P.) – 274001</td>
                    </tr>
                    <tr>
                        <th>Principal Name</th>
                        <td>Mrs. Sapna Kejariwal</td>
                    </tr>
                    <tr>
                        <th>Principal Qualification</th>
                        <td>M.Com., B.Ed</td>
                    </tr>
                    <tr>
                        <th>Email ID</th>
                        <td>scholer.deo@gmail.com</td>
                    </tr>
                    <tr>
                        <th>Contact No.</th>
                        <td>9235626117</td>
                    </tr>
                </table>

                <!-- B : DOCUMENTS -->
                <h4 class="mt-5 mb-3">B : Documents and Information</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Document</th>
                        <th>Link</th>
                    </tr>
                    <tr>
                        <td>Affiliation Letter</td>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/Aliation-Letter.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <td>Trust Registration Certificate</td>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/TRUST.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <td>NOC Certificate</td>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/NOC.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <td>Recognition Certificate (RTE)</td>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/RECOGNITION.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <td>Building Safety Certificate</td>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/NBC.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <td>Fire Safety Certificate</td>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/Fire.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <td>Water & Health Certificate</td>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/Health.pdf"
                                target="_blank">View</a></td>
                    </tr>
                </table>

                <!-- C : RESULTS & ACADEMICS -->
                <h4 class="mt-5 mb-3">C : Result and Academics</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Fee Structure</th>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/Fee.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <th>Academic Calendar</th>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/Academic-calender.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <th>SMC Members</th>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/SMC1.pdf"
                                target="_blank">View</a></td>
                    </tr>
                    <tr>
                        <th>PTA Members</th>
                        <td><a href="http://scholarsssdeoria.org/wp-content/uploads/2022/03/PTA.pdf"
                                target="_blank">View</a></td>
                    </tr>
                </table>

                <!-- D : STAFF -->
                <h4 class="mt-5 mb-3">D : Staff (Teaching)</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Principal</th>
                        <td>Mrs. Sapna Kejariwal</td>
                    </tr>
                    <tr>
                        <th>Total Teachers</th>
                        <td>43 (PGT: 17, TGT: 09, PRT: 08)</td>
                    </tr>
                    <tr>
                        <th>Teacher Student Ratio</th>
                        <td>1.5 : 1</td>
                    </tr>
                    <tr>
                        <th>Special Educator</th>
                        <td>Mrs. Navedita – B.A., B.Ed (Special)</td>
                    </tr>
                    <tr>
                        <th>Counsellor</th>
                        <td>Ms. Nadiya Anwar – M.A. (Psychology)</td>
                    </tr>
                </table>

                <!-- E : INFRASTRUCTURE -->
                <h4 class="mt-5 mb-3">E : School Infrastructure</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Total Campus Area</th>
                        <td>6226.77 Sq. Mtr</td>
                    </tr>
                    <tr>
                        <th>Class Rooms</th>
                        <td>46 (46 Sq. Mtr each)</td>
                    </tr>
                    <tr>
                        <th>Laboratories</th>
                        <td>06 (56 Sq. Mtr each)</td>
                    </tr>
                    <tr>
                        <th>Internet Facility</th>
                        <td>Yes</td>
                    </tr>
                    <tr>
                        <th>Girls Toilets</th>
                        <td>18</td>
                    </tr>
                    <tr>
                        <th>Boys Toilets</th>
                        <td>18</td>
                    </tr>
                </table>

            </div>
        </div>

    </main>
@endsection