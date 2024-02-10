@extends('user.layout.app')
@section('pageTitle', 'Edit Profile Details | ' . env('APP_NAME'))
@section('content')

    <main id="main" class="main">
        <section class="section profile">
            <div class="row">
                <div class="col-xl-">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <a href="{{ route('user.dashboard') }}" class="nav-link">
                                        Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('user.editProfile') }}">
                                        Edit Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.doChangePassword') }}">
                                        Change Password
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.editProfileImage') }}">
                                        Change Profile Image
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.editResumePdf') }}">
                                        Change Resume PDF
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="profile-overview">
                                    <h5 class="card-title">
                                        Profile Details
                                    </h5>
                                    <form action="{{ route('user.updateProfile') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col col-lg-3 col-md-4 label">
                                                Full Name
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    value="{{ old('name') ?? auth()->guard('user')->user()->name }}" />
                                                @error('name')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Email
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <span
                                                    class="form-control is-valid">{{ auth()->guard('user')->user()->email }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Contact
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="contact" type="text" class="form-control" id="contact"
                                                    value="{{ old('contact') ?? auth()->guard('user')->user()->contact }}" />
                                                @error('contact')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Gender
                                            </div>
                                            <div class="col col-lg-9 col-md-8 row row-cols-3">
                                                @foreach (Config::get('constants.gender') as $key => $value)
                                                    <div class="col">
                                                        <label for="{{ $value }}" class="input-group mb-3">
                                                            <div class="input-group-text">
                                                                <input class="form-check-input mt-0"
                                                                    id="{{ $value }}" type="radio"
                                                                    value="{{ $key }}" name="gender"
                                                                    @if (auth()->guard('user')->user()->gender == $key) checked @endif>
                                                            </div>
                                                            <div class="form-control">
                                                                {{ $value }}
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                City
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <input name="city" type="text" class="form-control" id="city"
                                                    value="{{ old('city') ?? auth()->guard('user')->user()->city }}" />
                                                @error('city')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Headline
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <textarea name="headline" type="text" class="form-control" id="headline">{{ old('headline') ?? auth()->guard('user')->user()->headline }}</textarea>

                                                @error('headline')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Education
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <textarea name="education" type="text" class="form-control" id="education">{{ old('education') ?? auth()->guard('user')->user()->education }}</textarea>

                                                @error('education')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Interest
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <textarea name="interest" type="text" class="form-control" id="interest">{{ old('interest') ?? auth()->guard('user')->user()->interest }}</textarea>

                                                @error('interest')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Hobby
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <textarea name="hobby" type="text" class="form-control" id="hobby">{{ old('hobby') ?? auth()->guard('user')->user()->hobby }}</textarea>
                                                @error('hobby')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                About
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <textarea name="about" type="text" class="form-control" id="about">{{ old('about') ?? auth()->guard('user')->user()->about }}</textarea>

                                                @error('about')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">
                                                Experience
                                            </div>
                                            <div class="col col-lg-9 col-md-8">
                                                <textarea name="experience" type="text" class="form-control" id="experience">{{ old('experience') ?? auth()->guard('user')->user()->experience }}</textarea>

                                                @error('experience')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-primary">
                                                Update
                                            </button>
                                            <a href="{{ route('user.dashboard') }}" type="submit"
                                                class="btn btn-danger">
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
