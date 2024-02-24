@extends('user.profile.layout.app')
@section('title', 'Your Profile')
@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="inner-content">
            <!-- Start Personal Top Content -->
            <div class="personal-top-content">
                {{-- <div class="single-section">
                    <div class="name-head">
                        <div class="">
                            <h4 class="">
                                {{ auth()->user()->name }}
                            </h4>
                            <h5 class="">
                                {{ auth()->user()->email }}
                            </h5>
                            @if (auth()->user()->profile_image_url)
                                <img class="col img-fluid"
                                    style="border-radius: 50%; width: 100px; height: 100px; object-fit: cover; object-position: center; background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);
                            border: 2px solid #f4f4f4; padding: 1px;
                            margin-bottom: 10px;
                             border-radius: 50%;"
                                    src="{{ auth()->user()->profile_image_url }}" alt="" />
                            @endif
                        </div>
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
                </div> --}}
                <div class="single-section">
                    <div class="content-right">
                        <h5 class="title-main">
                            <i class="lni lni-user"></i>
                            Personal Info
                        </h5>
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">Name</h5>
                            <p>
                                {{ auth()->user()->name }}
                            </p>
                        </div>
                        <!-- Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">Gender</h5>
                            <p>
                                @if (auth()->user()->gender)
                                    {{ Config::get('constants.gender')[auth()->user()->gender] }}
                                @else
                                    Not Specified
                                @endif
                            </p>
                        </div>
                        <!-- Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">
                                Profile Image
                            </h5>
                            <p>
                                @if (auth()->user()->profile_image_url)
                                    <img class="mt-2 img-fluid"
                                        style="width: 100px; height: 100px; object-fit: cover; object-position: center; background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);border: 2px solid #f4f4f4; padding: 2px; border-radius: 50%;"
                                        src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->email }}" />
                                @else
                                    Not Uploaded
                                @endif
                            </p>
                        </div>
                        <!-- Single List -->
                    </div>
                </div>
                <div class="single-section">
                    <div class="content-right">
                        <h5 class="title-main">
                            <i class="lni lni-phone"></i>
                            Contact Info
                        </h5>
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
                            <h5 class="title">Phone</h5>
                            <p>
                                {{ auth()->user()->contact }}
                            </p>
                        </div>
                        <!-- Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">
                                Profile Image
                            </h5>
                            {{-- dropdown --}}
                            <div class="dropdown mt-2">
                                <button class="btn dropdown-toggle" type="button" id="profileImageOptions"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    View Option
                                </button>
                                <ul class="dropdown-menu p-2 mt-0" aria-labelledby="profileImageOptions">
                                    {{-- Uplaod Profile Image --}}
                                    @if (!auth()->user()->profile_image_url)
                                        <li class="">
                                            <a class="dropdown-item" href="{{ route('user.profile.editProfileImage') }}">
                                                <i class="lni lni-upload"></i>
                                                Upload Now
                                            </a>
                                        </li>
                                    @endif
                                    {{-- View Profile Image --}}
                                    @if (auth()->user()->profile_image_url)
                                        <li class="mb-2">
                                            <a class="dropdown-item" target="_blank"
                                                href="{{ auth()->user()->profile_image_url }}">
                                                <i class="lni lni-eye"></i>
                                                View Profile Image
                                            </a>
                                        </li>
                                    @endif
                                    {{-- Download Profile Image --}}
                                    @if (auth()->user()->profile_image_url)
                                        <li class="mb-2" data-url="{{ auth()->user()->profile_image_url }}"
                                            data-filename="{{ auth()->user()->email }}-profile_image"
                                            id="downloadProfileImage">
                                            <a class="dropdown-item" href="javascript:void(0)">
                                                <i class="lni lni-download"></i>
                                                Download Profile Image
                                            </a>
                                        </li>
                                    @endif
                                    {{-- Edit Profile Image --}}
                                    @if (auth()->user()->profile_image_url)
                                        <li class="mb-2">
                                            <a class="dropdown-item" href="{{ route('user.profile.editProfileImage') }}">
                                                <i class="lni lni-pencil"></i>
                                                Edit Profile Image
                                            </a>
                                        </li>
                                    @endif
                                    {{-- Delete Profile Image --}}
                                    @if (auth()->user()->profile_image_url)
                                        <li class="">
                                            <a class="dropdown-item" href="{{ route('user.profile.deleteProfileImage') }}">
                                                <i class="lni lni-trash"></i>
                                                Delete Profile Image
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                        </div>
                        <!-- Single List -->
                        <!-- Single List -->
                        <div class="single-list">
                            <h5 class="title">
                                Resume PDF
                            </h5>
                            {{-- dropdown --}}
                            <div class="dropdown mt-2">
                                <button class="btn dropdown-toggle" type="button" id="resumeOptions"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    View Option
                                </button>
                                <ul class="dropdown-menu p-2 mt-0" aria-labelledby="resumeOptions">
                                    {{-- Upload Resume --}}
                                    @if (!auth()->user()->resume_pdf_url)
                                        <li class="">
                                            <a class="dropdown-item" href="{{ route('user.profile.editResumePdf') }}">
                                                <i class="lni lni-upload"></i>
                                                Upload Now
                                            </a>
                                        </li>
                                    @endif
                                    {{-- View PDF --}}
                                    @if (auth()->user()->resume_pdf_url)
                                        <li class="mb-2">
                                            <a class="dropdown-item" target="_blank"
                                                href="
                                        {{ auth()->user()->resume_pdf_url }}
                                        ">
                                                <i class="lni lni-eye"></i>
                                                View PDF
                                            </a>
                                        </li>
                                    @endif
                                    {{-- Download PDF --}}
                                    @if (auth()->user()->resume_pdf_url)
                                        <li class="mb-2" data-url="{{ auth()->user()->resume_pdf_url }}"
                                            data-filename="{{ auth()->user()->email }}-resume" id="downloadResume">
                                            <a class="dropdown-item" href="javascript:void(0)">
                                                <i class="lni lni-download"></i>
                                                Download PDF
                                            </a>
                                        </li>
                                    @endif
                                    {{-- Edit PDF --}}
                                    @if (auth()->user()->resume_pdf_url)
                                        <li class="mb-2">
                                            <a class="dropdown-item" href="{{ route('user.profile.editResumePdf') }}">
                                                <i class="lni lni-pencil"></i>
                                                Edit Resume
                                            </a>
                                        </li>
                                    @endif
                                    {{-- Delete PDF --}}
                                    @if (auth()->user()->resume_pdf_url)
                                        <li class="">
                                            <a class="dropdown-item" href="{{ route('user.profile.deleteResumePdf') }}">
                                                <i class="lni lni-trash"></i>
                                                Delete Resume
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>

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
            {{-- <div class="single-section skill">
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
            </div> --}}
            <!-- End Single Section -->
            <!-- Start Single Section -->
            {{-- <div class="single-section exprerience">
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
            </div> --}}
            <!-- End Single Section -->
            <!-- Start Single Section -->
            {{-- <div class="single-section education">
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
            </div> --}}
            <!-- End Single Section -->
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // dropdown-toggle on hover
            $('.dropdown-toggle').hover(
                function() {

                    $(this).css({
                        'background-color': '#2042e3',
                        'color': 'white',
                    });

                },
                function() {

                    $(this).css({
                        'background-color': 'white',
                        'color': 'black',
                    });

                });

            // dropdown-item on hover
            $('.dropdown-item').hover(function() {
                $(this).css({
                    'background-color': '#2042e3',
                    'color': 'white',
                    'border-radius': '10px',
                    'transition': '0.3s ease-in-out'
                });
            }, function() {
                $(this).css({
                    'background-color': 'white',
                    'color': 'black',
                    'border-radius': '0px',
                    'transition': '0.4s ease-in-out'
                });
            });

            // download resume pdf
            $('#downloadResume').click(function() {
                var url = $(this).data('url');
                var filename = $(this).data('filename');
                downloadMedia(url, filename);
            });

            // download profile image
            $('#downloadProfileImage').click(function() {
                var url = $(this).data('url');
                var filename = $(this).data('filename');
                downloadMedia(url, filename);

            });
        });

        function downloadMedia(url, filename) {

            // downlaod video
            fetch(url, {
                method: "GET",
            }).then(response => {
                response.blob().then(blob => {
                    let url = window.URL.createObjectURL(blob);
                    let a = document.createElement('a');
                    a.href = url;
                    a.download = filename + "." + url.split('.').pop();
                    a.click();
                });
            });

            // fetch(url, {
            //     method: "GET",
            // }).then(response => {
            //     response.arrayBuffer().then((buffer) => {
            //         const blob = new Blob([buffer], {
            //             type: type
            //         });
            //         const link = document.createElement('a');
            //         link.href = window.URL.createObjectURL(blob);
            //         link.download = filename + "." + ext;
            //         link.click();
            //     });
            // });
        }
    </script>
@endsection
