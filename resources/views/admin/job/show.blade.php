{{-- 
    
array:21 [
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
                <div class="card-header">
                    <nav aria-label="breadcrumb" class="">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.job.index') }}">Jobs</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                    {{-- <a href="{{ route('admin.job.index') }}" class="float-end btn btn-sm btn-primary">Back</a> --}}
                </div>
                <div class="card-body">
                    {{--  --}}

                    <div class="jumbotron">
                        <h1 class="display-5">
                            {{ $company['name'] }}
                        </h1>
                        <p class="lead position-relative">
                            <a href="{{ route('admin.company.toggleVerified', [$company['id'], $company['is_verified']]) }}"
                                class="badge bg-{{ $company['is_verified'] ? 'success' : 'danger' }}">
                                {{ $company['is_verified'] ? 'Verified' : 'Not Verified' }}
                            </a>
                        </p>
                        <p class="lead">Created At :
                            @if ($company['created_at'])
                                {{ date('d-m-Y', strtotime($company['created_at'])) }}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </p>
                        <p class="lead">
                            <a class="btn btn-outline-primary btn"
                                href="{{ route('admin.company.edit', $company['id']) }}">Edit</a>
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job</th>
                                        {{-- <th>Job Profile</th> --}}
                                        <th>Is Verified</th>
                                        <th>Is Featured</th>
                                        <th>Is Active</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($company['jobs'] as $job)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $job['job_profile'] }}</td> --}}
                                            <td>
                                                <a href="{{ route('admin.job.toggleVerified', [$job['id'], $job['is_verified']]) }}"
                                                    class="badge bg-{{ $job['is_verified'] ? 'success' : 'danger' }}">
                                                    {{ $job['is_verified'] ? 'Verified' : 'Not Verified' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.job.toggleFeatured', [$job['id'], $job['is_featured']]) }}"
                                                    class="badge bg-{{ $job['is_featured'] ? 'success' : 'danger' }}">
                                                    {{ $job['is_featured'] ? 'Featured' : 'Not Featured' }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.job.toggleActive', [$job['id'], $job['is_active']]) }}"
                                                    class="badge bg-{{ $job['is_active'] ? 'success' : 'danger' }}">
                                                    {{ $job['is_active'] ? 'Active' : 'Not Active' }}
                                                </a>
                                            </td>
                                            {{-- <td>
                                                <a href="{{ route('admin.job.edit', $job['id']) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <a href="{{ route('admin.job.delete', $job['id']) }}"
                                                    class="btn btn-sm btn-danger">Delete</a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--  --}}
                </div>
            </div>
        </section>

    </main>
@endsection
