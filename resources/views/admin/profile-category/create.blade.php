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
                    <form id="profile-category-form" method="POST" action="{{ route('admin.profile-category.store') }}">
                        @csrf
                        <div class="form-group mb-3" id="profile-categories">
                            <div class="row">
                                <label for="name">Name 1</label>
                                <div class="input-group mb-2">
                                    <input type="text" name="name[]" id="name" class="form-control col">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="button" id="add-category" class="btn btn-primary">Add</button>
                            <button type="button" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            @if ($errors->any())

                <div class="alert alert-danger">
                    <ul>

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    </main>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        const maxCategories = 5;
        $(document).ready(function() {
            $('#add-category').click(function() {
                let categoryCount = $('#profile-categories').find('.row').length;
                if (categoryCount < maxCategories) {
                    let category = `
                    <div class="row">
                        <label for="name">Name ${categoryCount + 1}</label>
                        <div class="input-group mb-2">
                            <input type="text" name="name[]" id="name" class="form-control col">
                            <button type="button" class="btn btn-danger col-2 delete-category">Delete</button>
                        </div>
                    </div>
                    `;
                    $('#profile-categories').append(category);
                } else {
                    // text : Maximum categories reached
                    $("#add-category").attr("disabled", "disabled").text("Maximum categories reached");
                }
            });

            $(document).on('click', '.delete-category', function() {
                $(this).parent().parent().remove();
            });


            $('#profile-category-form').submit(function() {
                let categoryCount = $('#profile-categories').find('.row').length;
                if (categoryCount < 1) {
                    alert('Please add at least one category');
                    return false;
                }
            });

        });
    </script>
@endsection
