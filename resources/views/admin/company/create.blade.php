@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Company</span>
                    <a href="{{ route('admin.company.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.company.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2 row-cols-2">
                            <div class="">
                                <label for="name" class="form-label">
                                    Company Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="">
                                <label for="email" class="form-label">Company Email address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="password" class="form-label">Company Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Company Re type Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="profile_image_url" class="form-label">
                                Company Profile Image
                            </label>
                            <input name="profile_image_url" type="file" class="form-control" id="profile_image_url" />
                            @error('profile_image_url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="website" class="form-label">Company Website</label>
                                <input type="text" name="website" class="form-control" value="{{ old('website') }}">
                                @error('website')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="linkedin_profile" class="form-label">Add Linkedin Profile</label>
                                <input type="text" name="linkedin_profile" class="form-control"
                                    value="{{ old('linkedin_profile') }}">
                                @error('linkedin_profile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="address_line_1" class="form-label">Address Line 1</label>
                                <input type="text" name="address_line_1" class="form-control"
                                    value="{{ old('address_line_1') }}">
                                @error('address_line_1')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address_line_2" class="form-label">Address Line 2</label>
                                <input type="text" name="address_line_2" class="form-control"
                                    value="{{ old('address_line_2') }}">
                                @error('address_line_2')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.company.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection
