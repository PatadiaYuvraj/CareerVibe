@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Edit Profile
                    </span>
                    <a href="{{ route('admin.dashboard') }}" class="float-end btn btn-sm btn-primary">
                        Back to Dashboard
                    </a>
                </div>
                {{-- <form action="{{ route('admin.updateProfileImage') }}" method="POST" enctype="multipart/form-data"> --}}
                <div class="card-body pt-3">
                    <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">
                            Profile Image
                        </label>
                        <div class="col-md-8 col-lg-9">
                            <img src="{{ asset('admin/img/profile-img.jpg') }}" alt="Profile" />
                            <div class="pt-2">
                                <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image">
                                    <i class="bi bi-upload"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </form> --}}
                <div class="card-body">
                    <form action="{{ route('admin.updateProfile') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-lg-3 col-form-label">
                                Name
                            </label>
                            <div class="col-md-8 col-lg-9">
                                <input name="name" type="text" class="form-control" id="name"
                                    value="{{ Auth::guard('admin')->user()->name }}" />
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
                                    value="{{ Auth::guard('admin')->user()->email }}" />
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
        </section>

    </main>
@endsection
