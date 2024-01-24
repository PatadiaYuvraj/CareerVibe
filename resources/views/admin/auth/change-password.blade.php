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
                                    <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                                        Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin.doChangePassword') }}">
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
                                <form action="{{ route('admin.doChangePassword') }}" method="POST">
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
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="currentPassword"
                                                        name="currentPassword" placeholder="Old Password" value="">
                                                    <span id="toggleOldPassword"
                                                        class="bi-eye-slash input-group-text"></span>
                                                </div>
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
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="newPassword"
                                                        name="newPassword" placeholder="New Password" value="">
                                                    <span id="toggleNewPassword"
                                                        class="bi-eye-slash input-group-text"></span>
                                                </div>
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
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="confirmPassword"
                                                        name="confirmPassword" placeholder="Confirm Password"
                                                        value="">
                                                    <span id="toggleConfirmPassword"
                                                        class="bi-eye-slash input-group-text"></span>
                                                </div>
                                                @error('confirmPassword')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                            <a href="{{ route('admin.dashboard') }}" type="submit" class="btn btn-danger">
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
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#toggleOldPassword').click(function() {
                if ($(this).hasClass('bi-eye-slash')) {
                    $(this).removeClass('bi-eye-slash');
                    $(this).addClass('bi-eye');
                    $('#oldPassword').attr('type', 'text');
                } else {
                    $(this).removeClass('bi-eye');
                    $(this).addClass('bi-eye-slash');
                    $('#oldPassword').attr('type', 'password');
                }
            });
            $('#toggleNewPassword').click(function() {
                if ($(this).hasClass('bi-eye-slash')) {
                    $(this).removeClass('bi-eye-slash');
                    $(this).addClass('bi-eye');
                    $('#newPassword').attr('type', 'text');
                } else {
                    $(this).removeClass('bi-eye');
                    $(this).addClass('bi-eye-slash');
                    $('#newPassword').attr('type', 'password');
                }
            });
            $('#toggleConfirmPassword').click(function() {
                if ($(this).hasClass('bi-eye-slash')) {
                    $(this).removeClass('bi-eye-slash');
                    $(this).addClass('bi-eye');
                    $('#confirmPassword').attr('type', 'text');
                } else {
                    $(this).removeClass('bi-eye');
                    $(this).addClass('bi-eye-slash');
                    $('#confirmPassword').attr('type', 'password');
                }
            });
        });
    </script>
@endsection
