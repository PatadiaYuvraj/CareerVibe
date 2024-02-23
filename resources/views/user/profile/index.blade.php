@extends('user.profile.layout.app')
@section('title', 'Your Profile')
@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="inner-content">
            <!-- Start Personal Top Content -->
            <div class="personal-top-content">
                <div class="single-section">
                    <div class="name-head">
                        <a class="mb-2" href="#"><img class="circle-54"
                                src="{{ asset('front/images/resume/avater.png') }}" alt="" /></a>
                        <h4>
                            <a class="name" href="#">
                                {{ auth()->user()->name }}
                            </a>
                        </h4>
                        <p>
                            <a class="deg" href="#">
                                Web Designer
                            </a>
                        </p>
                        <ul class="social">
                            <li>
                                <a href="#">
                                    <i class="lni lni-facebook-original">
                                    </i>
                                </a>
                            </li>
                            <li>
                                <a href="#"><i class="lni lni-twitter-original"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="lni lni-linkedin-original"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="lni lni-dribbble"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="lni lni-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="single-section">
                    <div class="content-right">
                        <h5 class="title-main">Contact Info</h5>
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">Location</h5>
                            <p>
                                {{ auth()->user()->city }}
                            </p>
                        </div>
                        <!-- Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">E-mail</h5>
                            <p>
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                        <!-- Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">Phone</h5>
                            <p>
                                {{ auth()->user()->contact }}
                            </p>
                        </div>
                        <!-- Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">
                                Access Resume
                            </h5>
                            <p>
                                {{-- dropdown --}}
                            <div class="dropdown">
                                <a class="dropdown-toggle btn btn-sm" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    View Option
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">PDF</a>
                                    <a class="dropdown-item" href="#">DOC</a>
                                    <a class="dropdown-item" href="#">DOCX</a>
                                </div>
                            </div>
                            </p>
                        </div>
                        <!-- Single List -->
                    </div>
                </div>
            </div>
            <!-- End Personal Top Content -->
            <!-- Start Single Section -->
            <div class="single-section">
                <h4>About</h4>
                <p class="font-size-4 mb-8">
                    {{ auth()->user()->about }}
                </p>
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section skill">
                <h4>Skills</h4>
                <ul class="list-unstyled d-flex align-items-center flex-wrap">
                    <li>
                        <a href="#">Agile</a>
                    </li>
                    <li>
                        <a href="#">Wireframing</a>
                    </li>
                    <li>
                        <a href="#">Prototyping</a>
                    </li>
                    <li>
                        <a href="#">Information</a>
                    </li>
                    <li>
                        <a href="#">Waterfall Model</a>
                    </li>
                    <li>
                        <a href="#">New Layout</a>
                    </li>
                    <li>
                        <a href="#">Ui/Ux Design</a>
                    </li>
                    <li>
                        <a href="#">Web Design</a>
                    </li>
                    <li>
                        <a href="#">Graphics Design</a>
                    </li>
                </ul>
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section exprerience">
                <h4>Work Exprerience</h4>
                <!-- Single Exp -->
                <div class="single-exp mb-30">
                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                        <div class="image">
                            <img src="assets/images/resume/work1.png" alt="#" />
                        </div>
                        <div class="w-100 mt-n2">
                            <h3 class="mb-0">
                                <a href="#">Lead Product Designer</a>
                            </h3>
                            <a href="#">Airabnb</a>
                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                <a href="#">Jun 2020 - April 2023- 3
                                    years</a>
                                <a href="#" class="font-size-3 text-gray">
                                    <span class="mr-2" style="margin-top: -2px"><i
                                            class="lni lni-map-marker"></i></span>New York, USA</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Exp -->
                <!-- Single Exp -->
                <div class="single-exp mb-30">
                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                        <div class="image">
                            <img src="assets/images/resume/work2.png" alt="#" />
                        </div>
                        <div class="w-100 mt-n2">
                            <h3 class="mb-0">
                                <a href="#">Senior UI/UX Designer</a>
                            </h3>
                            <a href="#">Google Inc</a>
                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                <a href="#">Jun 2020 - April 2023- 3
                                    years</a>
                                <a href="#" class="font-size-3 text-gray">
                                    <span class="mr-2" style="margin-top: -2px"><i
                                            class="lni lni-map-marker"></i></span>New York, USA</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Exp -->
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section education">
                <h4>Education</h4>
                <!-- Single Edu -->
                <div class="single-edu mb-30">
                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                        <div class="image">
                            <img src="assets/images/resume/edu1.svg" alt="#" />
                        </div>
                        <div class="w-100 mt-n2">
                            <h3 class="mb-0">
                                <a href="#">Masters in Art Design</a>
                            </h3>
                            <a href="#">Harvard University</a>
                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                <a href="#">Jun 2020 - April 2023- 3
                                    years</a>
                                <a href="#" class="font-size-3 text-gray">
                                    <span class="mr-2" style="margin-top: -2px"><i
                                            class="lni lni-map-marker"></i></span>Brylin, USA</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Edu -->
                <!-- Single Edu -->
                <div class="single-edu mb-30">
                    <div class="d-flex align-items-center pr-11 mb-9 flex-wrap flex-sm-nowrap">
                        <div class="image">
                            <img src="assets/images/resume/edu2.svg" alt="#" />
                        </div>
                        <div class="w-100 mt-n2">
                            <h3 class="mb-0">
                                <a href="#">Bachelor in Software
                                    Engineering</a>
                            </h3>
                            <a href="#">Manipal Institute of Technology</a>
                            <div class="d-flex align-items-center justify-content-md-between flex-wrap">
                                <a href="#">Fed 2019 - April 2023 - 4 years
                                </a>
                                <a href="#" class="font-size-3 text-gray">
                                    <span class="mr-2" style="margin-top: -2px"><i
                                            class="lni lni-map-marker"></i></span>New York, USA</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Edu -->
            </div>
            <!-- End Single Section -->
        </div>
    </div>
@endsection
