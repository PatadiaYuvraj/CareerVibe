@extends('user.profile.layout.app')
@section('title', 'Edit Profile Image')
@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="password-content">
            <h3>
                Edit Profile Image
            </h3>
            <p>
                You can upload your profile image here.<br /> It will be visible to the
                employers when you apply for a job.
            </p>
            <form action="{{ route('user.profile.updateProfileImage') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class=" form-group">
                            <div class="input-grou mb-3">
                                <label
                                    class="input-group-text @error('profile_image_url') text-danger is-invalid border-danger border-2 @enderror"
                                    for="profile_image_url">
                                    <i class="lni lni-upload"></i>
                                    Browse File
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="d-none" type="file" class="form-control" id="profile_image_url"
                                    name="profile_image_url"
                                    accept="
                                    image/png, image/jpeg, image/jpg">
                                @error('profile_image_url')
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
                                Upload File
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @if (auth()->user()->profile_image_url)
                <div class="card p-3 mt-4">
                    <h5 class="text-center text-primary mb-3">
                        Your Profile Image
                    </h5>
                    <img src="{{ auth()->user()->profile_image_url }}" alt="Profile Image"
                        class="img-fluid card p-1 border-info">
                    <div class="d-flex btn-group mt-3">

                        <a href="{{ auth()->user()->profile_image_url }}" target="_blank" class="btn btn-primary">
                            View Image
                        </a>

                        <a href="{{ route('user.profile.deleteProfileImage') }}" class="btn btn-danger">
                            Delete Image
                        </a>
                    </div>
                </div>
            @else
                <div class="alert alert-warning alert-dismissible fade show mt-4 text-center" role="alert">
                    No profile image uploaded yet
                </div>
            @endif
        </div>
    </div>
@endsection
