@extends('admin.layout.app')
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
                                    <a class="nav-link" href="{{ route('admin.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.doChangePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.editProfileImage') }}">
                                        Change Profile Image
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
                                        @if (auth()->guard('admin')->user()->profile_image_url)
                                            <div class="col row row-cols-2">
                                                <img src="{{ auth()->guard('admin')->user()->profile_image_url }}"
                                                    alt="Profile Image" class="col p-1 img-thumbnail" width="100"
                                                    height="100">
                                                <form class="col" action="{{ route('admin.deleteProfileImage') }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Are you sure you want to delete this profile image?')"
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
                                            {{ auth()->guard('admin')->user()->name }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Email
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ auth()->guard('admin')->user()->email }}
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
