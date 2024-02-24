@extends('user.profile.layout.app')
@section('title', 'Change Password')
@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="password-content">
            <h3>Change Password</h3>
            <p>
                You can change your password from here.
            </p>
            <form action="{{ route('user.profile.doChangePassword') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>
                                Old Password
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control @error('currentPassword') is-invalid border-danger border-2 @enderror"
                                type="password" name="currentPassword" placeholder="Enter your old password" />
                            @error('currentPassword')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>
                                New Password
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control @error('newPassword') is-invalid border-danger border-2 @enderror"
                                type="password" name="newPassword" placeholder="Enter your new password" />

                            @error('newPassword')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>
                                Confirm Password
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control @error('confirmPassword') is-invalid border-danger border-2 @enderror"
                                type="password" name="confirmPassword" placeholder="Enter your new password again" />
                            @error('confirmPassword')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="button">
                            <button class="btn">
                                Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
