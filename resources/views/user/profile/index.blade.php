@extends('user.profile.layout.app')
@section('title', 'Your Profile')
@section('profile-content')
    <div class="col-lg-8 col-12">
        <div class="inner-content">
            <!-- Start Personal Top Content -->
            <div class="personal-top-content">
                <div class="single-section">
                    <div class="content-right">
                        <h5 class="title-main">
                            <i class="lni lni-user mr-2"></i>
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
                            <h5 class="title">
                                Email Address
                            </h5>
                            <p>
                                @if (auth()->user()->email)
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
                            <i class="lni lni-phone  mr-2"></i>
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
                <h4>
                    <i class="lni lni-briefcase mr-2"></i>
                    Headline
                </h4>
                <p class="text-dark">
                    {{ auth()->user()->headline }}
                </p>
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section">
                <h4>
                    <i class="lni lni-graduation mr-2"></i>
                    Education
                </h4>
                <p class="text-dark">
                    {{ auth()->user()->education }}
                </p>
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section">
                <h4>
                    <i class="lni lni-heart mr-2"></i>
                    Interest
                </h4>
                <p class="text-dark">
                    {{ auth()->user()->interest }}
                </p>
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section">
                <h4>
                    <i class="lni lni-heart-filled text-danger mr-2"></i>
                    Hobby
                </h4>
                <p class="text-dark">
                    {{ auth()->user()->hobby }}
                </p>
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section">
                <h4>
                    <i class="lni lni-user mr-2"></i>
                    About
                </h4>
                <p class="text-dark">
                    {{ auth()->user()->about }}
                </p>
            </div>
            <!-- End Single Section -->
            <!-- Start Single Section -->
            <div class="single-section">
                <h4>
                    <i class="lni lni-briefcase mr-2"></i>
                    Experience
                </h4>
                <p class="text-dark">
                    {{ auth()->user()->experience }}
                </p>

            </div>
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
    </script>
@endsection
