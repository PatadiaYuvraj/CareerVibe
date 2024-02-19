@extends('user.layout.app')
@section('pageTitle', 'Your Posts | ' . env('APP_NAME'))
@section('content')
    @php
        $currentAuthId = auth()->guard(config('constants.USER_GUARD'))->id();
    @endphp
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Posts
                        <a href="{{ route('user.post.create') }}" class="float-end btn btn-sm btn-primary">
                            <i class="bi-plus-lg">
                                Add Post
                            </i>
                        </a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Type</th>
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
                                            <span class="" data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="{{ $post['title'] }}">
                                                {{ Str::limit($post['title'], 20) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="{{ $post['content'] }}">
                                            {{ Str::limit($post['content'], 20) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($post['type'] == 'TEXT')
                                                <button class="btn btn-info btn-sm">
                                                    {{ $post['type'] }}
                                                </button>
                                            @else
                                                @if ($post['type'] == 'IMAGE')
                                                    @if ($post['file'])
                                                        <a href="{{ url($post['file']) }}" class="btn btn-sm btn-primary"
                                                            target="_blank">
                                                            {{ $post['type'] }}
                                                        </a>
                                                    @else
                                                        <button class="btn btn-info btn-sm">
                                                            {{ $post['type'] }}
                                                        </button>
                                                    @endif
                                                @else
                                                    @if ($post['file'])
                                                        <a href="{{ url($post['file']) }}" class="btn btn-sm btn-primary"
                                                            target="_blank">
                                                            {{ $post['type'] }}
                                                        </a>
                                                    @else
                                                        <button class="btn btn-info btn-sm">
                                                            {{ $post['type'] }}
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $post['created_at']->diffForHumans() }}</td>
                                    <td>
                                        @if ($post->likes->where('authorable_type', 'App\Models\User')->where('authorable_id', auth()->id())->count() > 0)
                                            <a href="{{ route('user.post.unlike', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-heart-fill"> {{ $post->likes->count() }}</i>
                                            </a>
                                        @else
                                            <a href="{{ route('user.post.like', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-heart  "> {{ $post->likes->count() }}</i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.post.commentIndex', $post['id']) }}" class="btn btn-sm">
                                            <i class="bi-chat-square"></i>
                                            {{ $post->comments->count() }}
                                        </a>
                                    </td>
                                    <td>

                                        <div class="d-flex btn-group">
                                            <a href="{{ route('user.post.edit', $post['id']) }}"
                                                class="btn btn-sm btn-outline-primary p-1">
                                                <i class="bi-pencil-square"></i>
                                            </a>
                                            <a href="{{ route('user.post.delete', $post['id']) }}"
                                                class="btn btn-sm btn-outline-danger p-1">
                                                <i class="bi-trash"></i>
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
