@extends('user.layout.app')
@section('pageTitle', 'Edit Post | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <span class="h3 text-black">
                        Edit Comment of {{ $post['title'] }}
                    </span>
                    <a href="{{ route('user.post.commentIndex', $post['id']) }}"
                        class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    {{-- Route::post('/comment/{id}/update/{comment_id}',  [UserUserController::class, "commentPostUpdate"])->name('user.post.commentUpdate');  // comment update page --}}
                    <form action="{{ route('user.post.commentUpdate', [$post['id'], $comment['id']]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3">{{ $comment['content'] }}</textarea>
                            @error('content')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('user.post.commentIndex') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
