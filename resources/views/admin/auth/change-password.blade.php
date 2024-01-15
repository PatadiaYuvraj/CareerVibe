@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Change Password
                    </span>
                    <a href="{{ route('admin.dashboard') }}" class="float-end btn btn-sm btn-primary">
                        Back to Dashboard
                    </a>
                </div>
                <div class="card-body pt-3">
                    <form action="{{ route('admin.doChangePassword') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">
                                Current Password
                            </label>
                            <div class="col-md-8 col-lg-9">
                                <input name="currentPassword" type="password" class="form-control" id="currentPassword" />
                                @error('currentPassword')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">
                                New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="newPassword" type="password" class="form-control" id="newPassword" />
                                @error('newPassword')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Confirm
                                Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" />
                                @error('confirmPassword')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection
