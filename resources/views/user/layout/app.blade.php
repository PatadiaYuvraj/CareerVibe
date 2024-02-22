<!DOCTYPE html>
<html lang="">
@php
    $isHomeActive = match (Route::currentRouteName()) {
        'user.dashboard' => true,
        default => false,
    };

    $isCategoryActive = match (Route::currentRouteName()) {
        default => false,
    };

    $isPostActive = match (Route::currentRouteName()) {
        default => false,
    };

    $isJobActive = match (Route::currentRouteName()) {
        'user.job.index' => true,
        default => false,
    };

    $isCompanyActive = match (Route::currentRouteName()) {
        'user.company.index' => true,
        default => false,
    };

    $isProfileActive = match (Route::currentRouteName()) {
        'user.profile' => true,
        default => false,
    };
@endphp

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>
        @yield('title')
    </title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/images/favicon.svg') }}" />

    <!-- Web Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/LineIcons.2.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/main.css') }}" />

</head>

<body>

    {{-- <div id="loading-area"></div> --}}
    <!-- Start Header Area -->
    <header class="header other-page">
        <div class="navbar-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand logo" href="index.html">
                                <img class="logo1" src="{{ asset('front/images/logo/logo.svg') }}" alt="Logo" />
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="@if ($isHomeActive) active @endif"
                                            href="{{ route('user.dashboard') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0)">Categories</a>
                                        <ul class="sub-menu">
                                            <li class="nav-item">
                                                <a href="">
                                                    View All Categories
                                                </a>
                                            </li>
                                            @foreach (App\Models\ProfileCategory::limit(5)->get() as $category)
                                                <li>
                                                    <a href="{{ route('user.company.show', $category->id) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0)"
                                            class="@if ($isPostActive) active @endif">
                                            Posts
                                        </a>

                                        <ul class="sub-menu">
                                            <li>
                                                <a href="#">
                                                    View All Posts
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    View My Posts
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="">
                                                    Create Post
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void(0)"
                                            class="@if ($isJobActive) active @endif">
                                            Jobs
                                        </a>

                                        <ul class="sub-menu">
                                            <li>
                                                <a href="{{ route('user.job.index') }}">
                                                    View All Jobs
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    My Applied Jobs
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    My Saved Jobs
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#"
                                            class="@if ($isCompanyActive) active @endif">Companies</a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="">
                                                    View All Companies
                                                </a>
                                            </li>
                                            @foreach (App\Models\Company::limit(5)->get() as $company)
                                                <li>
                                                    <a href="{{ route('user.company.show', $company->id) }}">
                                                        {{ $company->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#" class="@if ($isProfileActive) active @endif">
                                            {{ Auth::user()->name }}
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="{{ route('user.profile') }}">
                                                    My Profile
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    My Following
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    My Followers
                                                </a>
                                            </li>
                                        </ul>
                                    </li>


                                </ul>
                            </div>
                            <!-- navbar collapse -->
                            <div class="button">
                                <a href="{{ route('user.logout') }}" class="btn">
                                    Logout
                                </a>
                            </div>
                        </nav>
                        <!-- navbar -->
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- navbar area -->
    </header>
    <!-- End Header Area -->

    @yield('content')


    <!-- Login Modal -->
    {{-- <div class="modal fade form-modal" id="login" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal">
                <i class="lni lni-close"></i>
            </button>
            <div class="login-modal-main">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="row">
                            <div class="heading">
                                <h3>Login From Here</h3>
                                <p>
                                    Log in to continue your account <br />
                                    and explore new jobs.
                                </p>
                            </div>
                            <div class="social-login">
                                <ul>
                                    <li>
                                        <a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i>
                                            Log in with
                                            LinkedIn</a>
                                    </li>
                                    <li>
                                        <a class="google" href="#"><i class="lni lni-google"></i> Log in with
                                            Google</a>
                                    </li>
                                    <li>
                                        <a class="facebook" href="#"><i class="lni lni-facebook-original"></i>
                                            Log in with
                                            Facebook</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="https://demo.graygrids.com/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com"
                                        id="email" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Enter password" />
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <!-- Default checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault" />
                                        <label class="form-check-label" for="flexCheckDefault">Remember
                                            password</label>
                                    </div>
                                    <a href="#" class="font-size-3 text-dodger line-height-reset">Forget
                                        Password</a>
                                </div>
                                <div class="form-group mb-8 button">
                                    <button class="btn">Log in</button>
                                </div>
                                <p class="text-center create-new-account">
                                    Don’t have an account? <a href="#">Create a free account</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Login Modal -->

    <!-- Signup Modal -->
    {{-- <div class="modal fade form-modal" id="signup" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog max-width-px-840 position-relative">
            <button type="button"
                class="circle-32 btn-reset bg-white pos-abs-tr mt-md-n6 mr-lg-n6 focus-reset z-index-supper"
                data-dismiss="modal">
                <i class="lni lni-close"></i>
            </button>
            <div class="login-modal-main">
                <div class="row no-gutters">
                    <div class="col-12">
                        <div class="row">
                            <div class="heading">
                                <h3>
                                    Create a free Account <br />
                                    Today
                                </h3>
                                <p>
                                    Create your account to continue <br />
                                    and explore new jobs.
                                </p>
                            </div>
                            <div class="social-login">
                                <ul>
                                    <li>
                                        <a class="linkedin" href="#"><i class="lni lni-linkedin-original"></i>
                                            Import from
                                            LinkedIn</a>
                                    </li>
                                    <li>
                                        <a class="google" href="#"><i class="lni lni-google"></i> Import from
                                            Google</a>
                                    </li>
                                    <li>
                                        <a class="facebook" href="#"><i class="lni lni-facebook-original"></i>
                                            Import from
                                            Facebook</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="or-devider">
                                <span>Or</span>
                            </div>
                            <form action="https://demo.graygrids.com/">
                                <div class="form-group">
                                    <label for="email" class="label">E-mail</label>
                                    <input type="email" class="form-control" placeholder="example@gmail.com" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" placeholder="Enter password" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="label">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" placeholder="Enter password" />
                                    </div>
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between">
                                    <!-- Default checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" />
                                        <label class="form-check-label" for="flexCheckDefault">Agree to the <a
                                                href="#">Terms & Conditions</a></label>
                                    </div>
                                </div>
                                <div class="form-group mb-8 button">
                                    <button class="btn">Sign Up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Signup Modal -->

    <!-- Start Footer Area -->
    <footer class="footer">
        <!-- Footer Top -->
        {{-- <div class="footer-top">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-12">
                        <div class="download-text">
                            <h3>Download Our Best Apps</h3>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                do<br />
                                eiusmod tempor incididunt ut labore et dolore
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="download-button">
                            <div class="button">
                                <a class="btn" href="#"><i class="lni lni-apple"></i> App Store</a>
                                <a class="btn" href="#"><i class="lni lni-play-store"></i> Google Play</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- End Footer Top -->
        <!-- Start Middle Top -->
        {{-- <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="f-about single-footer">
                            <div class="logo">
                                <a href="index.html"><img src="assets/images/logo/logo.svg" alt="Logo" /></a>
                            </div>
                            <p>
                                Start building your creative website with our awesome template
                                Massive.
                            </p>
                            <ul class="contact-address">
                                <li><span>Address:</span> 555 Wall Street, USA, NY</li>
                                <li><span>Email:</span> example@apus.com</li>
                                <li><span>Call:</span> 555-555-1234</li>
                            </ul>
                            <div class="footer-social">
                                <ul>
                                    <li>
                                        <a href="#"><i class="lni lni-facebook-original"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-twitter-original"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-linkedin-original"></i></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-pinterest"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <!-- Single Widget -->
                                <div class="single-footer f-link">
                                    <h3>For Candidates</h3>
                                    <ul>
                                        <li><a href="#">User Dashboard</a></li>
                                        <li><a href="#">CV Packages</a></li>
                                        <li><a href="#">Jobs Featured</a></li>
                                        <li><a href="#">Jobs Urgent</a></li>
                                        <li><a href="#">Candidate List</a></li>
                                        <li><a href="#">Candidates Grid</a></li>
                                    </ul>
                                </div>
                                <!-- End Single Widget -->
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <!-- Single Widget -->
                                <div class="single-footer f-link">
                                    <h3>For Employers</h3>
                                    <ul>
                                        <li><a href="#">Post New</a></li>
                                        <li><a href="#">Employer List</a></li>
                                        <li><a href="#">Employers Grid</a></li>
                                        <li><a href="#">Job Packages</a></li>
                                        <li><a href="#">Jobs Listing</a></li>
                                        <li><a href="#">Jobs Featured</a></li>
                                    </ul>
                                </div>
                                <!-- End Single Widget -->
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <!-- Single Widget -->
                                <div class="single-footer newsletter">
                                    <h3>Join Our Newsletter</h3>
                                    <p>
                                        Subscribe to get the latest jobs posted, candidates...
                                    </p>
                                    <form action="https://demo.graygrids.com/themes/jobgrids/mail/mail.php"
                                        method="get" target="_blank" class="newsletter-inner">
                                        <input name="EMAIL" placeholder="Your email address" class="common-input"
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Your email address'" required=""
                                            type="email" />
                                        <div class="button">
                                            <button class="btn">
                                                Subscribe Now! <span class="dir-part"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- End Single Widget -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--/ End Footer Middle -->
        <!-- Start Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="left">
                                <p>
                                    Designed and Developed by<a href="https://graygrids.com/" rel="nofollow"
                                        target="_blank">GrayGrids</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="right">
                                <ul>
                                    <li><a href="#">Terms of use</a></li>
                                    <li><a href="#"> Privacy Policy</a></li>
                                    <li><a href="#">Faq</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Middle -->
    </footer>
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>
</body>

<!-- ========================= JS here ========================= -->
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/wow.min.js') }}"></script>
<script src="{{ asset('front/js/tiny-slider.js') }}"></script>
<script src="{{ asset('front/js/glightbox.min.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
<script type="text/javascript">
    //====== Clients Logo Slider
    // tns({
    //     container: ".client-logo-carousel",
    //     slideBy: "page",
    //     autoplay: true,
    //     autoplayButtonOutput: false,
    //     mouseDrag: true,
    //     gutter: 15,
    //     nav: false,
    //     controls: false,
    //     responsive: {
    //         0: {
    //             items: 1,
    //         },
    //         540: {
    //             items: 2,
    //         },
    //         768: {
    //             items: 3,
    //         },
    //         992: {
    //             items: 4,
    //         },
    //         1170: {
    //             items: 6,
    //         },
    //     },
    // });
    // //========= testimonial
    // tns({
    //     container: ".testimonial-slider",
    //     items: 1,
    //     slideBy: "page",
    //     autoplayButtonOutput: false,
    //     autoplay: true,
    //     mouseDrag: true,
    //     gutter: 0,
    //     nav: false,
    //     controls: true,
    //     controlsText: [
    //         '<i class="lni lni-arrow-left"></i>',
    //         '<i class="lni lni-arrow-right"></i>',
    //     ],
    //     responsive: {
    //         0: {
    //             items: 1,
    //         },
    //         540: {
    //             items: 1,
    //         },
    //         768: {
    //             items: 1,
    //         },
    //         992: {
    //             items: 1,
    //         },
    //         1170: {
    //             items: 1,
    //         },
    //     },
    // });

    // //======== Home Slider
    // var slider = new tns({
    //     container: ".home-slider",
    //     slideBy: "page",
    //     autoplay: true,
    //     autoplayButtonOutput: false,
    //     mouseDrag: true,
    //     gutter: 0,
    //     items: 1,
    //     nav: false,
    //     controls: true,
    //     controlsText: [
    //         '<i class="lni lni-arrow-left prev"></i>',
    //         '<i class="lni lni-arrow-right next"></i>',
    //     ],
    //     responsive: {
    //         1200: {
    //             items: 1,
    //         },
    //         992: {
    //             items: 1,
    //         },
    //         0: {
    //             items: 1,
    //         },
    //     },
    // });
</script>


</html>
