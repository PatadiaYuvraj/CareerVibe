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

    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('user.dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('admin/img/logo.png') }}">
                <span class="d-none d-lg-block">Carrer Vibe</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">

            <ul class="d-flex align-items-center">
                <li class="nav-item me-3">
                    <form class="search-form d-flex align-items-center" method="POST"
                        action="{{ route('user.search') }}">
                        @csrf
                        <input type="text" placeholder="Search" name='search' title="Enter search keyword">
                        <input type="hidden" name="path" value="{{ Request::path() }}">
                        <button type="submit" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        @if (auth()->guard(config('constants.USER_GUARD'))->user()->profile_image_url !== null)
                            <img class="p-0 img-thumbnail border-0"
                                src="{{ auth()->guard(config('constants.USER_GUARD'))->user()->profile_image_url }}" />
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            {{ auth()->guard(config('constants.USER_GUARD'))->user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.logout') }}">
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
                <a class="nav-link collapsed" href="{{ route('user.dashboard') }}">
                    <span>Dashboard</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.allUsers') }}">
                    <span>
                        All Users
                    </span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.followers') }}">
                    <span>Followers</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.following') }}">
                    <span>Following</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.company.index') }}">
                    <span>Company</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.job.index') }}">
                    <span>Job</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.job.appliedJobs') }}">
                    <span>Applied Jobs</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.job.savedJobs') }}">
                    <span>Saved Jobs</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.notifications') }}">
                    <span>
                        Notifications
                        <span class="badge bg-danger">
                            {{ auth()->guard(config('constants.USER_GUARD'))->user()->unreadNotifications->count() }}
                        </span>
                    </span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.post.all') }}">
                    <span>All Posts</span>
                </a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.post.index') }}">
                    <span>Your Posts</span>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js "></script>
    <script src="{{ asset('admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('admin/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('admin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/php-email-form/validate.js') }}"></script>

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
