<div class="header">
    <div class="main-header">

        <div class="header-left">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img src="{{ getImageUrl(getSetting('logo')) }}" alt="Logo">
            </a>
            <a href="{{ route('admin.dashboard') }}" class="dark-logo">
                <img src="{{ getImageUrl(getSetting('logo')) }}" alt="Logo">
            </a>
        </div>

        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <div class="header-user">
            <div class="nav user-menu nav-list">

                <div class="me-auto d-flex align-items-center" id="header-search">
                    <a id="toggle_btn" href="javascript:void(0);" class="btn btn-menubar me-1">
                        <i class="ti ti-arrow-bar-to-left"></i>
                    </a>
                    <!-- Search -->
                    <div class="input-group input-group-flat d-inline-flex me-1">
                        <span class="input-icon-addon">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Search in HRMS">
                        <span class="input-group-text">
                            <kbd>CTRL + / </kbd>
                        </span>
                    </div>
                    <!-- /Search -->
                    <div class="dropdown crm-dropdown">
                        <a href="#" class="btn btn-menubar me-1" data-bs-toggle="dropdown">
                            <i class="ti ti-layout-grid"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-start">
                            <div class="card mb-0 border-0 shadow-none">
                                <div class="card-header">
                                    <h4>CRM</h4>
                                </div>
                                <div class="card-body pb-1">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <a href="contacts.html" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
                                                <span class="d-flex align-items-center me-3">
                                                    <i class="ti ti-user-shield text-default me-2"></i>Contacts
                                                </span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                            <a href="deals-grid.html" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
                                                <span class="d-flex align-items-center me-3">
                                                    <i class="ti ti-heart-handshake text-default me-2"></i>Deals
                                                </span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                            <a href="pipeline.html" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
                                                <span class="d-flex align-items-center me-3">
                                                    <i class="ti ti-timeline-event-text text-default me-2"></i>Pipeline
                                                </span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="companies-grid.html" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
                                                <span class="d-flex align-items-center me-3">
                                                    <i class="ti ti-building text-default me-2"></i>Companies
                                                </span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                            <a href="leads-grid.html" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
                                                <span class="d-flex align-items-center me-3">
                                                    <i class="ti ti-user-check text-default me-2"></i>Leads
                                                </span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                            <a href="activity.html" class="d-flex align-items-center justify-content-between p-2 crm-link mb-3">
                                                <span class="d-flex align-items-center me-3">
                                                    <i class="ti ti-activity text-default me-2"></i>Activities
                                                </span>
                                                <i class="ti ti-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="profile-settings.html" class="btn btn-menubar">
                        <i class="ti ti-settings-cog"></i>
                    </a>
                </div>

                <div class="d-flex align-items-center">
                    <div class="me-1">
                        <a href="#" class="btn btn-menubar btnFullscreen">
                            <i class="ti ti-maximize"></i>
                        </a>
                    </div>
                    <div class="dropdown profile-dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <span class="avatar avatar-sm online">
                                <img src="{{ getImageUrl($user->photo) }}" alt="Img" class="img-fluid rounded-circle">
                            </span>
                        </a>
                        <div class="dropdown-menu shadow-none">
                            <div class="card mb-0">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-lg me-2 avatar-rounded">
                                            <img src="{{ getImageUrl($user->photo) }}" alt="img">
                                        </span>
                                        <div>
                                            <h5 class="mb-0">{{ $user->name }}</h5>
                                            <p class="fs-12 fw-medium mb-0">
                                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a class="dropdown-item d-inline-flex align-items-center p-0 py-2" href="{{route('admin.profile')}}">
                                        <i class="ti ti-circle-arrow-up me-1"></i>My Account
                                    </a>
                                </div>
                                <div class="card-footer">
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-inline-flex align-items-center p-0 py-2 border-0 bg-transparent">
                                            <i class="ti ti-login me-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
            <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href=""{{route('admin.profile')}}">My Profile</a>
                <form id="logout-form-mobile" action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    <button type="submit" class="dropdown-item d-inline-flex align-items-center p-0 py-2 border-0 bg-transparent">
                        <i class="ti ti-login me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
        <!-- /Mobile Menu -->

    </div>

</div>
