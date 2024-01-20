@extends('company.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section profile">
            <div class="row">
                <div class="col-xl-">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active">
                                        Overview
                                    </button>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('company.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('company.doChangePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content pt-2">
                                <div class="profile-overview">
                                    <h5 class="card-title">
                                        Profile Details
                                    </h5>
                                    <div class="row row-cols-3 mb-3">
                                        <div class="col col-lg-3 col-md-4 label">
                                            Profile Image
                                        </div>
                                        @if (auth()->guard('company')->check() &&
                                                auth()->guard('company')->user()->profile_image_url)
                                            <div class="col row row-cols-2">
                                                <img src="{{ auth()->guard('company')->user()->profile_image_url }}"
                                                    alt="Profile Image" class="col p-1 img-thumbnail" width="100"
                                                    height="100">
                                                <form class="col" action="{{ route('company.deleteProfileImage') }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm mt-2">Delete</button>
                                                </form>

                                            </div>
                                        @else
                                            <div class="col col-lg-9 col-md-8 text-danger">
                                                No Profile Image
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col col-lg-3 col-md-4 label">
                                            Full Name
                                        </div>
                                        <div class="col col-lg-9 col-md-8">
                                            @if (auth()->guard('company')->check())
                                                {{ auth()->guard('company')->user()->name }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Email
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ auth()->guard('company')->user()->email }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Verified
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('company')->user()->is_verified)
                                                <span class="text-success">Yes</span>
                                            @else
                                                <span class="text-danger">No</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Website
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('company')->user()->website)
                                                <a href="{{ auth()->guard('company')->user()->website }}" target="_blank">
                                                    {{ auth()->guard('company')->user()->website }}
                                                </a>
                                            @else
                                                <span class="text-danger">No Website</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            City
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('company')->user()->city)
                                                {{ auth()->guard('company')->user()->city }}
                                            @else
                                                <span class="text-danger">No City</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Address
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('company')->user()->address)
                                                {{ auth()->guard('company')->user()->address }}
                                            @else
                                                <span class="text-danger">No Address</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            LinkedIn Profile
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('company')->user()->linkedin)
                                                <a href="{{ auth()->guard('company')->user()->linkedin }}" target="_blank">
                                                    {{ auth()->guard('company')->user()->linkedin }}
                                                </a>
                                            @else
                                                <span class="text-danger">No LinkedIn Profile</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Description
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('company')->user()->description)
                                                {!! nl2br(
                                                    e(
                                                        auth()->guard('company')->user()->description,
                                                    ),
                                                ) !!}
                                            @else
                                                <span class="text-danger">No Description</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
