@extends('user.layout.app')
@section('pageTitle', 'Comments | ' . env('APP_NAME'))
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
                        Comments of {{ $post['title'] }}
                        {{-- add comment --}}
                        <a href="{{ route('user.post.commentCreate', $post['id']) }}"
                            class="float-end btn btn-sm btn-primary">Add Comment</a>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Content</th>
                                <th>Commented By</th>
                                <th>Type</th>
                                <th>Likes</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($post['comments'] as $comment)
                                <tr>
                                    <td>{{ $comment['content'] }}</td>
                                    <td>
                                        @if ($comment['authorable_type'] == 'App\Models\User' && $comment['authorable_id'] == $currentAuthId)
                                            <span class="badge text-dark bg-transparent">
                                                {{-- Posted by  --}}
                                                You
                                            </span>
                                        @else
                                            <span class="badge text-dark bg-transparent">
                                                {{-- Posted by --}}
                                                {{ $comment['authorable']['name'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($comment['authorable_type'] == 'App\Models\User')
                                            <span class="badge text-dark bg-transparent">User</span>
                                        @endif
                                        @if ($comment['authorable_type'] == 'App\Models\Company')
                                            <span class="badge text-dark bg-transparent">Company</span>
                                        @endif
                                    </td>

                                    <td>

                                        @if ($comment['likes']->where('authorable_type', 'App\Models\User')->where('authorable_id', $currentAuthId)->count() > 0)
                                            <a href="{{ route('user.post.commentUnlike', [$post['id'], $comment['id']]) }}"
                                                class="btn btn-sm link-danger">
                                                <i class="bi-heart-fill"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('user.post.commentLike', [$post['id'], $comment['id']]) }}"
                                                class="btn btn-sm">
                                                <i class="bi-heart"></i>
                                            </a>
                                        @endif
                                        {{ $comment['likes']->count() }}
                                    </td>

                                    <td>
                                        @if ($comment['created_at'])
                                            {{ Illuminate\Support\Carbon::parse($comment['created_at'])->diffForHumans() }}
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{-- if this comment is created by current user then user can edit and delete comment  --}}
                                        @if ($comment['authorable_type'] == 'App\Models\User' && $comment['authorable_id'] == $currentAuthId)
                                            {{-- Route::get('/comment/{id}/edit/{comment_id}',  [UserUserController::class, "commentPostEdit"])->name('user.post.commentEdit'); --}}
                                            <a href="{{ route('user.post.commentEdit', [$post['id'], $comment['id']]) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <a href="{{ route('user.post.commentDelete', [$post['id'], $comment['id']]) }}"
                                                class="btn btn-sm btn-danger">
                                                Delete
                                            </a>
                                        @else
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
