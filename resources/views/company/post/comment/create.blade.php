@extends('company.layout.app')
@section('pageTitle', 'Create Comment | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Add Comment of {{ $post['title'] }}
                    </span>
                    <a href="{{ route('company.post.commentIndex', $post['id']) }}"
                        class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">

                    <form action="{{ route('company.post.commentStore', $post['id']) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                            @error('content')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('company.post.index') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
    <script></script>
@endsection
