@extends('user.layout.app')
@section('pageTitle', 'Show Post | ' . env('APP_NAME'))
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header ">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.post.index') }}">Posts</a></li>
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
                                href="{{ route('user.post.edit', $post['id']) }}">Edit</a>
                        </p>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                No. of Comments
                            </h5>
                            <h6 class="">
                                {{ count($post['comments']) }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                No. of Likes
                            </h5>
                            <h6 class="">
                                {{ count($post['likes']) }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
