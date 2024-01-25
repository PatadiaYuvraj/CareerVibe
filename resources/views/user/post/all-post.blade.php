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
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>
                                        {{ $post['postable']['name'] }}
                                    <td>
                                        <a href="{{ route('user.post.show', $post['id']) }}">
                                            {{ $post['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ $post['content'] }}</td>
                                    <td>
                                        @if ($post->postable_type == 'App\Models\User')
                                            <span class="badge bg-primary">User</span>
                                        @endif
                                        @if ($post->postable_type == 'App\Models\Company')
                                            <span class="badge bg-success">Company</span>
                                        @endif
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
