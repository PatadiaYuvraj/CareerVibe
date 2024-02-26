@extends('user.layout.app')
@section('title', 'Home')

@section('content')

    <!-- Start Hero Area -->
    {{-- <section class="hero-area style2">
        <!-- Single Slider -->
        <div class="hero-inner">
            <div class="home-slider">
                <div class="single-slider">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 co-12">
                                <div class="inner-content">
                                    <div class="hero-text">
                                        <h1 class="wow fadeInUp" data-wow-delay=".3s">
                                            Find Your Career <br />to Make a Better Life
                                        </h1>
                                        <p class="wow fadeInUp" data-wow-delay=".5s">
                                            Creating a beautiful job website is not easy always. To
                                            make your life easier we are introducing Jobcamp
                                            template, Leverage agile frameworks to high level
                                            overviews.
                                        </p>
                                        <div class="button wow fadeInUp" data-wow-delay=".7s">
                                            <a href="{{ route('user.job.index') }}" class="btn btn-alt">See Our Jobs</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 co-12">
                                <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                                    <img src="{{ asset('front/images/hero/banner.png') }}" alt="#" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="single-slider">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 co-12">
                                <div class="inner-content">
                                    <div class="hero-text">
                                        <h1 class="wow fadeInUp" data-wow-delay=".3s">
                                            Find Your Career <br />to Make a Better Life
                                        </h1>
                                        <p class="wow fadeInUp" data-wow-delay=".5s">
                                            Creating a beautiful job website is not easy always. To
                                            make your life easier we are introducing Jobcamp
                                            template, Leverage agile frameworks to high level
                                            overviews.
                                        </p>
                                        <div class="button wow fadeInUp" data-wow-delay=".7s">
                                            <a href="{{ route('user.job.index') }}" class="btn btn-alt">See Our Jobs</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 co-12">
                                <div class="hero-image wow fadeInRight" data-wow-delay=".ss">
                                    <img src="{{ asset('front/images/hero/banner2.png') }}" alt="#" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Single Slider -->
    </section> --}}
    <!--/ End Hero Area -->

    <!-- Start Call Action Area Dont Show      -->
    {{-- <section class="call-action style2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="text">
                        <h2>Create your profile to find thousands Jobs.</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="button">
                        <a href="browse-jobs.html" class="btn">Browse Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- /End Call Action Area -->

    <!-- Start Job Category Area Done -->
    <section class="job-category style2 section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Job Category</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Browse by Catagories
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="cat-head">
                <div class="row">
                    @forelse ($categories as $category)
                        <div class="col-lg-3 col-md-6 col-12">
                            <a href="#" class="single-cat wow fadeInUp" data-wow-delay=".2s">
                                <div class="top-side">
                                    <img src="{{ asset('front/images/jobs/category-1.jpg') }}" alt="#" />
                                </div>
                                <div class="bottom-side">
                                    <span class="available-job">{{ $category->jobs_count }}</span>
                                    <h3>{{ $category->name }}</h3>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                No Categories Found
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- /End Job Category Area -->

    <!-- Start About Area Done -->
    <section class="about-us section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10 col-12">
                    <div class="content-left wow fadeInLeft" data-wow-delay=".3s">
                        <div calss="row">
                            <div calss="col-lg-6 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img" src="{{ asset('front/images/about/small1.jpg') }}"
                                            alt="#" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img mt-50" src="{{ asset('front/images/about/small2.jpg') }}"
                                            alt="#" />
                                    </div>
                                </div>
                            </div>
                            <div calss="col-lg-6 col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <img class="single-img minus-margin"
                                            src="{{ asset('front/images/about/small3.jpg') }}" alt="#" />
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <!-- media body start -->
                                        <div class="media-body">
                                            <i class="lni lni-checkmark"></i>
                                            <h6 class="">Job alert!</h6>
                                            <p class="">104 new jobs are available in this week!</p>
                                        </div>
                                        <!-- media body start -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-10 col-12">
                    <!-- content-1 start -->
                    <div class="content-right wow fadeInRight" data-wow-delay=".5s">
                        <!-- Heading -->
                        <h2>
                            Help you to get the <br />
                            best job that fits you
                        </h2>
                        <!-- End Heading -->
                        <!-- Single List -->
                        <div class="single-list">
                            <i class="lni lni-grid-alt"></i>
                            <!-- List body start -->
                            <div class="list-bod">
                                <h5>
                                    #1 Jobs site in the world
                                </h5>
                                <p>
                                    Leverage agile frameworks to provide a robust synopsis for
                                    high level overviews.
                                </p>
                            </div>
                            <!-- List body start -->
                        </div>
                        <!-- End Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <i class="lni lni-search"></i>
                            <!-- List body start -->
                            <div class="list-bod">
                                <h5>
                                    Search for jobs
                                </h5>
                                <p>
                                    Iterative approaches to corporate strategy foster
                                    collaborative thinking to further the overall value
                                    proposition.
                                </p>
                            </div>
                            <!-- List body start -->
                        </div>
                        <!-- End Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <i class="lni lni-stats-up"></i>
                            <!-- List body start -->
                            <div class="list-bod">
                                <h5>
                                    Apply for jobs
                                </h5>
                                <p>
                                    Organically grow the holistic world view of disruptive
                                    innovation via workplace diversity and empowerment.
                                </p>
                            </div>
                            <!-- List body start -->
                        </div>
                        <!-- End Single List -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area -->

    <!-- Start Call Action Area Done -->
    <section class="call-action overlay section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="inner">
                        <div class="section-title">
                            <span class="wow fadeInDown" data-wow-delay=".2s">GETTING STARTED TO WORK</span>
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">
                                Don’t just find. Be found.
                                Put your CV in front of great employers.
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".6s">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                                suffered alteration in some form.
                            </p>
                            <div class="button wow fadeInUp" data-wow-delay=".8s">
                                <a href="{{ route('user.profile.editResumePdf') }}" class="btn">
                                    <i class="lni lni-upload"></i>
                                    @if (!auth()->user()->resume_pdf_url)
                                        Not Uploaded Your Resume Yet?
                                    @else
                                        Update Your Resume
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- /End Call Action Area -->

    <!-- Start Find Job Area Done -->
    <section class="find-job section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Hot Jobs</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Browse Recent Jobs
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="single-head">

                <div class="row">
                    @forelse ($latestJobs as $job)
                        <!-- Single Job -->
                        <div class="single-job col-lg-4 col-md-6 col-12"
                            style="width: 45%; margin: 0 auto; margin-bottom: 20px; padding: 20px; border: 1px solid #e0e0e0;   border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); transition: all 0.3s ease-in-out;">
                            <div class="job-content">
                                <h4>
                                    <a href="
                                    {{ route('user.job.show', $job->id) }}">
                                        {{ $job->subProfile->name }}
                                    </a>
                                </h4>
                                <p>
                                    {{ Str::limit($job->description, 150, $end = '...') }}
                                </p>
                                <ul>
                                    <li>
                                        @if ($job->min_salary >= 1000)
                                            <i class="bi bi-currency-rupee"></i>{{ $job->min_salary / 1000 }}k
                                            -
                                            <i class="bi bi-currency-rupee"></i>{{ $job->max_salary / 1000 }}k
                                        @else
                                            <i class="bi bi-currency-rupee"></i>{{ $job->min_salary }} -
                                            <i class="bi bi-currency-rupee"></i>{{ $job->max_salary }}
                                        @endif
                                    </li>
                                    <li>
                                        <i class="lni lni-briefcase"></i>
                                        {{ Config::get('constants.job.work_type')[$job->work_type] }}
                                    </li>
                                    <li>
                                        <i class="lni lni-briefcase"></i>
                                        {{ Config::get('constants.job.job_type')[$job->job_type] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="job-button">
                                <ul>
                                    <li>
                                        @if ($job->saved_by_users_count > 0)
                                            <a href="{{ route('user.job.unsaveJob', $job->id) }}">
                                                <i class="bi bi-bookmark-check"></i> Saved
                                            </a>
                                        @else
                                            <a href="{{ route('user.job.saveJob', $job->id) }}">
                                                <i class="bi bi-bookmark-plus"></i>
                                                Save Now
                                            </a>
                                        @endif
                                    </li>
                                    <li>
                                        <span>
                                            {{ Config::get('constants.job.experience_level')[$job->experience_level] }}
                                        </span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- End Single Job -->
                    @empty
                        <div class="single-job mx-auto">
                            <div class="job-content">
                                <h4 class="text-center">
                                    <span class="text-danger">No Job Found</span>
                                </h4>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- /End Find Job Area -->

    <!-- Start Featured Job Area -->
    <section class="featured-job section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">
                            Featured Jobs
                        </span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Browse Featured Jobs
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="single-head">
                <div class="row">
                    @forelse ($featuredJobs as $job)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-job wow fadeInUp" data-wow-delay=".2s">
                                <div class="shape"></div>
                                <div class="feature">Featured</div>
                                <div class="content">
                                    <h4>
                                        <a href="{{ route('user.job.show', $job->id) }}">
                                            {{ $job->subProfile->name }}
                                        </a>
                                    </h4>
                                    <ul>

                                        <li class="text-capitalize">
                                            <i class="lni lni-briefcase"></i>
                                            {{ Config::get('constants.job.work_type')[$job->work_type] }}
                                        </li>
                                        <li>
                                            <i class="lni lni-briefcase"></i>
                                            {{ Config::get('constants.job.job_type')[$job['job_type']] }}
                                        </li>
                                        <li>
                                            <i class="bi bi-currency-rupee"></i>
                                            @if ($job['min_salary'] >= 1000)
                                                {{ $job['min_salary'] / 1000 }}k
                                                -
                                                {{ $job['max_salary'] / 1000 }}k
                                            @else
                                                {{ $job['min_salary'] }} -
                                                {{ $job['max_salary'] }}
                                            @endif
                                        </li>

                                    </ul>
                                    <p>{{ Str::limit($job->description, 150, $end = '...') }}</p>
                                    <div class="sidebar-widget">
                                        <div class="inner">
                                            <div class="row m-n2 button g-2">
                                                <div class="col-lg-12 col-sm-auto col-12">
                                                    @if ($job->apply_by_users_count > 0)
                                                        <a href="{{ route('user.job.unapply', $job['id']) }}"
                                                            class="d-block btn">
                                                            <i class="bi bi-check-circle-fill">
                                                                Applied
                                                            </i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('user.job.apply', $job['id']) }}"
                                                            class="d-block btn">
                                                            <i class="bi bi-check-circle">
                                                                Apply Now
                                                            </i>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="col-lg-12 col-sm-auto col-12">
                                                    @if ($job->saved_by_users_count > 0)
                                                        <a href="{{ route('user.job.unsaveJob', $job['id']) }}"
                                                            class="d-block btn">
                                                            <i class="bi bi-bookmark-fill">
                                                                Saved
                                                            </i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('user.job.saveJob', $job['id']) }}"
                                                            class="d-block btn">
                                                            <i class="bi bi-bookmark">
                                                                Save Now
                                                            </i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-danger text-center">
                                No Jobs Found
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- /End Featured Job Area -->

    <!-- Start Testimonials Section Dont Show-->
    {{-- <section class="testimonials">
        <img class="patern1 wow fadeInRight" data-wow-delay=".3s" src="{{ asset('front/images/testimonial/patern1.png') }}"
            alt="#" />
        <img class="patern2 wow fadeInLeft" data-wow-delay=".5s" src="{{ asset('front/images/testimonial/patern1.png') }}"
            alt="#" />
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="section-title align-left wow fadeInLeft" data-wow-delay=".3s">
                        <span>What saye's Our Clients</span>
                        <h2>Our Testimonials</h2>
                    </div>
                    <div class="testimonial-inner-head wow fadeInLeft" data-wow-delay=".3s">
                        <div class="testimonial-inner">
                            <div class="testimonial-slider">
                                <!-- Single Testimonial -->
                                <div class="single-testimonial">
                                    <div class="quote">
                                        <i class="lni lni-quotation"></i>
                                    </div>
                                    <p>
                                        " I just brought it and i love it. Lorem Ipsum is simply
                                        dummy text of the and typesetting industry. Lorem Ipsum
                                        has been the industry's standard dummy text ever since the
                                        1500s."
                                    </p>
                                    <div class="bottom">
                                        <div class="clien-image">
                                            <img src="{{ asset('front/images/testimonial/testi1.jpg') }}" alt="#" />
                                        </div>
                                        <h4 class="name">
                                            Musharof Chowdhury <span>CEO - Graygrids</span>
                                        </h4>
                                    </div>
                                </div>
                                <!--/ End Single Testimonial -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="testimonial-right wow fadeInRight" data-wow-delay=".5s">
                        <img src="{{ asset('front/images/testimonial/testimonial-right.png') }}" alt="#" />
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- /End Testimonials Section -->

    <!-- Start Pricing Table Area Dont Show -->
    <section class="pricing-table section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Pricing Table</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Our Pricing Plan
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Table -->
                    <div class="single-table wow fadeInUp" data-wow-delay=".2s">
                        <!-- Table Head -->
                        <div class="table-head">
                            <h4 class="title">BASIC PACK</h4>
                            <div class="price">
                                <p class="amount">
                                    $30<span class="duration">per month</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Table Head -->
                        <!-- Table List -->
                        <ul class="table-list">
                            <li>5+ Listings</li>
                            <li>Contact With Agent</li>
                            <li>Contact With Agent</li>
                            <li>7×24 Fully Support</li>
                            <li>50GB Space</li>
                        </ul>
                        <!-- End Table List -->
                        <!-- Table Bottom -->
                        <div class="button">
                            <a class="btn" href="#">Register Now</a>
                        </div>
                        <!-- End Table Bottom -->
                    </div>
                    <!-- End Single Table-->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Table -->
                    <div class="single-table wow fadeInUp" data-wow-delay=".4s">
                        <!-- Table Head -->
                        <div class="table-head">
                            <h4 class="title">STANDARD PACK</h4>
                            <div class="price">
                                <p class="amount">
                                    $40<span class="duration">per month</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Table Head -->
                        <!-- Table List -->
                        <ul class="table-list">
                            <li>5+ Listings</li>
                            <li>Contact With Agent</li>
                            <li>Contact With Agent</li>
                            <li>7×24 Fully Support</li>
                            <li>50GB Space</li>
                        </ul>
                        <!-- End Table List -->
                        <!-- Table Bottom -->
                        <div class="button">
                            <a class="btn" href="#">Register Now</a>
                        </div>
                        <!-- End Table Bottom -->
                    </div>
                    <!-- End Single Table-->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single Table -->
                    <div class="single-table wow fadeInUp" data-wow-delay=".6s">
                        <!-- Table Head -->
                        <div class="table-head">
                            <h4 class="title">PREMIUM PACK</h4>
                            <div class="price">
                                <p class="amount">
                                    $60<span class="duration">per month</span>
                                </p>
                            </div>
                        </div>
                        <!-- End Table Head -->
                        <!-- Table List -->
                        <ul class="table-list">
                            <li>5+ Listings</li>
                            <li>Contact With Agent</li>
                            <li>Contact With Agent</li>
                            <li>7×24 Fully Support</li>
                            <li>50GB Space</li>
                        </ul>
                        <!-- End Table List -->
                        <!-- Table Bottom -->
                        <div class="button">
                            <a class="btn" href="#">Register Now</a>
                        </div>
                        <!-- End Table Bottom -->
                    </div>
                    <!-- End Single Table-->
                </div>
            </div>
        </div>
    </section>
    <!--/ End Pricing Table Area -->

    <!-- Start Latest News Area Done Latest Post Show Here -->
    <div class="latest-news-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown" data-wow-delay=".2s">latest news</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Latest News & Blog
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single News -->
                    <div class="single-news wow fadeInUp" data-wow-delay=".3s">
                        <div class="image">
                            <img class="thumb" src="{{ asset('front/images/blog/blog1.jpg') }}" alt="#" />
                        </div>
                        <div class="content-body">
                            <h4 class="title">
                                <a href="blog-single.html">
                                    How To Get A Job In The Tech Industry
                                </a>
                            </h4>

                            <div class="meta-details">
                                <ul>
                                    <li>
                                        <a href="#"><i class="lni lni-tag"></i> Job skills</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-calendar"></i> 12-09-2023</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-eye"></i> 55</a>
                                    </li>
                                </ul>
                            </div>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the standard.
                            </p>
                            <div class="button">
                                <a href="blog-single.html" class="btn">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single News -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single News -->
                    <div class="single-news wow fadeInUp" data-wow-delay=".5s">
                        <div class="image">
                            <img class="thumb" src="{{ asset('front/images/blog/blog2.jpg') }}" alt="#" />
                        </div>
                        <div class="content-body">
                            <h4 class="title">
                                <a href="blog-single.html">
                                    How To Get A Job In The Tech Industry
                                </a>
                            </h4>
                            <div class="meta-details">
                                <ul>
                                    <li>
                                        <a href="#"><i class="lni lni-tag"></i> Career advice</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-calendar"></i> 10-10-2023</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-eye"></i> 55</a>
                                    </li>
                                </ul>
                            </div>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the standard.
                            </p>
                            <div class="button">
                                <a href="blog-single.html" class="btn">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single News -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Single News -->
                    <div class="single-news wow fadeInUp" data-wow-delay=".7s">
                        <div class="image">
                            <img class="thumb" src="{{ asset('front/images/blog/blog3.jpg') }}" alt="Blog 3" />
                        </div>
                        <div class="content-body">
                            <h4 class="title">
                                <a href="blog-single.html">
                                    How To Get A Job In The Tech Industry
                                </a>
                            </h4>
                            <div class="meta-details">
                                <ul>
                                    <li>
                                        <a href="#"><i class="lni lni-tag"></i> Future plan</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-calendar"></i> 09-05-2023</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="lni lni-eye"></i> 55</a>
                                    </li>
                                </ul>
                            </div>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the standard.
                            </p>
                            <div class="button">
                                <a href="blog-single.html" class="btn">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single News -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Latest News Area -->

    <!-- Start Clients Area Done -->
    <div class="client-logo-section">
        <div class="container">
            <div class="client-logo-wrapper">
                <div class="client-logo-carousel d-flex align-items-center justify-content-between">
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client1.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client2.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client3.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client4.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client5.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client6.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client2.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client3.png') }}" alt="#" />
                    </div>
                    <div class="client-logo">
                        <img src="{{ asset('front/images/clients/client4.png') }}" alt="#" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Clients Area -->

@endsection
