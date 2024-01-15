{{-- 
    
"job" => [
  "id" => 1
  "company_id" => 1
  "profile_id" => 3
  "vacancy" => 12
  "min_salary" => 12
  "max_salary" => 12
  "description" => "Description"
  "responsibility" => "Responsibilities"
  "benifits_perks" => "Benifits & Perks"
  "other_benifits" => "Other Benifits"
  "is_verified" => 0
  "is_featured" => 0
  "is_active" => 1
  "keywords" => "Keywords"
  "work_type" => "WFO"
  "created_at" => "2024-01-13T12:19:46.000000Z"
  "updated_at" => "2024-01-13T12:27:33.000000Z"
  "profile" => array:4 [
    "id" => 3
    "profile" => "Flutter Developer"
    "created_at" => "2024-01-13T12:18:41.000000Z"
    "updated_at" => "2024-01-13T12:18:41.000000Z"
  ]
  "company" => array:12 [
    "id" => 1
    "is_verified" => 1
    "userType" => "COMPANY"
    "name" => "Microsoft"
    "email" => "hr.microsoft@gmail.com"
    "website" => "https://microsoft.com"
    "address_line_1" => "America"
    "address_line_2" => "1"
    "linkedin_profile" => "1"
    "description" => "1"
    "created_at" => "2024-01-13T12:19:15.000000Z"
    "updated_at" => "2024-01-13T12:19:22.000000Z"
  ]
  "qualifications" => array:2 [
    0 => array:5 [
      "id" => 1
      "qualification" => "MCA"
      "created_at" => null
      "updated_at" => null
    ]
    1 => array:5 [
      "id" => 2
      "qualification" => "BCA"
      "created_at" => null
      "updated_at" => null
    ]
  ]
  "locations" => array:2 [
    0 => array:8 [
      "id" => 1
      "city" => "Ahmedabad"
      "state" => "Gujarat"
      "country" => "India"
      "pincode" => 360001
      "created_at" => "2024-01-13T12:18:21.000000Z"
      "updated_at" => "2024-01-13T12:18:21.000000Z"
    ]
    1 => array:8 [
      "id" => 2
      "city" => "Mumbai"
      "state" => "Maharashtra"
      "country" => "India"
      "pincode" => 360003
      "created_at" => "2024-01-13T12:18:29.000000Z"
      "updated_at" => "2024-01-13T12:18:29.000000Z"
    ]
  ]
]

--}}
@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header ">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.job.index') }}">Jobs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="col pt-3">
                        <h1 class="display-5">
                            {{-- {{ $job['pr'] }} --}}
                            {{ $job['profile']['profile'] }}
                        </h1>
                        <p class="lead position-relative">
                            <a href="{{ route('admin.job.toggleVerified', [$job['id'], $job['is_verified']]) }}"
                                class="badge bg-{{ $job['is_verified'] ? 'success' : 'danger' }}">
                                {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }}
                            </a>
                        </p>
                        <p class="lead">Created At :
                            @if ($job['created_at'])
                                {{ date('d-m-Y', strtotime($job['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn" href="{{ route('admin.job.edit', $job['id']) }}">Edit</a>
                        </p>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Company
                            </h5>
                            <h6 class="">
                                {{ $job['company']['name'] }}
                            </h6>
                            {{-- email --}}
                            <h6 class="">
                                {{ $job['company']['email'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Qualifications
                                </h5>
                                <h6 class="">
                                    @foreach ($job['qualifications'] as $qualification)
                                        <span class="badge bg-primary">{{ $qualification['qualification'] }}</span>
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Locations
                                </h5>
                                <h6 class="">
                                    @foreach ($job['locations'] as $location)
                                        <span class="badge bg-primary">{{ $location['city'] }}</span>
                                    @endforeach
                                </h6>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Vacancies
                                </h5>
                                <h6 class="">
                                    {{ $job['vacancy'] }}
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Salary Package
                                </h5>
                                <h6 class="">
                                    {{ $job['min_salary'] }} - {{ $job['max_salary'] }}
                                </h6>
                            </div>
                        </div>
                        <div class="col" style="">
                            <div class="card-body">
                                <h5 class="card-title">
                                    Work Type
                                </h5>
                                <h6 class="">
                                    {{ $job['work_type'] }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Description
                            </h5>
                            <h6 class="">
                                {{ $job['description'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Responsibilities
                            </h5>
                            <h6 class="">
                                {{ $job['responsibility'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Benifits & Perks
                            </h5>
                            <h6 class="">
                                {{ $job['benifits_perks'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Other Benifits
                            </h5>
                            <h6 class="">
                                {{ $job['other_benifits'] }}
                            </h6>
                        </div>
                    </div>
                    <hr />
                    <div class="col" style="">
                        <div class="card-body">
                            <h5 class="card-title">
                                Keywords
                            </h5>
                            <h6 class="">
                                {{ $job['keywords'] }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection