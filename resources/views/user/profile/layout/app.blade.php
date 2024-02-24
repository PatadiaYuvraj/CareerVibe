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

        // $isNotificationsActive = match (Route::currentRouteName()) {
        //     'user.profile.notifications' => true,
        //     default => false,
        // };

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
                                <li class="heading">
                                    Manage Account
                                </li>
                                <li>
                                    <a class="@if ($isProfileActive) active @endif"
                                        href="@if ($isProfileActive) javascript:void(0)
                                         @else{{ route('user.profile.index') }} @endif">
                                        <i class="lni lni-user"></i>
                                        My Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isAppliedJobsActive) active @endif"
                                        href="@if ($isAppliedJobsActive) javascript:void(0)
                                         @else{{ route('user.profile.appliedJobs') }} @endif">
                                        <i class="lni lni-briefcase"></i>
                                        Applied Jobs
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isSavedJobsActive) active @endif"
                                        href="@if ($isSavedJobsActive) javascript:void(0)
                                         @else{{ route('user.profile.savedJobs') }} @endif">
                                        <i class="lni lni-bookmark"></i>
                                        Saved Jobs
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isFollowersActive) active @endif"
                                        href="@if ($isFollowersActive) javascript:void(0)
                                         @else{{ route('user.profile.followers') }} @endif">
                                        <i class="lni lni-users"></i>
                                        My Followers
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isFollowingActive) active @endif"
                                        href="@if ($isFollowingActive) javascript:void(0)
                                         @else{{ route('user.profile.following') }} @endif">
                                        <i class="lni lni-users"></i>
                                        My Following
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="@if ($isNotificationsActive = '') active @endif"
                                        href="@if ($isNotificationsActive) javascript:void(0)
                                         @else{{ route('user.profile.index') }} @endif">
                                        <i class="lni lni-alarm"></i>
                                        Notifications
                                        <span class="badge py-2 px-2" style="background-color: #2042e3">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a class="@if ($isChangePasswordActive) active @endif"
                                        href="@if ($isChangePasswordActive) javascript:void(0)
                                         @else{{ route('user.profile.changePassword') }} @endif">
                                        <i class="lni lni-lock-alt"></i>
                                        Change Password
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isEditProfileActive) active @endif"
                                        href="@if ($isEditProfileActive) javascript:void(0)
                                         @else{{ route('user.profile.editProfile') }} @endif">
                                        <i class="lni lni-envelope"></i>
                                        Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isSetProfileImageActive) active @endif"
                                        href="@if ($isSetProfileImageActive) javascript:void(0)
                                         @else{{ route('user.profile.editProfileImage') }} @endif">
                                        @if (auth()->user()->profile_image_url)
                                            <i class="lni lni-image"></i>
                                            Update Profile Image
                                        @else
                                            <i class="lni lni-add-files"></i>
                                            Add Profile Image
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="@if ($isSetResumeActive) active @endif"
                                        href="@if ($isSetResumeActive) javascript:void(0)
                                         @else{{ route('user.profile.editResumePdf') }} @endif">
                                        @if (auth()->user()->resume_pdf_url)
                                            <i class="lni lni-files"></i>
                                            Update Resume
                                        @else
                                            <i class="lni lni-add-files"></i>
                                            Add Resume
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
