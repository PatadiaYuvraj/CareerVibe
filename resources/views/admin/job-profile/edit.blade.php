@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Edit Profile</span>
                    <a href="{{ route('admin.job-profile.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.job-profile.update', $profile['id']) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="profile" class="form-label">
                                Job Profile
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="profile" class="form-control"
                                value="{{ old('profile', $profile['profile']) }}">
                            @error('profile')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.job-profile.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
