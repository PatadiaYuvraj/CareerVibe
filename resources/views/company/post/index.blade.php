@extends('company.layout.app')
@section('pageTitle', 'Your Posts | ' . env('APP_NAME'))
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
                        Posts
                        <a href="{{ route('company.post.create') }}" class="float-end btn btn-sm btn-primary">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('company.post.show', $post['id']) }}">
                                            {{ $post['title'] }}
                                        </a>
                                    </td>
                                    <td>{{ $post['content'] }}</td>
                                    <td>{{ $post['created_at']->diffForHumans() }}</td>
                                    <td>
                                        @if ($post->likes->where('authorable_type', 'App\Models\Company')->where('authorable_id', $currentAuthId)->count() > 0)
                                            <a href="{{ route('company.post.unlike', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-hand-thumbs-up-fill"></i>
                                                {{-- Unlike --}}
                                            </a>
                                        @else
                                            <a href="{{ route('company.post.like', $post['id']) }}" class="btn btn-sm">
                                                <i class="bi-hand-thumbs-up"></i>
                                                {{-- Like --}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>

                                        <div class="d-flex btn-group">
                                            <a href="{{ route('company.post.edit', $post['id']) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <a href="{{ route('company.post.delete', $post['id']) }}"
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
