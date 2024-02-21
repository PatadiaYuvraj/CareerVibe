@extends('admin_company.layout.app')
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
                                    <a href="{{ route('admin_company.dashboard') }}" class="nav-link ">
                                        Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_company.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin_company.doChangePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_company.editProfileImage') }}">
                                        Change Profile Image
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content pt-2">
                                <div class="profile-overview">
                                    <h5 class="card-title">
                                        Change Password
                                    </h5>
                                    <form action="{{ route('admin_company.doChangePassword') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Old Password
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="currentPassword" type="password"
                                                    class="form-control @error('currentPassword') is-invalid @enderror"
                                                    id="currentPassword" placeholder="Enter your current password" />
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
                                                    class="form-control
                                                    @error('newPassword') is-invalid @enderror"
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
                                                    class="form-control
                                                    @error('confirmPassword') is-invalid @enderror"
                                                    id="confirmPassword" placeholder="Confirm new password" />
                                                @error('confirmPassword')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                            <a href="{{ route('admin_company.dashboard') }}" class="btn btn-danger">
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
