{{--  
    
array:2 [▼ // resources/views/admin/job/edit.blade.php
  "job" => array:21 [▼
    "id" => 1
    "company_id" => 1
    "profile_id" => 3
    "vacancy" => 12
    "min_salary" => 25000
    "max_salary" => 50000
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
    "updated_at" => "2024-01-15T10:52:57.000000Z"
    "profile" => array:4 [▶]
    "company" => array:12 [▶]
    "qualifications" => array:2 [▼
      0 => array:5 [▼
        "id" => 1
        "qualification" => "MCA"
        "created_at" => null
        "updated_at" => null
        "pivot" => array:2 [▶]
      ]
      1 => array:5 [▼
        "id" => 2
        "qualification" => "BCA"
        "created_at" => null
        "updated_at" => null
        "pivot" => array:2 [▶]
      ]
    ]
    "locations" => array:2 [▶]
  ]
  "qualifications" => array:2 [▼
    0 => array:4 [▼
      "id" => 1
      "qualification" => "MCA"
      "created_at" => null
      "updated_at" => null
    ]
    1 => array:4 [▼
      "id" => 2
      "qualification" => "BCA"
      "created_at" => null
      "updated_at" => null
    ]
  ]
]
    
--}}
@foreach ($job['qualifications'] as $item)
    @php
        $qjData[] = $item['qualification'];
    @endphp
@endforeach
{{-- location --}}
@foreach ($job['locations'] as $item)
    @php
        $ljData[] = $item['city'];
    @endphp
@endforeach
@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        {{-- @dd($job['qualifications']) --}}
        {{-- @dd(['job' => $job, 'qualifications' => $qualifications, 'locations' => $locations, 'profiles' => $profiles]) --}}

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Edit Job</span>
                    <a href="{{ route('admin.job.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.job.update', $job['id']) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Job Profile</label>
                            <select name="profile_id" id="profile_id" class="form-control">
                                <option value="">Select Job Profile</option>
                                @foreach ($profiles as $profile)
                                    <option value="{{ $profile['id'] }}" @if ($profile['id'] == $job['profile_id']) selected @endif>
                                        {{ $profile['profile'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- vacancies --}}
                        <div class="mb-3">
                            <label for="vacancy" class="form-label">Vacancy</label>
                            <input type="number" name="vacancy" id="vacancy" class="form-control"
                                value="{{ $job['vacancy'] }}">
                        </div>

                        {{-- min salary --}}
                        <div class="mb-3">
                            <label for="min_salary" class="form-label">Min Salary</label>
                            <input type="number" name="min_salary" id="min_salary" class="form-control"
                                value="{{ $job['min_salary'] }}">
                        </div>

                        {{-- max salary --}}

                        <div class="mb-3">
                            <label for="max_salary" class="form-label">Max Salary</label>
                            <input type="number" name="max_salary" id="max_salary" class="form-control"
                                value="{{ $job['max_salary'] }}">
                        </div>
                        {{-- ('work_type', ['REMOTE', "WFO", "HYBRID"])  --}}
                        <div class="mb-3">
                            <label for="work_type" class="form-label">Work Type</label>
                            <select name="work_type" id="work_type" class="form-control">
                                <option value="">Select Work Type</option>
                                <option value="REMOTE" @if ($job['work_type'] == 'REMOTE') selected @endif>REMOTE</option>
                                <option value="WFO" @if ($job['work_type'] == 'WFO') selected @endif>WFO</option>
                                <option value="HYBRID" @if ($job['work_type'] == 'HYBRID') selected @endif>HYBRID</option>
                            </select>
                        </div>
                        {{-- qualification  --}}
                        {{-- in_array($item['qualification'], $qjData) ? $item['qualification'] : '' --}}
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Qualification</label>
                            <div class="row row-cols-3">
                                @foreach ($qualifications as $qualification)
                                    <div class="col">
                                        <label for="{{ $qualification['qualification'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0"
                                                    id="{{ $qualification['qualification'] }}" type="checkbox"
                                                    @if (in_array($qualification['qualification'], $qjData)) checked @endif
                                                    value="{{ $qualification['id'] }}" name="qualifications[]">
                                            </div>
                                            <div class="form-control">
                                                {{ $qualification['qualification'] }}
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('qualifications')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- location --}}

                        <div class="mt-3">
                            <label for="email" class="form-label">Select Location</label>
                            <div class="row row-cols-3">
                                @foreach ($locations as $location)
                                    <div class="col">
                                        <label for="{{ $location['city'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $location['city'] }}"
                                                    type="checkbox" @if (in_array($location['city'], $ljData)) checked @endif
                                                    value="{{ $location['id'] }}" name="locations[]">
                                            </div>
                                            <div class="form-control">
                                                {{ $location['city'] }}
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('locations')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row row-cols-2 mb-3">
                            <div class="col">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $job['description']) }}</textarea>
                            </div>
                            <div class="col">
                                <label for="responsibility" class="form-label">Responsibilities</label>
                                <textarea class="form-control" id="responsibility" name="responsibility" rows="3">{{ old('responsibility', $job['responsibility']) }}</textarea>
                            </div>
                        </div>
                        <div class="row row-cols-2 mb-3">
                            <div class="col">
                                <label for="benifits_perks" class="form-label">Benifits & Perks</label>
                                <textarea class="form-control" id="benifits_perks" name="benifits_perks" rows="3">{{ old('benifits_perks', $job['benifits_perks']) }}</textarea>
                            </div>
                            <div class="col">
                                <label for="other_benifits" class="form-label">Other Benifits</label>
                                <textarea class="form-control" id="other_benifits" name="other_benifits" rows="3">{{ old('other_benifits', $job['other_benifits']) }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keywords" class="form-label">Keywords</label>
                            <textarea class="form-control" id="keywords" name="keywords" rows="3">{{ old('keywords', $job['keywords']) }}</textarea>
                        </div>





                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
