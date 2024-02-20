@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Sub Profile</span>
                    <a href="{{ route('admin.sub-profile.index') }}" class="float-end btn btn-sm btn-primary">
                        Back
                    </a>
                </div>
                <div class="card-body">
                    <form class="repeater" action="{{ route('admin.sub-profile.store') }}" method="POST">
                        @csrf
                        <div class="mb-3" data-repeater-list="sub_profiles">
                            <label for="name" class="form-label">Sub Profile
                                <span class="text-danger">*</span>
                            </label>
                            <div data-repeater-item class="mb-2">
                                <div class="row">
                                    <input type="text" name="name" class="form-control col"
                                        value="{{ old('name') }}">
                                    <select class="col profile-category-selector form-select" name="profile_category_id"
                                        id="profile_category_id" data-placeholder="Select Profile Category"
                                        style="width: 50%;">
                                        <option></option>
                                        @foreach ($profileCategories as $category)
                                            <option value="{{ $category['id'] }}">
                                                {{ Str::ucfirst(Str::lower($category['name'])) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-danger col-2" data-repeater-delete>Delete</button>
                                </div>
                                <div class="row">
                                    <div class="col-4 text-danger nameError">
                                    </div>
                                    <div class="col text-danger profileCategoryError">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group d-flex">
                            <button id="addButton" data-repeater-create type="button" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-success" id="submitForm">Submit</button>
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

            // $('.profile-category-selector').select2({
            //     theme: "bootstrap-5",
            //     width: '50%',
            //     placeholder: $(this).data('placeholder'),
            //     closeOnSelect: true,
            // });

            // Initialize repeater
            $('.repeater').repeater({
                show: function() {
                    $(this).show();
                },

                hide: function(deleteElement) {
                    $(this).remove();
                },

                isFirstItemUndeletable: true,
            });

            $('#submitForm').on('click', function() {
                data = $('.repeater').serialize();
                $.ajax({
                    url: "{{ route('admin.sub-profile.store') }}",
                    type: "POST",
                    data: data,
                    success: function(response) {
                        console.log(response);
                        $('.nameError').hide().text('');
                        $('.profileCategoryError').hide().text('');
                        if (response.success) {
                            toastr.success(response.success);
                        }
                        if (response.warning) {
                            toastr.warning(response.warning);
                        }
                        window.location.href =
                            "{{ route('admin.sub-profile.index') }}";
                    },
                    error: function(error) {
                        $('.nameError').hide().text('');
                        $('.profileCategoryError').hide().text('');
                        const errors = error.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                if (key.includes('sub_profiles')) {
                                    const keyArr = key.split('.');
                                    const index = keyArr[1];
                                    const errorType = keyArr[2];
                                    if (errorType == 'name') {
                                        $('.nameError').eq(index).show().text(value);
                                    }
                                    if (errorType == 'profile_category_id') {
                                        $('.profileCategoryError').eq(index).show()
                                            .text(value);
                                    }
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
