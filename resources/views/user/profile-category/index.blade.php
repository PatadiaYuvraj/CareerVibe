@extends('user.layout.app')
@section('title', 'Job Categories')

@section('content')

    <!-- Start Breadcrumbs -->
    {{-- <div class="breadcrumbs overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">Job Categories</h1>
                        <p>
                            Business plan draws on a wide range of knowledge from different
                            business<br />
                            disciplines. Business draws on a wide range of different
                            business .
                        </p>
                    </div>
                    <ul class="breadcrumb-nav">
                        <li><a href="{{ route('user.dashboard') }}">Home</a></li>
                        <li>Categories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- End Breadcrumbs -->

    <!-- Start Job Category Area -->
    <section class="job-category section all-categories section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <span class="wow fadeInDown jobCat" data-wow-delay=".2s">Job Category</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">
                            Choose Your Desire Category
                        </h2>
                        <p class="wow fadeInUp jobPara" data-wow-delay=".6s">
                            There are many variations of passages of Lorem Ipsum available,
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>


            <div class="container">
                <h2 class="categories-title">Browse All Categories</h2>
                <div class="row">
                    @forelse ($categories as $category)
                        <div class="ProfileCategory">
                            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12" style="cursor: pointer;">
                                <h3 class="cat-title ">
                                    {{ $category->name }}
                                    <span>
                                        ({{ count($category->subProfiles) }} Sub Profiles)
                                    </span>
                                </h3>
                            </div>
                            <div class="row row-cols-4 subProfiles">
                                @forelse ($category->subProfiles as $subProfiles)
                                    <ul class="col">
                                        <li>
                                            <a href="#">
                                                {{ $subProfiles->name }}
                                                ({{ $subProfiles->jobs->count() }} Jobs)
                                            </a>
                                        </li>
                                    </ul>
                                @empty
                                    <div class="col-lg-12 col-md-12 text-center col-xs-12">
                                        <ul>
                                            <li>No Sub Category Found</li>
                                        </ul>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12 col-md-12 text-center col-xs-12">
                            <h3 class="cat-title">No Category Found</h3>
                        </div>
                    @endforelse
                </div>
            </div>


        </div>
    </section>
    <!-- End Job Category Area -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.subProfiles').hide();

            const debounceValue = 300;

            const debounce = (func, delay) => {
                let timeoutId;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => {
                        func.apply(context, args);
                    }, delay);
                };
            }

            const debouncedClick = debounce(function(e) {
                $('.subProfiles').not($(this).closest('.ProfileCategory').find('.subProfiles'))
                    .slideUp(500);
                $(this).closest('.ProfileCategory').find('.subProfiles').slideToggle(500);
            }, debounceValue);

            $('.ProfileCategory').on('click', debouncedClick);
        });
    </script>
@endsection
