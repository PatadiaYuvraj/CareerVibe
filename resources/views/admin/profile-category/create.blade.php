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
                    <a wire:navigate href="{{ route('admin.profile-category.index') }}"
                        class="float-end btn btn-sm btn-primary">
                        Back
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" class="repeater" action="{{ route('admin.profile-category.store') }}">
                        @csrf
                        <div class="form-group mb-3" data-repeater-list="profile_categories">
                            <div data-repeater-item class="row">
                                <div class="col-md-6 col">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>

                                <div class="col-md-6 col" data-repeater-delete>
                                    <button type="button" class="btn btn-danger mt-2">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button data-repeater-create type="button" class="btn btn-primary">Add</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
    <script>
        // form repeater
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
                isFirstItemUndeletable: true,
            });
        });
    </script>
@endsection
