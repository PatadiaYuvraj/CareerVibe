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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />



    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('admin/img/logo.png') }}">
                <span class="d-none d-lg-block">Carrer Vibe</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">

            <ul class="d-flex align-items-center">
                <li class="nav-item me-3">
                    <form class="search-form d-flex align-items-center" method="POST"
                        action="{{ route('admin.search') }}">
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
                        @if (auth()->guard('admin')->user()->profile_image_url !== null)
                            <img class="p-0 img-thumbnail border-0"
                                src="{{ auth()->guard('admin')->user()->profile_image_url }}" />
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            {{ auth()->guard('admin')->user()->name }}</span>
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
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}">
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
                <a class="nav-link collapsed" href="{{ route('admin.dashboard') }}">
                    <span>Dashboard</span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.company.index') }}">
                    <span>Company</span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.user.index') }}">
                    <span>User</span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.job.index') }}">
                    <span>Job</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.job.livewire') }}">
                    <span>
                        Job LiveWire
                    </span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.profile-category.index') }}">
                    <span>Profile Category</span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.profile-category.livewire') }}">
                    <span>
                        Profile Category LiveWire
                    </span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.sub-profile.index') }}">
                    <span>Sub Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('admin.sub-profile.livewire') }}">
                    <span>
                        Sub Profile LiveWire
                    </span>
                </a>
            </li>
            {{-- <hr> --}}

            <li class="nav-item">
                <a class="nav-link collapsed     " href="{{ route('admin.location.index') }}">
                    <span>Location</span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed     " href="{{ route('admin.location.livewire') }}">
                    <span>
                        Location LiveWire
                    </span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link  collapsed   " href="{{ route('admin.qualification.index') }}">
                    <span>Qualification</span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link  collapsed   " href="{{ route('admin.qualification.livewire') }}">
                    <span>
                        Qualification LiveWire
                    </span>
                </a>
            </li>
            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link  collapsed   " href="{{ route('admin.notifications') }}">
                    <span>
                        Notifications
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js "></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('admin/vendor/tinymce/tinymce.min.js') }}"></script> --}}
    <script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.4/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js"
        integrity="sha512-bZAXvpVfp1+9AUHQzekEZaXclsgSlAeEnMJ6LfFAvjqYUVZfcuVXeQoN5LhD7Uw0Jy4NCY9q3kbdEXbwhZUmUQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
