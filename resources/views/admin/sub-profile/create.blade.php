@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Sub Profile</span>
                    <a wire:navigate href="{{ route('admin.sub-profile.index') }}" class="float-end btn btn-sm btn-primary">
                        Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sub-profile.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Sub Profile
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Select Profile Category
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-3">
                                @forelse ($profileCategories as $profileCategory)
                                    <div class="col">
                                        <label for="{{ $profileCategory['name'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $profileCategory['name'] }}"
                                                    type="radio" value="{{ $profileCategory['id'] }}"
                                                    name="profile_category_id">
                                            </div>
                                            <div class="form-control">
                                                {{ Str::ucfirst(Str::lower($profileCategory['name'])) }}
                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="card-body">
                                        <span class="text-danger">No Profile Category Found</span>

                                        <a wire:navigate href="{{ route('admin.profile-category.create') }}" class="">
                                            Add Profile Category
                                        </a>

                                    </div>
                                @endforelse
                            </div>
                            @error('profile_category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a wire:navigate href="{{ route('admin.sub-profile.index') }}"
                                class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
