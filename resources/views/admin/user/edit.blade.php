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
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
