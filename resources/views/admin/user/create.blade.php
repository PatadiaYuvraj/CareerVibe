@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')

    {{-- 
        'name',
        'email',
        'password',
        "name",
        "email",
        "password",
        "userType",
        "profile_image_url",
        "resume_pdf_url",
        "contact",
        "gender",
        "is_active",
        "headline",
        "education",
        "interest",
        "hobby",
        "city",
        "about",
        "experience",
        --}}

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card ">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add User</span>
                    <a href="{{ route('admin.user.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control" id="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">

                            <div class="mb-3">
                                <label for="password" class="form-label">Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password" class="form-control" id="password"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="profile_image_url" class="form-label">Profile image</label>
                                @csrf
                                <div class="input-group">
                                    <input name="profile_image_url" type="file" class="form-control"
                                        id="profile_image_url" />
                                </div>
                                @error('profile_image_url')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="mb-3">
                                <label for="resume_pdf_url" class="form-label">Upload your resume here</label>
                                <div class="input-group">
                                    <input name="resume_pdf_url" type="file" class="form-control" id="resume_pdf_url" />
                                </div>
                                @error('resume_pdf_url')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control" id="contact"
                                    value="{{ old('contact') }}">
                                @error('contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" class="form-control" id="city"
                                    value="{{ old('city') }}">
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="mb-3">
                                <label for="headline" class="form-label">Headline</label>
                                <input type="text" name="headline" class="form-control" id="headline"
                                    value="{{ old('headline') }}">
                                @error('headline')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">
                                    Gender
                                </label>
                                <select class="gender-selector form-select" name="gender  " id="gender"
                                    data-placeholder="Select Gender">
                                    <option></option>
                                    @foreach (Config::get('constants.gender') as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="interest" class="form-label">
                                Interest
                            </label>
                            <textarea class="form-control" id="interest" name="interest" rows="5">{{ old('interest') }}</textarea>
                            @error('interest')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="hobby" class="form-label">
                                Hobby
                            </label>
                            <textarea class="form-control" id="hobby" name="hobby" rows="5">{{ old('hobby') }}</textarea>
                            @error('hobby')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label">
                                Education
                            </label>
                            <textarea class="form-control" id="education" name="education" rows="5">{{ old('education') }}</textarea>
                            @error('education')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="form-label">
                                Experience
                            </label>
                            <textarea class="form-control" id="experience" name="experience" rows="5">{{ old('description') }}</textarea>
                            @error('experience')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="about" class="form-label">
                                About
                            </label>
                            <textarea class="form-control" id="about" name="about" rows="5">{{ old('about') }}</textarea>
                            @error('about')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.gender-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });


        });
    </script>
@endsection
