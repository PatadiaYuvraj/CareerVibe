@extends('user.layout.app')
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
                                    <a class="nav-link" href="{{ route('user.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.doChangePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.editProfileImage') }}">
                                        Change Profile Image
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.editResumePdf') }}">
                                        Change Resume PDF
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
                                        @if (auth()->guard('user')->user()->profile_image_url)
                                            <div class="col row row-cols-2">
                                                <img src="{{ auth()->guard('user')->user()->profile_image_url }}"
                                                    alt="Profile Image" class="col p-1 img-thumbnail" width="100"
                                                    height="100">
                                                <form class="col" action="{{ route('user.deleteProfileImage') }}"
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
                                            {{ auth()->guard('user')->user()->name }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Email
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ auth()->guard('user')->user()->email }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Resume
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->resume_pdf_url)
                                                <a href="{{ url(auth()->guard('user')->user()->resume_pdf_url) }}"
                                                    target="_blank" class="btn btn-primary btn-sm">View</a>
                                                <!-- delete user.deleteResumePdf get -->
                                                <form action="{{ route('user.deleteResumePdf') }}" method="GET"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            @else
                                                <span class="text-danger">No Resume Uploaded</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- contact -->
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Contact
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->contact)
                                                {{ auth()->guard('user')->user()->contact }}
                                            @else
                                                <span class="text-danger">No Contact</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Gender
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->gender)
                                                {{ auth()->guard('user')->user()->gender }}
                                            @else
                                                <span class="text-danger">No Gender</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            City
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->city)
                                                {{ auth()->guard('user')->user()->city }}
                                            @else
                                                <span class="text-danger">No City</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Headline
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->headline)
                                                {{ auth()->guard('user')->user()->headline }}
                                            @else
                                                <span class="text-danger">No Headline</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Education
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->education)
                                                {{ auth()->guard('user')->user()->education }}
                                            @else
                                                <span class="text-danger">No Education</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Interest
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->interest)
                                                {{ auth()->guard('user')->user()->interest }}
                                            @else
                                                <span class="text-danger">No Interest</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Hobby
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->hobby)
                                                {{ auth()->guard('user')->user()->hobby }}
                                            @else
                                                <span class="text-danger">No Hobby</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            About
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->about)
                                                {{ auth()->guard('user')->user()->about }}
                                            @else
                                                <span class="text-danger">No About</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Experience
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            @if (auth()->guard('user')->user()->experience)
                                                {{ auth()->guard('user')->user()->experience }}
                                            @else
                                                <span class="text-danger">No Experience</span>
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
