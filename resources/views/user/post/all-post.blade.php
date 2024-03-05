@extends('user.layout.app')
@section('title', 'All Posts | ' . env('APP_NAME'))
@php
$currentAuthId = auth()->guard(config('constants.USER_GUARD'))->id(); @endphp
@section('content')
    <!-- Start Breadcrumbs -->
    {{-- <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Blog Grid Sidebar</h1>
                        <p>
                            Business plan draws on a wide range of knowledge from
                            different business<br />
                            disciplines. Business draws on a wide range of different
                            business .
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="index-2.html">Home</a></li>
                        <li><a href="#">Blog</a></li>
                        <li>Blog Grid Sidebar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Breadcrumbs -->

    <!-- Start Blog Singel Area -->
    <section class="section latest-news-area blog-list">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-lg-6 col-12">
                                <!-- Single News -->
                                <div class="single-news wow fadeInUp" data-wow-delay=".3s">
                                    {{-- <div class="image">
                                        <img class="thumb" src="assets/images/blog/blog1.jpg" alt="#" />
                                    </div> --}}
                                    <div class="content-body">
                                        <h4 class="title">
                                            {{ $post['title'] }}
                                        </h4>
                                        <div class="meta-details">
                                            <ul>
                                                <li class="d-block">
                                                    <i class="lni lni-user"></i>
                                                    Published by User 1
                                                </li>
                                                <li class="d-block">
                                                    <i class="lni lni-calendar"></i>
                                                    12-09-2023
                                                </li>
                                                <li>
                                                    <i class="bi-heart  "> {{ $post->likes_count }}</i>
                                                </li>
                                                <li>
                                                    <i class="bi-chat-square-text">
                                                        {{ $post->comments_count }}
                                                    </i>

                                                </li>
                                            </ul>
                                        </div>
                                        <p>
                                            {{ $post['content'] }}
                                        </p>
                                        <div class="button">
                                            <a href="{{ route('user.post.show', $post['id']) }}" class="btn btn-sm"
                                                style="padding: 0.7rem 1.1rem;">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single News -->
                            </div>
                        @empty
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="single-news wow fadeInUp" data-wow-delay=".3s">
                                    <div class="content-body text-center">
                                        <p>No posts found</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- Pagination -->
                    @if (count($posts) > 0 && $posts->count() > 0)
                        @include('user.layout.pagination', ['paginator' => $posts->toArray()['links']])
                    @endif
                    <!--/ End Pagination -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog Singel Area -->
@endsection
