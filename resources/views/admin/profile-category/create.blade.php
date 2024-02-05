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
                    {{-- <form action="{{ route('admin.profile-category.store') }}" method="POST" class="repeater">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                Profile Category
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.profile-category.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form> --}}
                    {{-- <form action="{{ route('admin.profile-category.store') }}" method="POST" class="repeater"> --}}
                    <form method="POST" class="repeater">
                        @csrf
                        <div class="mb-3" data-repeater-list="profile_category">
                            <div data-repeater-item>
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        Profile Category
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" class="name form-control"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="text-danger 
                                    nameError d-none">Name
                                        field is
                                        required and should not be duplicate</span>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-repeater-delete>Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-repeater-create>Add</button>
                            <button type="button" id="submitBtn" class="btn btn-primary">Submit</button>
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
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {
                    // Set index for each element
                    setIndexes();

                }
            });


            /// Submit form
            $('#submitBtn').on('click', function() {
                // validate then ajax submit
                // .name is multiple input field name
                var name = $('.name')
                    .map(function() {
                        return $(this).val();
                    }).get();

                // validate name field, name should not be empty, and name should not be duplicate
                var nameError = false;
                var nameArr = [];
                $.each(name, function(i, v) {
                    if (v == '') {
                        nameError = true;
                        $('.nameError').eq(i).removeClass('d-none');
                    } else {
                        $('.nameError').eq(i).addClass('d-none');
                    }
                    nameArr.push(v);
                });

                // check duplicate name
                var unique = nameArr.filter(function(itm, i, nameArr) {
                    return i == nameArr.indexOf(itm);
                });

                if (unique.length != nameArr.length) {
                    nameError = true;
                    $.each(nameArr, function(i, v) {
                        var count = 0;
                        $.each(nameArr, function(index, value) {
                            if (v == value) {
                                count++;
                            }
                            if (count > 1) {
                                $('.nameError').eq(i).removeClass('d-none');
                            }
                        });
                    });
                }



                console.log("object")
                // ajax
                $.ajax({
                    url: "{{ route('admin.profile-category.store') }}",
                    type: "POST",
                    data: $('.repeater').serialize(),
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>

@endsection
