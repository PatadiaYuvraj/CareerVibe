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
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.editProfileImage') }}">
                                        Change Profile Image
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="profile-overview">
                                    <h5 class="card-title">
                                        Profile Details
                                    </h5>
                                    {{-- <div class="row row-cols-3 mb-3">
                                        <div class="col col-lg-3 col-md-4 label">
                                            Profile Image
                                        </div>
                                        <div class=" col col-lg-9 col-md-8">
                                            <form action="{{ route('admin.updateProfileImage') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group col">
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
                                    </div> --}}
                                    <form action="{{ route('admin.updateProfile') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Full Name
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="name" type="text" class="form-control" id="name"
                                                    value="{{ old('name') ??auth()->guard('admin')->user()->name }}" />
                                                @error('name')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Email
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="email" type="text" class="form-control" id="email"
                                                    value="{{ old('email') ??auth()->guard('admin')->user()->email }}" />
                                                @error('email')
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
