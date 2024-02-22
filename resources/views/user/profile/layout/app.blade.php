@extends('user.layout.app')
@section('title', 'Profile')
@section('content')
    @php
        $isProfileActive = match (Route::currentRouteName()) {
            'user.profile' => true,
            default => false,
        };
    @endphp
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Profile</h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Id beatae, doloremque<br />
                            doloribus, similique ullam quos tempore nemo,
                            voluptatibus placeat dignissimos ea.
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li>Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Main Content Start -->
    <div class="resume section">
        <div class="container">
            <div class="resume-inner">
                <div class="row">
                    <!-- Start Main Content -->
                    <div class="col-lg-4 col-12">
                        <div class="dashbord-sidebar">
                            <ul>
                                <li class="heading">Manage Account</li>
                                <li>
                                    <a class="
                                        @if ($isProfileActive) active @endif
                                    "
                                        href="{{ route('user.profile') }}">
                                        <i class="lni lni-user"></i>
                                        My Profile</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="lni lni-briefcase"></i>
                                        Applied Jobs
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="lni lni-bookmark"></i>
                                        Saved Jobs
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="lni lni-envelope"></i>
                                        Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.logout') }}">
                                        <i class="lni lni-exit"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Main Content -->
                    @yield('profile-content')
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content end -->
@endsection
