@extends('user.profile.layout.app')
@section('title', 'Your Posts | ' . env('APP_NAME'))

@section('profile-breadcrumb-content')
    <!-- Start Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">
                            Your Posts
                        </h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Id beatae, doloremque<br />
                            doloribus, similique ullam quos tempore nemo,
                            voluptatibus placeat dignissimos ea.
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li>Your Posts</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
@endsection

@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="job-items mb-3">
            @forelse ($posts as $key =>$post)
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="h5 text-dark">{{ $post->title }}</span>
                        ({{ date('d-m-Y', strtotime($post->created_at)) }})
                        <div class="float-right">
                            <a href="{{ route('user.post.edit', $post->id) }}" class="btn btn-outline-primary btn-sm">
                                Edit
                            </a>
                            <a href="{{ route('user.post.delete', $post->id) }}" class="btn btn-outline-danger btn-sm">
                                Delete
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <span class="h6">
                            {{ $post->content }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="manage-content mb-4 card py-4 px-4">
                    <div class="row text-center">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h6>
                                No applied jobs found.
                            </h6>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- Pagination -->
        @if (count($posts) > 0 && $posts->count() > 0)
            @include('user.layout.pagination', [
                'paginator' => $posts->toArray()['links'],
            ])
        @endif
        <!-- End Pagination -->
    </div>
@endsection
