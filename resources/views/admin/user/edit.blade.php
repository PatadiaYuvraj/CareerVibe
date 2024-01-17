@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Edit User</span>
                    <a href="{{ route('admin.user.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <div class="row row-cols-2">
                        <div class="mb-3 col">
                            <label for="profile_image_url" class="form-label">Profile Image</label>
                            <form action="{{ route('admin.user.updateProfileImage', $user['id']) }}" method="POST"
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
                        <div class="mb-3 col">
                            <label for="resume_pdf_url" class="form-label">Upload your resume here</label>
                            <form action="{{ route('admin.user.updateResumePdf', $user['id']) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input name="resume_pdf_url" type="file" class="form-control" id="resume_pdf_url" />
                                    <button type="submit" class="btn btn-primary">
                                        Upload
                                    </button>
                                </div>
                                @error('resume_pdf_url')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('admin.user.update', $user['id']) }}" method="POST">
                        @csrf
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user['name']) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control"
                                    value="{{ old('email', $user['email']) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- contact city headline city --}}

                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control"
                                    value="{{ old('contact', $user['contact']) }}">
                                @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $user['city']) }}">
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="headline" class="form-label">Headline</label>
                                <input type="text" name="headline" class="form-control"
                                    value="{{ old('headline', $user['headline']) }}">
                                @error('headline')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- gender --}}
                            <div class="mb-3">
                                <label for="gender" class="form-label">
                                    Gender
                                </label>
                                <div class="row row-cols-3">
                                    @foreach (['MALE', 'FEMALE', 'OTHER'] as $gender)
                                        <div class="col">
                                            <label for="{{ $gender }}" class="input-group mb-3">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" id="{{ $gender }}"
                                                        type="radio" value="{{ $gender }}" name="gender"
                                                        @if ($user['gender'] == $gender) checked @endif>
                                                </div>
                                                <div class="form-control">
                                                    {{ Str::ucfirst(Str::lower($gender)) }}
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="interest" class="form-label">
                                    Interest
                                </label>
                                <textarea class="form-control" id="interest" name="interest" rows="3">{{ old('interest', $user['interest']) }}</textarea>
                                @error('interest')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="hobby" class="form-label">
                                    Hobby
                                </label>
                                <textarea class="form-control" id="hobby" name="hobby" rows="3">{{ old('hobby', $user['hobby']) }}</textarea>
                                @error('hobby')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="education" class="form-label">
                                    Education
                                </label>
                                <textarea class="form-control" id="education" name="education" rows="3">{{ old('education', $user['education']) }}</textarea>
                                @error('education')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="experience" class="form-label">
                                    Experience
                                </label>
                                <textarea class="form-control" id="experience" name="experience" rows="3">{{ old('description', $user['experience']) }}</textarea>
                                @error('experience')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="about" class="form-label">
                                About
                            </label>
                            <textarea class="form-control" id="about" name="about" rows="3">{{ old('about', $user['about']) }}</textarea>
                            @error('about')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>



                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
