@extends('user.layout.app')
@section('pageTitle', 'Edit Resume | ' . env('APP_NAME'))
@section('content')

    <main id="main" class="main">
        <section class="section profile">
            <div class="row">
                <div class="col-xl-">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <a href="{{ route('user.dashboard') }}" class="nav-link">
                                        Overview
                                    </a>
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
                                    <a class="nav-link active" href="{{ route('user.editResumePdf') }}">
                                        Change Resume PDF
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="profile-overview">
                                    <h5 class="card-title">
                                        Change Resume PDF
                                    </h5>
                                    <form action="{{ route('user.updateResumePdf') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="row row-cols-3 mb-3">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Resume PDF
                                            </div>
                                            <div class=" col col-lg-9 col-md-8">
                                                @csrf
                                                <div class="input-group col">
                                                    <input name="resume_pdf_url" type="file"
                                                        class="form-control @error('resume_pdf_url') is-invalid @enderror"
                                                        id="resume_pdf_url" />
                                                </div>
                                                @error('resume_pdf_url')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary btn-space">
                                                Update
                                            </button>
                                            <a href="{{ route('user.dashboard') }}" class="btn btn-danger btn-space">
                                                Cancel
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
