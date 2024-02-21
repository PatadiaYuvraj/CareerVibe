@extends('admin_user.layout.app')
@section('pageTitle', 'Edit Post | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <span class="h3 text-black">
                        Edit Job
                    </span>
                    <a href="{{ route('admin_user.post.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin_user.post.update', $post['id']) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-2 row-cols-2">
                            <div class="col">
                                <div class="btn-group">
                                    @foreach (config()->get('constants.post.type') as $key => $type)
                                        <input type="radio" class="btn-check" id="{{ $key }}"
                                            {{ $post['type'] == $key ? 'checked' : 'disabled' }} autocomplete="off"
                                            required>
                                        <label class="btn btn-outline-primary" for="{{ $key }}">
                                            {{ $key }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($post['type'] == 'IMAGE' || $post['type'] == 'VIDEO')
                                <div class="col" id="file">
                                    <input type="file" name="file" class="form-control" id="file-input"
                                        placeholder="Enter file" accept="image/*, video/*" value="{{ old('file') }}" />

                                    @error('file')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" value="{{ old('title', $post['title']) }}"
                                class="form-control" id="title" placeholder="Enter title">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3">{{ old('content', $post['content']) }}</textarea>
                            @error('content')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin_user.post.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
