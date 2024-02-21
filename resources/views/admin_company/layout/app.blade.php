<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('pageTitle')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('admin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin_company.dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('admin/img/logo.png') }}">
                <span class="d-none d-lg-block">Carrer Vibe</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">

            <ul class="d-flex align-items-center">
                <li class="nav-item me-3">
                    <form class="search-form d-flex align-items-center">
                        <input type="text" placeholder="Search" title="Enter search keyword">
                        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        @if (auth()->guard('company')->check() && auth()->guard('company')->user()->profile_image_url !== null)
                            <img class="p-0 img-thumbnail border-0"
                                src="{{ auth()->guard('company')->user()->profile_image_url }}" />
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            @if (auth()->guard('company')->check())
                                {{ auth()->guard('company')->user()->name }}
                            @endif
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('admin_company.dashboard') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('admin_company.logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin_company.dashboard') }}">
                    <span>Dashboard</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin_company.job.index') }}">
                    <span>Job</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin_company.notifications') }}">
                    <span>
                        Notifications
                        <span class="badge bg-danger">
                            {{ auth()->guard('company')->user()->unreadNotifications->count() }}
                        </span>
                    </span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin_company.post.all') }}">
                    <span>All Posts</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin_company.post.index') }}">
                    <span>Your Posts</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin_company.allUsers') }}">
                    <span>
                        All Users
                    </span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin_company.followers') }}">
                    <span>
                        Followers
                    </span>
                </a>
            </li>

        </ul>

    </aside>

    @yield('content')

    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>CareerVibe</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://linkedin.com/in/patadiayuvraj" target="_blank"
                rel="noopener noreferrer">PatadiaYuvraj</a>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    {{-- <script src="{{ asset('admin/vendor/tinymce/tinymce.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery.repeater@1.2.1/jquery.repeater.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('admin/js/main.js') }}"></script>
    <script>
        toastr.options = {
            "closeButton": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        if ("{{ Session::has('success') }}") {
            toastr.success("{{ Session::get('success') }}")
        }
        if ("{{ Session::has('error') }}") {
            toastr.error("{{ Session::get('error') }}")
        }
        if ("{{ Session::has('info') }}") {
            toastr.info("{{ Session::get('info') }}")
        }
        if ("{{ Session::has('warning') }}") {
            toastr.warning("{{ Session::get('warning') }}")
        }
    </script>

    @yield('scripts')
</body>

</html>
