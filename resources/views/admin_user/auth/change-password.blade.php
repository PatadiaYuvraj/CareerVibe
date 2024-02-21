@extends('admin_user.layout.app')
@section('pageTitle', 'Change Password | ' . env('APP_NAME'))
@section('content')

    <main id="main" class="main">
        <section class="section profile">
            <div class="row">
                <div class="col-xl-">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <a href="{{ route('admin_user.dashboard') }}" class="nav-link ">
                                        Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_user.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin_user.doChangePassword') }}">
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
                                <form action="{{ route('admin_user.doChangePassword') }}" method="POST">
                                    @csrf
                                    <div class="profile-overview">
                                        <h5 class="card-title">
                                            Change Password
                                        </h5>
                                        <div class="row">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Old Password
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="currentPassword" type="password"
                                                    class="form-control @error('currentPassword') is-invalid @enderror"
                                                    placeholder="Enter your current password" id="currentPassword" />
                                                @error('currentPassword')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-lg-3 col-md-4 label">
                                                New Password
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="newPassword" type="password"
                                                    class="form-control @error('newPassword') is-invalid @enderror"
                                                    placeholder="Enter new password" id="newPassword" />
                                                @error('newPassword')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Confirm Password
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="confirmPassword" type="password"
                                                    class="form-control @error('confirmPassword') is-invalid @enderror"
                                                    placeholder="Confirm new password" id="confirmPassword" />
                                                @error('confirmPassword')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                            <a href="{{ route('admin_user.dashboard') }}" type="submit" class="btn btn-danger">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
