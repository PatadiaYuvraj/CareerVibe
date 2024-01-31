@extends('user.layout.app')
@section('pageTitle', 'Your Posts | ' . env('APP_NAME'))
@section('content')
    @php
        $currentAuthId = auth()
            ->guard(config('constants.USER_GUARD'))
            ->id();
    @endphp
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Posts
                        <a href="{{ route('user.post.create') }}" class="float-end btn btn-sm btn-primary">
                            Add Post
                        </a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Date</th>
                                <th>Like</th>
                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('user.post.show', $post['id']) }}">
                                            {{ $post['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ $post['content'] }}</td>
                                    <td>{{ $post['created_at']->diffForHumans() }}</td>
                                    <td>
                                        @if ($post->likes->where('authorable_type', 'App\Models\User')->where('authorable_id', auth()->id())->count() > 0)
                                            <a href="{{ route('user.post.unlike', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-hand-thumbs-up-fill"></i>
                                                {{-- Unlike --}}
                                            </a>
                                        @else
                                            <a href="{{ route('user.post.like', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-hand-thumbs-up"></i>
                                                {{-- Like --}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.post.commentIndex', $post['id']) }}" class="btn btn-sm">
                                            <i class="bi-chat-left-text-fill"></i>
                                            {{-- See Comments --}}
                                        </a>
                                    </td>
                                    <td>

                                        <div class="d-flex btn-group">
                                            <a href="{{ route('user.post.edit', $post['id']) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <a href="{{ route('user.post.delete', $post['id']) }}"
                                                class="btn btn-sm btn-danger">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="justify-content-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
