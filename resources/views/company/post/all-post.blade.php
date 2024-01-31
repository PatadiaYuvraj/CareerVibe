@extends('company.layout.app')
@section('pageTitle', 'All Posts | ' . env('APP_NAME'))
@section('content')
    @php
        $currentAuthId = auth()
            ->guard(config('constants.COMPANY_GUARD'))
            ->id();
        // $userType = 'App\Models\Company';
        $companyType = 'App\Models\Company';
        $userType = 'App\Models\User';
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
                                        @if ($post->authorable_id == $currentAuthId && $post->authorable_type == $companyType)
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
                                        <a href="{{ route('company.post.show', $post['id']) }}">
                                            {{ $post['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ $post['content'] }}</td>
                                    <td>
                                        @if ($post->authorable_type == $userType)
                                            <span class="badge text-dark bg-transparent">User</span>
                                        @endif
                                        @if ($post->authorable_type == $companyType)
                                            <span class="badge text-dark bg-transparent">Company</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($post->likes->where('authorable_type', $companyType)->where('authorable_id', $currentAuthId)->count() > 0)
                                            <a href="{{ route('company.post.unlike', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-hand-thumbs-up-fill"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('company.post.like', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-hand-thumbs-up"></i>
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
                                        <a href="{{ route('company.post.commentIndex', $post['id']) }}" class="btn btn-sm">
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
