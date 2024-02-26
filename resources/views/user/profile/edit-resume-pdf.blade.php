@extends('user.profile.layout.app')

@section('title', 'Edit Profile')

@section('profile-breadcrumb-content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">
                            @if (auth()->user()->resume_pdf_url)
                                Edit Resume PDF
                            @else
                                Add Resume PDF
                            @endif
                        </h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Id beatae, doloremque<br />
                            doloribus, similique ullam quos tempore nemo,
                            voluptatibus placeat dignissimos ea.
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li>
                            <a href="{{ route('user.dashboard') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('user.profile.index') }}">Profile</a>
                        </li>
                        <li>
                            @if (auth()->user()->resume_pdf_url)
                                Edit Resume PDF
                            @else
                                Add Resume PDF
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
@endsection

@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="password-content">
            <h3>
                Edit Resume PDF
            </h3>
            <p>
                You can upload your resume here.<br /> It will be visible to the
                employers when you apply for a job.
            </p>
            <form action="{{ route('user.profile.updateResumePdf') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class=" form-group">
                            <div class="input-grou mb-3">
                                <label
                                    class="input-group-text @error('resume_pdf_url') text-danger is-invalid border-danger border-2 @enderror"
                                    for="resume_pdf_url">
                                    <i class="lni lni-upload"></i>
                                    Browse File
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="d-none" type="file" class="form-control" id="resume_pdf_url"
                                    name="resume_pdf_url" accept="application/pdf">
                                @error('resume_pdf_url')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="button">
                            <button class="btn">
                                Upload Resume
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @if (auth()->user()->resume_pdf_url)
                <div class="card p-3 mt-4">
                    <h5 class="text-center text-primary mb-3">
                        Your Resume
                    </h5>

                    <embed class="table-responsive card border-info" src="{{ auth()->user()->resume_pdf_url }}"
                        type="application/pdf" frameBorder="0" scrolling="auto" height="500px" width="100%"></embed>

                    <div class="d-flex btn-group mt-3">

                        <a href="{{ auth()->user()->resume_pdf_url }}" target="_blank" class="btn btn-primary">
                            View Resume
                        </a>

                        <a href="{{ route('user.profile.deleteResumePdf') }}" class="btn btn-danger">
                            Delete Resume
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-warning alert-dismissible fade show mt-4 text-center" role="alert">
                    No resume uploaded yet
                </div>
            @endif
        </div>
    </div>
@endsection
