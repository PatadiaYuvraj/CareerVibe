@extends('user.layout.app') @section('title', 'Post | ' . env('APP_NAME'))
@php
    $currentAuthId = auth()->guard(config('constants.USER_GUARD'))->id();
@endphp

@section('content')

    <!-- Start Breadcrumbs -->
    {{-- <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Blog Single Sidebar</h1>
                        <p>Business plan draws on a wide range of knowledge from different business<br> disciplines.
                            Business draws on a wide range of different business .</p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="index-2.html">Home</a></li>
                        <li>Blog Single Sidebar</li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Breadcrumbs -->

    <!-- Start Blog Singel Area -->
    <section class="section blog-single">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-8"> --}}
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="single-inner">
                        {{-- <div class="post-thumbnils">
                            <img src="assets/images/blog/blog-single.jpg" alt="#">
                        </div> --}}
                        <div class="post-details">
                            <div class="detail-inner">
                                <h2 class="post-title">
                                    {{ $post->title }}
                                </h2>
                                <!-- post meta -->
                                <ul class="custom-flex post-meta">
                                    <li>
                                        <a href="#">
                                            <i class="lni lni-calendar"></i>
                                            @if ($post['created_at'])
                                                {{ date('d-m-Y', strtotime($post['created_at'])) }}
                                            @else
                                                {{ 'N/A' }}
                                            @endif
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="lni lni-comments"></i>
                                            {{ count($post->comments) }} Comments
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $post->likes->where('authorable_type', 'App\Models\User')->where('authorable_id', $currentAuthId)->count() >
                                        0
                                            ? route('user.post.unlike', $post['id'])
                                            : route('user.post.like', $post['id']) }}"
                                            class="{{ $post->likes->where('authorable_type', 'App\Models\User')->where('authorable_id', $currentAuthId)->count() >
                                            0
                                                ? 'lni lni-heart-filled text-danger'
                                                : 'lni lni-heart' }}">
                                            {{ $post->likes_count }}</i>
                                        </a>
                                    </li>
                                </ul>
                                <p>
                                    {{ $post->content }}
                                </p>
                                <!-- post image -->
                                {{-- <div class="post-image">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <a href="#" class="mb-4">
                                                <img src="assets/images/blog/blog-single2.jpg" alt="#">
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <a href="#">
                                                <img src="assets/images/blog/blog-single3.jpg" alt="#">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <h3>A cleansing hot shower or bath</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                    irure
                                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                                    pariatur.
                                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia. </p>
                                <!-- post quote -->
                                <blockquote>
                                    <div class="icon">
                                        <i class="lni lni-quotation"></i>
                                    </div>
                                    <h4>"Don't demand that things happen as you wish, but wish that they happen as they
                                        do
                                        happen, and you will go on well."</h4>
                                    <span>Epictetus, The Enchiridion</span>
                                    <img class="shape" src="assets/images/testimonial/patern1.png" alt="#">
                                </blockquote>
                                <h3>Setting the mood with incense</h3>
                                <p>Remove aversion, then, from all things that are not in our control, and transfer it
                                    to
                                    things contrary to the nature of what is in our control. But, for the present,
                                    totally
                                    suppress desire: for, if you desire any of the things which are not in your own
                                    control,
                                    you must necessarily be disappointed; and of those which are, and which it would be
                                    laudable to desire, nothing is yet in your possession. Use only the appropriate
                                    actions
                                    of pursuit and avoidance; and even these lightly, and with gentleness and
                                    reservation.
                                </p> --}}
                                {{-- <ul class="list">
                                    <li><i class="lni lni-chevron-right"></i> The happiness of your life depends upon
                                        the
                                        quality of your thoughts </li>
                                    <li><i class="lni lni-chevron-right"></i> You have power over your mind, not outside
                                        events</li>
                                    <li><i class="lni lni-chevron-right"></i>The things you think about determine the
                                        quality of your mind</li>
                                </ul>

                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                    irure
                                    dolor in reprehenderit. </p>
                                <p>Voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
                                    cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                                    laborum.
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium. </p>
                                <!--post tags --> --}}
                                {{-- <div class="post-tags-media">
                                    <div class="post-tags popular-tag-widget mb-xl-40">
                                        <h5 class="tag-title">Related Tags</h5>
                                        <div class="tags">
                                            <a href="#">Popular</a>
                                            <a href="#">Design</a>
                                            <a href="#">UX</a>
                                        </div>
                                    </div>
                                    <div class="post-social-media">
                                        <h5 class="share-title">Social Share</h5>
                                        <ul class="custom-flex">
                                            <li>
                                                <a href="#">
                                                    <i class="lni lni-twitter-original"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="lni lni-facebook-oval"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="lni lni-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- Comments --}}
                            <div class="post-comments">
                                <h3 class="comment-title">
                                    <span>
                                        {{ count($post->comments) }} comments on this post
                                    </span>
                                </h3>
                                <ul class="comments-list">
                                    @foreach ($post->comments as $comment)
                                        <li>
                                            <div class="comment-desc">
                                                <div class="desc-top">
                                                    <h6>{{ $comment->authorable->name }}</h6>
                                                    <span class="date">{{ $comment->created_at->diffForHumans() }}</span>
                                                    @if ($comment['likes']->where('authorable_type', 'App\Models\User')->where('authorable_id', $currentAuthId)->count() > 0)
                                                        <a href="{{ route('user.post.commentUnlike', [$post['id'], $comment['id']]) }}"
                                                            class="btn btn-sm link-danger reply-link">
                                                            <i class="bi-heart-fill">
                                                                {{ $comment['likes']->count() }}
                                                                {{ $comment['likes']->count() > 1 ? 'Likes' : 'Like' }}
                                                            </i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('user.post.commentLike', [$post['id'], $comment['id']]) }}"
                                                            class="btn btn-sm reply-link">
                                                            <i class="bi-heart">
                                                                {{ $comment['likes']->count() }}
                                                                {{ $comment['likes']->count() > 1 ? 'Likes' : 'Like' }}
                                                            </i>
                                                        </a>
                                                    @endif
                                                </div>
                                                <p>
                                                    {{ $comment->content }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="comment-form">
                                <h3 class="comment-reply-title"><span>Leave a comment</span></h3>
                                <form action="{{ route('user.post.commentStore', $post['id']) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-box form-group">
                                                <textarea id="content" name="content" rows="3" class="form-control form-control-custom"
                                                    placeholder="Your Comments"></textarea>
                                            </div>
                                            @error('content')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <div class="button">
                                                <button type="submit" class="btn mouse-dir white-bg">
                                                    Post Comment
                                                    <span class="dir-part">
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <aside class="col-lg-4 col-md-12 col-12">
                    <div class="sidebar">
                        <div class="widget search-widget">
                            <h5 class="widget-title"><span>Search This Site</span></h5>
                            <form action="#">
                                <input type="text" placeholder="Search Here...">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </form>
                        </div>
                        <div class="widget popular-feeds">
                            <h5 class="widget-title"><span>Popular Feeds</span></h5>
                            <div class="popular-feed-loop">
                                <div class="single-popular-feed">
                                    <div class="feed-desc">
                                        <h6 class="post-title"><a href="#">Tips to write an impressive resume online
                                                for
                                                beginner</a></h6>
                                        <span class="time"><i class="lni lni-calendar"></i> 05th Nov 2023</span>
                                    </div>
                                </div>
                                <div class="single-popular-feed">
                                    <div class="feed-desc">
                                        <h6 class="post-title"><a href="#">10 most important SEO focus areas for
                                                colleges
                                                and universities</a></h6>
                                        <span class="time"><i class="lni lni-calendar"></i> 24th March 2023</span>
                                    </div>
                                </div>
                                <div class="single-popular-feed">
                                    <div class="feed-desc">
                                        <h6 class="post-title"><a href="#">7 things you should never say to your
                                                boss in
                                                your joblife</a></h6>
                                        <span class="time"><i class="lni lni-calendar"></i> 30th Jan 2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget categories-widget">
                            <h5 class="widget-title"><span>Categories</span></h5>
                            <ul class="custom">
                                <li>
                                    <a href="#">Announcement<span>26</span></a>
                                </li>
                                <li>
                                    <a href="#">Indeed Events<span>30</span></a>
                                </li>
                                <li>
                                    <a href="#">Tips & Tricks<span>71</span></a>
                                </li>
                                <li>
                                    <a href="#">Experiences<span>56</span></a>
                                </li>
                                <li>
                                    <a href="#">Case Studies<span>15</span></a>
                                </li>
                                <li>
                                    <a href="#">Labor Market News<span>12</span></a>
                                </li>
                                <li>
                                    <a href="#">HR Best Practices<span>17</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="widget popular-tag-widget">
                            <h5 class="widget-title"><span>Popular Tags</span></h5>
                            <div class="tags">
                                <a href="#">Jobpress</a>
                                <a href="#">Design</a>
                                <a href="#">HR</a>
                                <a href="#">Recruiter</a>
                                <a href="#">Interview</a>
                                <a href="#">Employee</a>
                                <a href="#">Labor</a>
                                <a href="#">Salary</a>
                                <a href="#">Consult</a>
                                <a href="#">Business</a>
                                <a href="#">Candidates</a>
                            </div>
                        </div>
                    </div>
                </aside> --}}
            </div>
        </div>
    </section>
    <!-- End Blog Singel Area -->
@endsection
