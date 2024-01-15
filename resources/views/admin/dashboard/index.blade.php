@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')

    {{-- 

        name
        email
        password
        userType
        profileImage
        resume_pdf_url
        contact
        gender
        is_active
        headline
        education
        interest
        hobby
        city
        about
        experience

    --}}

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
                            </ul>

                            <div class="tab-content pt-2">
                                <div class="profile-overview">
                                    <h5 class="card-title">
                                        Profile Details
                                    </h5>
                                    <div class="row mb-3">
                                        <div class=" align-self-center col-lg-3 col-md-4 label">
                                            Profile Image
                                        </div>
                                        <div class="col col-md-8 col-lg-9">
                                            <img class=" col img-fluid rounded-pill"
                                                src="{{ asset('admin/img/profile-img.jpg') }}" alt="Profile" />
                                            <div class="pt-2">
                                                <a href="#" class="btn btn-primary btn-sm"
                                                    title="Upload new profile image">
                                                    <i class="bi bi-upload"></i>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-sm"
                                                    title="Remove my profile image">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-lg-3 col-md-4 label">
                                            Full Name
                                        </div>
                                        <div class="col col-lg-9 col-md-8">
                                            {{ Auth::guard('admin')->user()->name }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Email
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ Auth::guard('admin')->user()->email }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Contact
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{-- check if not available --}}
                                            @if (Auth::guard('admin')->user()->contact == null)
                                                Not Available
                                            @else
                                                {{ Auth::guard('admin')->user()->contact }}
                                            @endif
                                        </div>
                                    </div>
                                    {{-- gender --}}





                                    {{--  --}}
                                    <div class="row mb-3">
                                        <div class=" align-self-center col-lg-3 col-md-4 label">
                                            Resume PDF
                                        </div>
                                        <div class="col col-md-8 col-lg-9">
                                            <img class=" col img-fluid rounded-pill"
                                                src="{{ asset('admin/img/profile-img.jpg') }}" alt="Profile" />
                                        </div>
                                    </div>
                                    {{--  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
