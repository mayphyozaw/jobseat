<header class="navbar-header">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center">

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="logo">

                
                <!-- Logo Normal -->
                <span class="logo-light">
                    <span class="logo-lg"><img src="{{ asset('data/logo.png') }}" alt="logo"
                            style="width:100px;"></span>
                    <span class="logo-sm"><img src="{{ asset('data/logo.png') }}" alt="small logo"
                            style="width:50px;"></span>
                </span>

                <!-- Logo Dark -->
                <span class="logo-dark">
                    <span class="logo-lg"><img src="{{ asset('backend/assets/img/logo-white.svg') }}"
                            alt="dark logo"></span>
                </span>
            </a>

            
            <!-- Sidebar Mobile Button -->
            <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                <i class="ti ti-menu-deep fs-24"></i>
            </a>

            <button class="sidenav-toggle-btn btn border-0 p-0" id="toggle_btn2">
                <i class="ti ti-arrow-bar-to-right"></i>
            </button>

            <!-- Search -->
            <div class="me-auto d-flex align-items-center header-search d-lg-flex d-none">
                <!-- Search -->
                <div class="input-icon position-relative me-2">
                    <input type="text" class="form-control" placeholder="Search Keyword">
                    <span class="input-icon-addon d-inline-flex p-0 header-search-icon"><i
                            class="ti ti-command"></i></span>
                </div>
                <!-- /Search -->
            </div>

        </div>

        <div class="d-flex align-items-center">

            <!-- Search for Mobile -->
            <div class="header-item d-flex d-lg-none me-2">
                <button class="topbar-link btn" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                    <i class="ti ti-search fs-16"></i>
                </button>
            </div>

            <div class="header-line"></div>

            <div class="header-item d-none d-sm-flex me-2">
                <button class="topbar-link btn topbar-link" id="light-dark-mode" type="button">
                    <i class="ti ti-moon fs-16"></i>
                </button>
            </div>
            <!-- Notification Dropdown -->
            <div class="header-item">
                <div class="dropdown me-2">

                    <button class="topbar-link btn topbar-link dropdown-toggle drop-arrow-none"
                        data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" aria-haspopup="false"
                        aria-expanded="false">
                        <i class="ti ti-bell-check fs-16 animate-ring"></i>
                        <span class="badge rounded-pill">10</span>
                    </button>

                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">



                        <!-- Notification Body -->


                        <!-- View All-->
                        <div class="p-2 rounded-bottom border-top text-center">
                            <a href="notifications.html" class="text-center text-decoration-underline fs-14 mb-0">
                                View All Notifications
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown profile-dropdown d-flex align-items-center justify-content-center">

                <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ !empty(auth()->guard('web')->user()->photo)
                        ? url('upload/user_images/' . auth()->guard('web')->user()->photo ?? '')
                        : url('upload/no_image.jpg') }}"
                        alt="user-image" class="rounded-circle" width="38" class="rounded-1 d-flex"
                        alt="user-image">
                    <span class="pro-user-name ms-1">
                        {{ auth()->guard('web')->user()->name ?? '' }} <i class="mdi mdi-chevron-down"></i>
                    </span>

                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">

                    <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                        <img src="{{ !empty(auth()->guard('web')->user()->photo)
                            ? url('upload/user_images/' . auth()->guard('web')->user()->photo ?? '')
                            : url('upload/no_image.jpg') }}"
                            alt="user-image" class="rounded-circle" width="38" class="rounded-1 d-flex"
                            alt="user-image">
                        <div class="ms-2">
                            <p class="fw-medium text-dark mb-0">{{ auth()->guard('web')->user()->name ?? '' }}</p>
                            <span class="d-block fs-13">Admin</span>
                        </div>
                    </div>

                    <!-- Item-->
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ti ti-user-circle me-1 align-middle"></i>
                        <span class="align-middle">Edit Profile</span>
                    </a>

                    <!-- Item-->
                    <a href="{{ route('change-password.edit') }}" class="dropdown-item">
                        <i class="ti ti-lock me-1 align-middle"></i>
                        <span class="align-middle">Change Password</span>
                    </a>


                    <!-- Item-->
                    <div class="pt-2 mt-2 border-top">
                        <a href="{{ route('admin-logout') }}" class="dropdown-item text-danger">
                            <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </div>



                </div>
            </div>

        </div>
    </div>
</header>
