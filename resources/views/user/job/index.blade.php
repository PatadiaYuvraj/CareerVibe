@extends('user.layout.app') @section('title', 'Job List') @section('content')
<!-- Start Breadcrumbs -->
{{--
<div class="breadcrumbs overlay wow fadeInDown">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">Browse Job</h1>
                    <p>
                        Business plan draws on a wide range of knowledge from
                        different business <br />
                        disciplines. Business draws on a wide range of different
                        business .
                    </p>
                </div>
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                    <li>Browse Job</li>
                </ul>
            </div>
        </div>
    </div>
</div>
--}}
<!-- End Breadcrumbs -->
<style>
    #loader-container {
        display: none;
        /* Initially hidden */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        /* Semi-transparent white background */
        z-index: 9999;
        /* Make sure it's above other content */
    }

    /* Styles for the loader */
    .loader {
        border: 8px solid #f3f3f3;
        /* Light grey border */
        border-top: 8px solid #3498db;
        /* Blue border for animation */
        border-radius: 50%;
        /* Circular shape */
        width: 50px;
        height: 50px;
        animation: spin 0.8s linear infinite;
        /* Spin animation */
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -25px;
        /* Center vertically */
        margin-left: -25px;
        /* Center horizontally */
    }

    /* Animation for the loader */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<!-- Start Find Job Area -->
<div id="loader-container">
    <div class="loader"></div>
</div>
<section class="find-job job-list section wow fadeInUp">
    <div class="container">
        {{--
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <span class="wow fadeInDown" data-wow-delay=".2s"
                        >Hot Jobs</span
                    >
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">
                        Browse Recent Jobs
                    </h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">
                        There are many variations of passages of Lorem Ipsum
                        available, but the majority have suffered alteration in
                        some form.
                    </p>
                </div>
            </div>
        </div>
        --}}
        <div class="single-head" id="loadMore">
            <div class="row" id="jobList"></div>
        </div>
    </div>
</section>
<!-- /End Find Job Area -->

<!-- Start About Area Done -->
{{--
<section class="about-us section">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10 col-12">
                <div class="content-left wow fadeInLeft" data-wow-delay=".3s">
                    <div calss="row">
                        <div calss="col-lg-6 col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-6">
                                    <img
                                        class="single-img"
                                        src="{{
                                            asset(
                                                'front/images/about/small1.jpg'
                                            )
                                        }}"
                                        alt="#"
                                    />
                                </div>
                                <div class="col-lg-6 col-md-6 col-6">
                                    <img
                                        class="single-img mt-50"
                                        src="{{
                                            asset(
                                                'front/images/about/small2.jpg'
                                            )
                                        }}"
                                        alt="#"
                                    />
                                </div>
                            </div>
                        </div>
                        <div calss="col-lg-6 col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-6">
                                    <img
                                        class="single-img minus-margin"
                                        src="{{
                                            asset(
                                                'front/images/about/small3.jpg'
                                            )
                                        }}"
                                        alt="#"
                                    />
                                </div>
                                <div class="col-lg-6 col-md-6 col-6">
                                    <!-- media body start -->
                                    <div class="media-body">
                                        <i class="lni lni-checkmark"></i>
                                        <h6 class="">Job alert!</h6>
                                        <p class="">
                                            104 new jobs are available in this
                                            week!
                                        </p>
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
                            <h5>#1 Jobs site in the world</h5>
                            <p>
                                Leverage agile frameworks to provide a robust
                                synopsis for high level overviews.
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
                            <h5>Search for jobs</h5>
                            <p>
                                Iterative approaches to corporate strategy
                                foster collaborative thinking to further the
                                overall value proposition.
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
                            <h5>Apply for jobs</h5>
                            <p>
                                Organically grow the holistic world view of
                                disruptive innovation via workplace diversity
                                and empowerment.
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
--}}
<!-- End About Area -->

<!-- Start Featured Job Area -->

