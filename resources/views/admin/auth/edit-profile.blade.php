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
                                    <a href='{{ route('admin.dashboard') }}' class="nav-link">
                                        Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin.editProfile') }}">
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
                                <div class="card-body pt-3">
                                    <div class="row mb-3">
                                        <label for="profile_image_url" class="col-md-4 col-lg-3 col-form-label">
                                            Profile Image
                                        </label>
                                        <div class="col-md-8 col-lg-9">

                                            <form action="{{ route('admin.updateProfileImage') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group">
                                                    <input name="profile_image_url" type="file" class="form-control"
                                                        id="profile_image_url" />
                                                    <button type="submit" class="btn btn-primary">
                                                        Upload
                                                    </button>
                                                </div>
                                                @error('profile_image_url')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </form>

                                        </div>
                                    </div>
                                    <form action="{{ route('admin.updateProfile') }}" method="POST">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-lg-3 col-form-label">
                                                Name
                                            </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text" class="form-control" id="name"
                                                    value="{{ auth()->guard('admin')->user()->name }}" />
                                                @error('name')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-lg-3 col-form-label">
                                                Email
                                            </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="text" class="form-control" id="email"
                                                    value="{{ auth()->guard('admin')->user()->email }}" />
                                                @error('email')
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
