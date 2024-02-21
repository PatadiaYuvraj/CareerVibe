@extends('admin_user.layout.app')
@section('pageTitle', 'User Dashboard | ' . env('APP_NAME'))
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
                                    <a class="nav-link" href="{{ route('admin_user.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_user.doChangePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_user.editProfileImage') }}">
                                        Change Profile Image
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_user.editResumePdf') }}">
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
                                                <form class="col" action="{{ route('admin_user.deleteProfileImage') }}"
                                                    id="deleteProfileImageForm" method="POST">
                                                    @csrf
                                                    <button type="button" id="deleteProfileImage"
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
                                                <!-- delete admin_user.deleteResumePdf get -->
                                                <form action="{{ route('admin_user.deleteResumePdf') }}" method="GET"
                                                    class="d-inline" id="deleteResumePdfForm">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        id="deleteResumePdf">Delete</button>
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
                                                {{ Config::get('constants.gender.' . auth()->guard('user')->user()->gender) }}
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
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Applied Jobs
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            You have applied for
                                            {{ auth()->guard('user')->user()->appliedJobs->count() }}
                                            @if (auth()->guard('user')->user()->appliedJobs->count() <= 1)
                                                job
                                            @else
                                                jobs
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            saved Jobs
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{-- saved jobs --}}
                                            You have saved
                                            {{ auth()->guard('user')->user()->savedJobs->count() }}
                                            @if (auth()->guard('user')->user()->savedJobs->count() <= 1)
                                                job
                                            @else
                                                jobs
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Your Posts
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            You have {{ auth()->guard('user')->user()->posts->count() }}
                                            @if (auth()->guard('user')->user()->posts->count() <= 1)
                                                post
                                            @else
                                                posts
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Your Followers
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            You have {{ auth()->guard('user')->user()->followers->count() }}
                                            @if (auth()->guard('user')->user()->followers->count() <= 1)
                                                follower
                                            @else
                                                followers
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Users Following
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            You are following {{ auth()->guard('user')->user()->following->count() }}
                                            @if (auth()->guard('user')->user()->following->count() <= 1)
                                                user
                                            @else
                                                users
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Companies Following
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            You are following
                                            {{ auth()->guard('user')->user()->followingCompanies->count() }}
                                            @if (auth()->guard('user')->user()->followingCompanies->count() <= 1)
                                                company
                                            @else
                                                companies
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">
                                            Total Following
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            You are following
                                            {{ auth()->guard('user')->user()->following->count() + auth()->guard('user')->user()->followingCompanies->count() }}
                                            @if (auth()->guard('user')->user()->following->count() + auth()->guard('user')->user()->followingCompanies->count() <= 1)
                                                user/company
                                            @else
                                                users/companies
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#deleteProfileImage').click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete your profile image?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                        setTimeout(function() {
                            $('#deleteProfileImageForm').submit();
                        }, 2000);
                    }

                    if (result.isDismissed) {
                        Swal.fire({
                            title: "Cancelled!",
                            text: "Your file is safe.",
                            icon: "error"
                        });
                    }

                }).catch((error) => {
                    console.error('Error:', error);
                });
            });


            $('#deleteResumePdf').click(function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete your resume pdf?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                        setTimeout(function() {
                            $('#deleteResumePdfForm').submit();
                        }, 2000);
                    }

                    if (result.isDismissed) {
                        Swal.fire({
                            title: "Cancelled!",
                            text: "Your file is safe.",
                            icon: "error"
                        });
                    }

                }).catch((error) => {
                    console.error('Swal Error :', error);
                });
            });

        });
    </script>

@endsection
