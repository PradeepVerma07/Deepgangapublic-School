@extends('admin.layouts.app')
@section('title', $title)
@section('comp', $comp)
@section('css')
@endsection
@section('content')
    <!-- Welcome Wrap -->
    <div class="card border-0">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap pb-1">
            <div class="d-flex align-items-center mb-3">
                <span class="avatar avatar-xl flex-shrink-0">
                    <img src="{{ getImageUrl($user->photo) }}" class="rounded-circle" alt="img">
                </span>
                <div class="ms-3">
                    <h3 class="mb-2">Welcome Back, {{$user->name}} <a href="{{route('admin.profile')}}" class="edit-icon"><i class="ti ti-edit fs-14"></i></a></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- /Welcome Wrap -->

    <div class="row">
        <!-- Widget Info -->
        <div class="col-xxl-12 d-flex">
            {{-- <div class="row flex-fill">
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-primary mb-2">
                                <i class="ti ti-calendar-share fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Attendance Overview</h6>
                            <h3 class="mb-3">120/154 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
                            <a href="attendance-employee.html" class="link-default">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-secondary mb-2">
                                <i class="ti ti-browser fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Total No of Project's</h6>
                            <h3 class="mb-3">90/125 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-2.1%</span></h3>
                            <a href="projects.html" class="link-default">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-info mb-2">
                                <i class="ti ti-users-group fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Total No of Clients</h6>
                            <h3 class="mb-3">69/86 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
                            <a href="clients.html" class="link-default">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-pink mb-2">
                                <i class="ti ti-checklist fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Total No of Tasks</h6>
                            <h3 class="mb-3">225/28 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-down me-1"></i>+11.2%</span></h3>
                            <a href="tasks.html" class="link-default">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-purple mb-2">
                                <i class="ti ti-moneybag fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Earnings</h6>
                            <h3 class="mb-3">$21445 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+10.2%</span></h3>
                            <a href="expenses.html" class="link-default">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-danger mb-2">
                                <i class="ti ti-browser fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Profit This Week</h6>
                            <h3 class="mb-3">$5,544 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
                            <a href="purchase-transaction.html" class="link-default">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-success mb-2">
                                <i class="ti ti-users-group fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">Job Applicants</h6>
                            <h3 class="mb-3">98 <span class="fs-12 fw-medium text-success"><i class="fa-solid fa-caret-up me-1"></i>+2.1%</span></h3>
                            <a href="job-list.html" class="link-default">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar rounded-circle bg-dark mb-2">
                                <i class="ti ti-user-star fs-16"></i>
                            </span>
                            <h6 class="fs-13 fw-medium text-default mb-1">New Hire</h6>
                            <h3 class="mb-3">45/48 <span class="fs-12 fw-medium text-danger"><i class="fa-solid fa-caret-down me-1"></i>-11.2%</span></h3>
                            <a href="candidates.html" class="link-default">View All</a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- /Widget Info -->
    </div>
@endsection
@push('scripts')
@endpush
