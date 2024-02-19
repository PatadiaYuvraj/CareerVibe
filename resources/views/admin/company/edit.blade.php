@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Update Company</span>
                    <a href="{{ route('admin.company.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.company.update', $company['id']) }}" method="POST"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="name" class="form-label">Company Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $company['name']) }}">
                                @error('name')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Company Email address</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $company['email']) }}">
                                @error('email')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="profile_image_url" class="form-label">
                                Company Profile Image
                            </label>
                            <input name="profile_image_url" type="file" class="form-control" id="profile_image_url" />
                            @error('profile_image_url')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="website" class="form-label">Company Website</label>
                                <input type="text" name="website" class="form-control"
                                    value="{{ old('website', $company['website']) }}">
                                @error('website')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">Add Linkedin Profile</label>
                                <input type="text" name="linkedin" class="form-control"
                                    value="{{ old('linkedin', $company['linkedin']) }}">
                                @error('linkedin')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $company['city']) }}">
                                @error('city')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', $company['address']) }}">
                                @error('address')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="5">{{ old('description', $company['description']) }}</textarea>
                            @error('description')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="btn-group mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.company.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
