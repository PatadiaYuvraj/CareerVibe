@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Add Profile Category
                    </span>
                    <a href="{{ route('admin.profile-category.index') }}" class="float-end btn btn-sm btn-primary">
                        Back
                    </a>
                </div>
                <div class="card-body">
                    <form class="repeater" method="POST" action="{{ route('admin.profile-category.store') }}">
                        @csrf
                        <div class="form-group mb-3" data-repeater-list="profile_categories">
                            <div data-repeater-item class=" mb-2">
                                <label for="name" class="form-label">Name</label>
                                <div class=" row">
                                    <div class="col">
                                        <input type="text" class="form-control col" name="name" id="name">
                                    </div>
                                    <button type="button" class="btn btn-danger col-2" data-repeater-delete>Delete</button>
                                </div>
                                <span class="text-danger nameError" style="">
                                </span>
                            </div>
                        </div>
                        <div class="btn-group d-flex">
                            <button data-repeater-create type="button" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-success" id="submitForm">Submit</button>
                            <a href="{{ route('admin.profile-category.index') }}" class="btn btn-danger">Cancel</a>
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
            $('.repeater').repeater({
                show: function() {
                    $(this).show();
                },
                hide: function(deleteElement) {
                    $(this).remove();
                },
                isFirstItemUndeletable: true,
            });

            // form submit
            $('#submitForm').on('click', function() {
                // $('.nameError').hide().text('');

                $.ajax({
                    url: "{{ route('admin.profile-category.store') }}",
                    type: "POST",
                    data: $('.repeater').serialize(),
                    success: function(response) {
                        $('.nameError').hide().text('');
                        if (response.success) {
                            toastr.success(response.success);
                        }
                        if (response.warning) {
                            toastr.warning(response.warning);
                        }
                        window.location.href =
                            "{{ route('admin.profile-category.index') }}";
                    },
                    error: function(error) {
                        $('.nameError').hide().text('');
                        const errors = error.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {

                                if (key.includes('profile_categories')) {
                                    const keyArr = key.split('.');
                                    const index = keyArr[1];
                                    const errorType = keyArr[2];
                                    if (errorType == 'name') {
                                        $('.nameError').eq(index).show().text(value);
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
