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
                                    <a href='{{ route('admin_company.dashboard') }}' class="nav-link">
                                        Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin_company.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin_company.doChangePassword') }}">
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
                                        Edit Profile Details
                                    </h5>
                                    <form action="{{ route('admin_company.updateProfile') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Full Name
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="name" type="text"
                                                    class="form-control
                                                @error('name') is-invalid @enderror"
                                                    id="name"
                                                    value="{{ old('name', auth()->guard('company')->user()->name) }}" />
                                                @error('name')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Email
                                            </div>
                                            <div class="col-lg-9 col-md-8">
                                                <span
                                                    class="form-control is-valid">{{ auth()->guard('company')->user()->email }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Website
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="website" type="text" class="form-control" id="website"
                                                    value="{{ old('website', auth()->guard('company')->user()->website) }}" />
                                                @error('website')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                City
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="city" type="text" class="form-control" id="city"
                                                    value="{{ old('city', auth()->guard('company')->user()->city) }}" />
                                                @error('city')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Address
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="address" type="text" class="form-control" id="address"
                                                    value="{{ old('address', auth()->guard('company')->user()->address) }}" />
                                                @error('address')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                LinkedIn Profile
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="linkedin" type="text" class="form-control" id="linkedin"
                                                    value="{{ old('linkedin', auth()->guard('company')->user()->linkedin) }}" />
                                                @error('linkedin')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Description
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <textarea name="description" type="text" class="form-control" id="description" rows="5">{{ old('description', auth()->guard('company')->user()->description) }}</textarea>
                                                @error('description')
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
        </section>
    </main>
@endsection
