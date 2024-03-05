@extends('admin_user.layout.app')
@section('pageTitle', 'All Posts | ' . env('APP_NAME'))
@section('content')
    @php
        $currentAuthId = auth()->guard(config('constants.USER_GUARD'))->id();
    @endphp
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        All Posts
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Created By</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Likes</th>
                                <th>Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="" data-bs-toggle="tooltip" data-bs-placement="right"
                                        title='
                                    @if ($post->authorable_type == 'App\Models\User') User @endif
                                        @if ($post->authorable_type == 'App\Models\Company') Company @endif
                                    '>
                                        @if ($post->authorable->id == $currentAuthId && $post->authorable->userType == 'USER')
                                            <span class="badge text-dark bg-transparent">
                                                {{-- Posted by  --}}
                                                You
                                            </span>
                                        @else
                                            <span class="badge text-dark bg-transparent">
                                                {{-- Posted by --}}
                                                {{ $post->authorable->name }}
                                            </span>
                                        @endif

                                    <td>
                                        <a href="{{ route('admin_user.post.show', $post['id']) }}" data-bs-toggle="tooltip"
                                            data-bs-placement="right" title="{{ $post['title'] }}">
                                            {{-- Str limit --}}
                                            {{ Str::limit($post['title'], 20) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="{{ $post['content'] }}">
                                            {{-- Str limit --}}
                                            {{ Str::limit($post['content'], 20) }}
                                        </span>
                                    </td>

                                    {{-- @if ($post->authorable_type == 'App\Models\User')
                                            <span class="badge text-dark bg-transparent">User</span>
                                        @endif
                                        @if ($post->authorable_type == 'App\Models\Company')
                                            <span class="badge text-dark bg-transparent">Company</span>
                                        @endif --}}

                                    <td>
                                        @if ($post->likes->where('authorable_type', 'App\Models\User')->where('authorable_id', $currentAuthId)->count() > 0)
                                            <a href="{{ route('admin_user.post.unlike', $post['id']) }}"
                                                class="btn btn-sm link-danger">
                                                <i class="bi-heart-fill"> {{ $post->likes->count() }}</i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin_user.post.like', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-heart  "> {{ $post->likes->count() }}</i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin_user.post.commentIndex', $post['id']) }}"
                                            class="btn btn-sm">
                                            <i class="bi-chat-square-text"> {{ $post->comments->count() }} </i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge text-dark bg-transparent">
                                            {{ $post['created_at']->diffForHumans() }}
                                        </span>
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
