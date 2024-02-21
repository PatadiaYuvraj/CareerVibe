@extends('admin_company.layout.app')
@section('pageTitle', 'Show Post | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header ">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin_company.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin_company.post.index') }}">Posts</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="col pt-3">
                        <h1 class="display-5">
                            {{ $post['title'] }}
                        </h1>
                        <p class="lead position-relative">
                            {{ $post['content'] }}
                        </p>
                        <p class="lead">Created At :
                            @if ($post['created_at'])
                                {{ date('d-m-Y', strtotime($post['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn"
                                href="{{ route('admin_company.post.edit', $post['id']) }}">Edit</a>
                        </p>
                    </div>
                    <hr />
                    <div class="row row-cols-2">
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Comments
                                </h5>
                                <h6 class="">
                                    @forelse ($post['comments'] as $comment)
                                        <div class="row">
                                            {{-- <div class="col mb-3">
                                                @if ($comment['authorable']['profile_image_url'])
                                                    <img src="{{ $comment['authorable']['profile_image_url'] }}"
                                                        class="img-fluid rounded-circle" width="50" height="50"
                                                        alt="{{ $comment['authorable']['name'] }}" />
                                                @else
                                                    <img src="{{ asset('admin/img/messages-3.jpg') }}"
                                                        class="img-fluid rounded-circle" width="50" height="50"
                                                        alt="{{ $comment['authorable']['name'] }}" />
                                                @endif
                                            </div>
                                            <div class="col">
                                                {{ $comment['authorable']['name'] }}
                                            </div> --}}
                                            <div class="col">
                                                {{ $comment['content'] }}
                                                By {{ $comment['authorable']['name'] }}

                                            </div>
                                        </div>

                                    @empty
                                        No Comments
                                    @endforelse
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">Likes</h5>
                                <h6 class="">
                                    @forelse ($post['likes'] as $like)
                                        <div class="row">
                                            <div class="col mb-3">
                                                @if ($like['authorable']['profile_image_url'])
                                                    <img src="{{ $like['authorable']['profile_image_url'] }}"
                                                        class="img-fluid rounded-circle" width="50" height="50"
                                                        alt="{{ $like['authorable']['name'] }}" />
                                                @else
                                                    <img src="{{ asset('admin/img/messages-3.jpg') }}"
                                                        class="img-fluid rounded-circle" width="50" height="50"
                                                        alt="{{ $like['authorable']['name'] }}" />
                                                @endif
                                            </div>
                                            <div class="col">
                                                {{ $like['authorable']['name'] }}
                                            </div>
                                        </div>

                                    @empty
                                    @endforelse
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
