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
                                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                        Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.doChangePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin.editProfileImage') }}">
                                        Change Profile Image
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="profile-overview">
                                    <h5 class="card-title">
                                        Change Profile Image
                                    </h5>
                                    <form action="{{ route('admin.updateProfileImage') }}" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="row row-cols-3 mb-3">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Profile Image
                                            </div>
                                            <div class=" col col-lg-9 col-md-8">
                                                @csrf
                                                <div class="input-group col">
                                                    <input name="profile_image_url" type="file" class="form-control"
                                                        id="profile_image_url" />
                                                </div>
                                                @error('profile_image_url')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary btn-space">
                                                Update
                                            </button>
                                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-space">
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