<!-- /End Featured Job Area -->
@endsection @section('scripts')
<script>
    $(document).ready(function() {
        let page = 1;
        let has_more = true;
        $("#loader-container").attr("style", "display: block;");


        const loadMoreData = () => {
            $.ajax({
                url: "{!! route('user.job.loadMoreJobs') !!}",
                method: "POST",
                data: {
                    page: page,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    $("#loader-container").attr("style", "display: none;");
                    console.log(data);
                    let jobTemplate = "";
                    if (data.has_more == false) {
                        has_more = false;
                        return;
                    }
                    let jobs = data.jobs;
                    if (data.has_more) {
                        has_more = true;
                        jobs.forEach((job) => {
                            $("#jobList").append(addDatatoJobTemplate(job));
                        });
                    }
                    page++;
                },
                error: function(error) {
                    console.log(error);
                    $("#loader-container").attr("style", "display: none;");
                },
            });
        }

        loadMoreData();

        $(document).scroll(function() {

            const debounceDelay = 300; // Adjust as needed

            // Use a setTimeout to delay the execution of the code inside the scroll event handler
            clearTimeout($.data(this, "scrollTimer"));
            $.data(
                this,
                "scrollTimer",
                setTimeout(function() {
                    // Code inside this block will execute after the debounce delay
                    if (
                        $(window).scrollTop() + $(window).height() >=
                        $("#loadMore").height()
                    ) {
                        $("#loader-container").attr("style", "display: block;");
                        if (!has_more) {
                            $("#loader-container").attr(
                                "style",
                                "display: none;"
                            );
                            return;
                        }
                        loadMoreData();
                    }
                }, debounceDelay)
            );
        });


        function addDatatoJobTemplate(job) {
            sub_profile_url = job.sub_profile_url.replace(":id", job.id);
            company_url = job.company_url.replace(":id", job.company_id);
            save_job_url = job.save_job_url.replace(":id", job.id);
            apply_job_url = job.apply_job_url.replace(":id", job.id);
            unsave_job_url = job.unsave_job_url.replace(":id", job.id);
            unapply_job_url = job.unapply_job_url.replace(":id", job.id);

            var html =
                `<div class="single-job col-lg-12 col-md-12 col-12" style="padding:25px;border:1px solid #e0e0e0;border-radius:10px;"><div class="job-content"><h4><a href="${sub_profile_url}">${job.sub_profile_name}</a></h4><ul class=""><li><a href="${company_url}">Offered By: ${job.company_name}</a></li><li>${job.profile_category_name}</li></ul><p>${job.description}</p><ul><li><i class="bi bi-currency-rupee"></i>${job.min_salary > 1000 ? job.min_salary > 1000000 ? job.min_salary / 1000000 + "M" : job.min_salary / 1000 + "K" : job.min_salary}-${job.max_salary > 1000 ? job.max_salary > 1000000 ? job.max_salary / 1000000 + "M" : job.max_salary / 1000 + "K" : job.max_salary}</li><li><i class="bi bi-briefcase"></i>${job.job_type.replace("_", " ").toLowerCase().replace(/\b[a-z]/g, function (letter) {return letter.toUpperCase();})}</li><li><i class="bi bi-briefcase"></i>${job.work_type.replace("_", " ").toLowerCase().replace(/\b[a-z]/g, function (letter) {return letter.toUpperCase();})}</li><li><i class="bi bi-briefcase"></i>${job.experience_level.replace("_", " ").toLowerCase().replace(/\b[a-z]/g, function (letter) {return letter.toUpperCase();})}</li>${job.qualifications.map((qualification) => `<li><i class="bi bi-book-half"></i>${qualification.name}</li>`).join("")}${job.locations.map((location) => `<li><i class="bi bi-geo-alt"></i>${location.city}</li>`).join("")}</ul></div><div class="job-button"><ul><li>${job.saved_by_me == "1" ? `<a href="${unsave_job_url}"><i class="bi bi-bookmark-check"></i> Saved</a>` : `<a href="${save_job_url}"><i class="bi bi-bookmark-plus"></i> Save Now</a>`}</li> <li>${job.applied_by_me == "1" ? `<a href="${unapply_job_url}"><i class="bi bi-bookmark-check"></i> Applied</a>` : `<a href="${apply_job_url}"><i class="bi bi-bookmark-plus"></i> Apply Now</a>`}</li></ul></div></div>`;
            return html;
        }
    });
</script>

@endsection
