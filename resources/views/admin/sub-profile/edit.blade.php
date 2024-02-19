@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Edit Sub Profile</span>
                    <a href="{{ route('admin.sub-profile.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sub-profile.update', $subProfile['id']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Sub Profile
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $subProfile['name']) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Select Profile Category
                                <span class="text-danger">*</span>
                            </label>
                            <select class="profile-category-selector form-select" name="profile_category_id"
                                id="profile_category_id" data-placeholder="Select Profile Category">
                                <option></option>
                                @foreach ($profileCategories as $category)
                                    <option value="{{ $category['id'] }}" @if ($category['id'] == $subProfile['profile_category_id']) selected @endif>
                                        {{ Str::ucfirst(Str::lower($category['name'])) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('profile_category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.sub-profile.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.profile-category-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

        });
    </script>
@endsection
