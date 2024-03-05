@extends('admin_user.layout.app')
@section('pageTitle', 'Comments | ' . env('APP_NAME'))
@section('content')
    @php
        $currentAuthId = auth()->guard(config('constants.USER_GUARD'))->id();
    @endphp
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Comments of {{ $post['title'] }}
                        {{-- add comment --}}
                        <a href="{{ route('admin_user.post.commentCreate', $post['id']) }}"
                            class="float-end btn btn-sm btn-primary">
                            <i class="bi-plus-lg">
                                Add Comment
                            </i>
                        </a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Commented By</th>
                                <th>Content</th>
                                <th>Likes</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($post['comments'] as $comment)
                                <tr>
                                    <td>
                                        @if ($comment['authorable_type'] == 'App\Models\User' && $comment['authorable_id'] == $currentAuthId)
                                            <span class="badge text-dark bg-transparent" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="{{ $comment['authorable']['name'] }}">
                                                {{-- Posted by  --}}
                                                You
                                            </span>
                                        @else
                                            <span class="badge text-dark bg-transparent" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="{{ $comment['authorable']['name'] }}">
                                                {{-- Posted by --}}
                                                {{ $comment['authorable']['name'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="" data-bs-toggle="tooltip" data-bs-placement="right"
                                            title="{{ $comment['content'] }}">
                                            {{ Str::limit($comment['content'], 20) }}
                                        </span>
                                    </td>
                                    <td>

                                        @if ($comment['likes']->where('authorable_type', 'App\Models\User')->where('authorable_id', $currentAuthId)->count() > 0)
                                            <a href="{{ route('admin_user.post.commentUnlike', [$post['id'], $comment['id']]) }}"
                                                class="btn btn-sm link-danger">
                                                <i class="bi-heart-fill">
                                                    {{ $comment['likes']->count() }}
                                                </i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin_user.post.commentLike', [$post['id'], $comment['id']]) }}"
                                                class="btn btn-sm">
                                                <i class="bi-heart">
                                                    {{ $comment['likes']->count() }}
                                                </i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($comment['created_at'])
                                            {{ Illuminate\Support\Carbon::parse($comment['created_at'])->diffForHumans() }}
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if ($comment['authorable_type'] == 'App\Models\User' && $comment['authorable_id'] == $currentAuthId)
                                            <div class="d-flex btn-group">
                                                <a href="{{ route('admin_user.post.commentEdit', [$post['id'], $comment['id']]) }}"
                                                    class="btn btn-sm btn-outline-primary p-1">
                                                    <i class="bi-pencil-square"></i>
                                                </a>
                                                <a href="{{ route('admin_user.post.commentDelete', [$post['id'], $comment['id']]) }}"
                                                    class="btn btn-sm btn-outline-danger p-1">
                                                    <i class="bi-trash"></i>
                                                </a>
                                            </div>
                                        @else
                                            <span class="badge text-dark bg-transparent">
                                                No Action
                                            </span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        @if ($comment['authorable_type'] == 'App\Models\User' && $comment['authorable_id'] == $currentAuthId)
                                            <div class="d-flex btn-group">
                                                <a href="{{ route('admin_user.post.commentEdit', [$post['id'], $comment['id']]) }}"
                                                    class="btn btn-sm btn-outline-primary p-1">
                                                    <i class="bi-pencil-square"></i>
                                                </a>
                                                <a href="{{ route('admin_user.post.commentDelete', [$post['id'], $comment['id']]) }}"
                                                    class="btn btn-sm btn-outline-danger p-1">
                                                    <i class="bi-trash"></i>
                                                </a>
                                            </div>
                                        @else
                                            @if ($post['authorable_type'] == 'App\Models\User' && $post['authorable_id'] == $currentAuthId)
                                                <a href="{{ route('admin_user.post.commentDelete', [$post['id'], $comment['id']]) }}"
                                                    class="btn btn-sm btn-outline-danger p-1">
                                                    <i class="bi-trash"></i>
                                                </a>
                                            @else
                                                <button class="badge bg-transparent text-dark border-0" disabled>
                                                    No Action
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- <div class="justify-content-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </div> --}}
                </div>
            </div>
        </section>
    </main>
@endsection
