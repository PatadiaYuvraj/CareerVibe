@extends('user.layout.app')
@section('pageTitle', 'Create Post | ' . env('APP_NAME'))
@section('content')

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Post</span>
                    <a href="{{ route('user.post.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">

                    <form action="{{ route('user.post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2 row-cols-2">
                            <div class="col">
                                <div class="btn-group">
                                    @foreach (config()->get('constants.post.type') as $key => $type)
                                        <input type="radio" class="btn-check" name="type" value="{{ $key }}"
                                            id="{{ $key }}" {{ $key == 'TEXT' ? 'checked' : '' }}
                                            {{ old('type') == $key ? 'checked' : '' }} autocomplete="off" required>
                                        <label class="btn btn-outline-primary" for="{{ $key }}">
                                            {{ $key }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-none col" id="file">
                                <input type="file" name="file" class="form-control" id="file-input"
                                    placeholder="Enter file" accept="image/*, video/*" value="{{ old('file') }}" />

                                @error('file')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                                id="title" placeholder="Enter title">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea name="content" class="form-control" id="content" rows="5" placeholder="Enter content">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('user.post.index') }}" class="btn btn-danger">Cancel</a>
                    </form>

                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {

            $('#file').hide();
            $('input[type=radio]').change(function() {
                if (this.value == 'IMAGE' || this.value == 'VIDEO') {
                    $('#file').show();
                    $('#file').removeClass('d-none');
                } else {
                    $('#file').hide();
                    $('#file').addClass('d-none');
                }
            });

            if ("{{ old('type') }}" == 'IMAGE' || "{{ old('type') }}" == 'VIDEO') {
                $('#file').show();
                $('#file').removeClass('d-none');
            }
        });
    </script>

@endsection
