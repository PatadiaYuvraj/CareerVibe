@extends('company.layout.app')
@section('pageTitle', 'Comments | ' . env('APP_NAME'))
@section('content')
    @php
        $currentAuthId = auth()
            ->guard(config('constants.COMPANY_GUARD'))
            ->id();
    @endphp
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">
                        Comments of {{ $post['title'] }}
                        {{-- add comment --}}
                        <a href="{{ route('company.post.commentCreate', $post['id']) }}"
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
                                        @if ($comment['authorable_type'] == 'App\Models\Company' && $comment['authorable_id'] == $currentAuthId)
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

                                        @if ($comment['likes']->where('authorable_type', 'App\Models\Company')->where('authorable_id', $currentAuthId)->count() > 0)
                                            <a href="{{ route('company.post.commentUnlike', [$post['id'], $comment['id']]) }}"
                                                class="btn btn-sm link-danger">
                                                <i class="bi-heart-fill">
                                                    {{ $comment['likes']->count() }}
                                                </i>
                                            </a>
                                        @else
                                            <a href="{{ route('company.post.commentLike', [$post['id'], $comment['id']]) }}"
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
                                    <td>
                                        {{-- if this comment is created by current company then company can edit and delete comment  --}}
                                        @if ($comment['authorable_type'] == 'App\Models\Company' && $comment['authorable_id'] == $currentAuthId)
                                            {{-- Route::get('/comment/{id}/edit/{comment_id}',  [UserUserController::class, "commentPostEdit"])->name('company.post.commentEdit'); --}}
                                            <div class="d-flex btn-group">
                                                <a href="{{ route('company.post.commentEdit', [$post['id'], $comment['id']]) }}"
                                                    class="btn btn-sm btn-outline-primary p-1">
                                                    <i class="bi-pencil-square"></i>
                                                </a>
                                                <a href="{{ route('company.post.commentDelete', [$post['id'], $comment['id']]) }}"
                                                    class="btn btn-sm btn-outline-danger p-1">
                                                    <i class="bi-trash"></i>
                                                </a>
                                            </div>
                                        @else
                                            {{-- you cant edit or delete --}}
                                            <span class="badge text-dark bg-transparent">
                                                No Action
                                            </span>
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
