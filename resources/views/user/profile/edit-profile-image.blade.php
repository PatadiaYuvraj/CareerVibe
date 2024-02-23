@extends('user.profile.layout.app')
@section('title', 'Edit Profile')
@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="password-content">
            <h3>
                Edit Profile
            </h3>
            <p>
                You can edit your profile here to update your profile details.
            </p>
            {{-- <iframe
                src="https://res.cloudinary.com/career-vibe/image/upload/v1708585499/career-vibe/users/resumes/urimpjpuuaseooo1lzzy.pdf"
                width="100%" height="300px" frameborder="0"></iframe> --}}

            {{-- <embed
                src="https://res.cloudinary.com/career-vibe/image/upload/v1708585499/career-vibe/users/resumes/urimpjpuuaseooo1lzzy.pdf"
                type="application/pdf" frameBorder="0" scrolling="auto" height="500px" width="100%"></embed> --}}

            {{-- <form action="{{ route('user.profile.updateProfile') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>
                                Email
                                <span
                                    class="
                                    text-muted
                                    font-weight-light
                                    font-italic
                                    mt-1
                                ">
                                    (You can't change your email address.)
                                </span>
                            </label>
                            <input class="form-control is-valid border-success border-2" value="{{ Auth::user()->email }}" />
                        </div>
                        <div class="row-cols-2 row">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input class="form-control @error('name') is-invalid border-danger border-2 @enderror"
                                    type="text" name="name" value="{{ old('name') ?? Auth::user()->name }}" />
                                @error('name')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input class="form-control @error('city') is-invalid border-danger border-2 @enderror"
                                    type="tel" name="city" value="{{ old('city') ?? Auth::user()->city }}" />

                                @error('city')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="form-group">
                                <label>Contact</label>
                                <input class="form-control @error('contact') is-invalid border-danger border-2 @enderror"
                                    type="tel" name="contact" value="{{ old('contact') ?? Auth::user()->contact }}"
                                    placeholder="+91 1234567890" />

                                @error('contact')
                                    <div class="text-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>
                                    Gender
                                </label>
                                <select class="form-control" name="gender" data-placeholder="Select Gender">
                                    <option selected disabled value="">
                                        Select gender
                                    </option>
                                    @foreach (Config::get('constants.gender') as $key => $value)
                                        <option value="{{ $key }}"
                                            @if (auth()->guard('user')->user()->gender == $key) selected @endif>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Headline</label>
                            <textarea name="headline" type="text" class="form-control" id="headline">{{ old('headline') ?? auth()->guard('user')->user()->headline }}</textarea>
                            @error('headline')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Education</label>
                            <textarea name="education" type="text" class="form-control" id="education">{{ old('education') ?? auth()->guard('user')->user()->education }}</textarea>
                            @error('education')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Interest</label>
                            <textarea name="interest" type="text" class="form-control" id="interest">{{ old('interest') ?? auth()->guard('user')->user()->interest }}</textarea>
                            @error('interest')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Hobby</label>
                            <textarea name="hobby" type="text" class="form-control" id="hobby">{{ old('hobby') ?? auth()->guard('user')->user()->hobby }}</textarea>
                            @error('hobby')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>About</label>
                            <textarea name="about" type="text" class="form-control" id="about">{{ old('about') ?? auth()->guard('user')->user()->about }}</textarea>
                            @error('about')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="button">
                            <button class="btn">
                                Update Profile
                            </button>
                        </div>
                    </div>
                </div>
            </form> --}}
        </div>
    </div>
@endsection
