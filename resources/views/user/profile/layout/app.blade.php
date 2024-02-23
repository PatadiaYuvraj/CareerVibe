@extends('user.layout.app')
@section('title', 'Profile')
@section('content')
    @php
        $isProfileActive = match (Route::currentRouteName()) {
            'user.profile.index' => true,
            default => false,
        };

        $isAppliedJobsActive = match (Route::currentRouteName()) {
            'user.profile.appliedJobs' => true,
            default => false,
        };

        $isSavedJobsActive = match (Route::currentRouteName()) {
            'user.profile.savedJobs' => true,
            default => false,
        };

        $isFollowersActive = match (Route::currentRouteName()) {
            'user.profile.followers' => true,
            default => false,
        };

        $isFollowingActive = match (Route::currentRouteName()) {
            'user.profile.following' => true,
            default => false,
        };

        $isChangePasswordActive = match (Route::currentRouteName()) {
            'user.profile.changePassword' => true,
            default => false,
        };

        $isEditProfileActive = match (Route::currentRouteName()) {
            'user.profile.editProfile' => true,
            default => false,
        };

        $isSetProfileImageActive = match (Route::currentRouteName()) {
            'user.profile.editProfileImage' => true,
            default => false,
        };

        $isSetResumeActive = match (Route::currentRouteName()) {
            'user.profile.editResumePdf' => true,
            default => false,
        };

    @endphp
    <!-- Start Breadcrumbs -->
    {{-- <div class="breadcrumbs overlay">
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
    </div> --}}
    <!-- End Breadcrumbs -->

    <!-- Main Content Start -->
    <div class="resume change-password section">
        <div class="container">
            <div class="resume-inner">
                <div class="row">
                    <!-- Start Main Content -->
                    <div class="col-lg-4 col-12">
                        <div class="dashbord-sidebar">
                            <ul>
                                <li class="heading">Manage Account</li>
                                <li>
                                    <a class="@if ($isProfileActive) active @endif"
                                        href="{{ route('user.profile.index') }}">
                                        <i class="lni lni-user"></i>
                                        My Profile</a>
                                </li>
                                <li>
                                    <a class="@if ($isAppliedJobsActive) active @endif"
                                        href="{{ route('user.profile.appliedJobs') }}">
                                        <i class="lni lni-briefcase"></i>
                                        Applied Jobs
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isSavedJobsActive) active @endif"
                                        href="{{ route('user.profile.savedJobs') }}">
                                        <i class="lni lni-bookmark"></i>
                                        Saved Jobs
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isFollowersActive) active @endif"
                                        href="{{ route('user.profile.followers') }}">
                                        <i class="lni lni-users"></i>
                                        My Followers
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isFollowingActive) active @endif"
                                        href="{{ route('user.profile.following') }}">
                                        <i class="lni lni-users"></i>
                                        My Following
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isChangePasswordActive) active @endif"
                                        href="{{ route('user.profile.changePassword') }}">
                                        <i class="lni lni-lock-alt"></i>
                                        Change Password
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isEditProfileActive) active @endif"
                                        href="{{ route('user.profile.editProfile') }}">
                                        <i class="lni lni-envelope"></i>
                                        Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="
                                        @if ($isSetProfileImageActive) active @endif"
                                        href="{{ route('user.profile.editProfileImage') }}">
                                        <i class="lni lni-envelope"></i>
                                        @if (auth()->user()->profile_image_url)
                                            Update Profile Image
                                        @else
                                            Set Profile Image
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isSetResumeActive) active @endif"
                                        href="{{ route('user.profile.editResumePdf') }}">
                                        <i class="lni lni-envelope"></i>
                                        @if (auth()->user()->resume_pdf_url)
                                            Update Resume
                                        @else
                                            Set Resume
                                        @endif
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
