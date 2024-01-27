@extends('user.layout.app')
@section('pageTitle', 'All Posts | ' . env('APP_NAME'))
@section('content')
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
                                <th>User Type</th>
                                {{-- like by you --}}
                                <th>Like by you</th>
                                <th>No of likes</th>
                                <th>No of comments</th>
                                <th>See Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="">
                                        @if ($post->authorable_id == auth()->id())
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
                                        <a href="{{ route('user.post.show', $post['id']) }}">
                                            {{ $post['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ $post['content'] }}</td>
                                    <td>
                                        @if ($post->authorable_type == 'App\Models\User')
                                            <span class="badge text-dark bg-transparent">User</span>
                                        @endif
                                        @if ($post->authorable_type == 'App\Models\Company')
                                            <span class="badge text-dark bg-transparent">Company</span>
                                        @endif
                                    </td>

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
                                        {{ $post->likes->count() }}
                                    </td>
                                    <td>
                                        {{ $post->comments->count() }}
                                    </td>
                                    <td>
                                        <a href="{{ route('user.post.commentIndex', $post['id']) }}" class="btn btn-sm">
                                            <i class="bi-chat-left-text-fill"></i>
                                            {{-- See Comments --}}
                                        </a>
                                    </td>
                                    <td>{{ $post['created_at']->diffForHumans() }}</td>
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
