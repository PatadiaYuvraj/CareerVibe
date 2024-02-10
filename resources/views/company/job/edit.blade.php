@foreach ($job['qualifications'] as $item)
    @php
        $qjData[] = $item['name'];
    @endphp
@endforeach
@foreach ($job['locations'] as $item)
    @php
        $ljData[] = $item['city'];
    @endphp
@endforeach

@extends('company.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header">
                    <span class="h3 text-black">
                        Edit Job
                    </span>

                    <a href="{{ route('company.job.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('company.job.update', $job['id']) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Select Job Profile</label>
                            <div class="row row-cols-2">
                                @forelse ($sub_profiles as $profile)
                                    <div class="col">
                                        <label for="{{ $profile['name'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $profile['name'] }}"
                                                    type="radio" value="{{ $profile['id'] }}" name="sub_profile_id"
                                                    @if ($profile['id'] == $job['sub_profile_id']) checked @endif>
                                            </div>
                                            <div class="form-control">
                                                {{ Str::ucfirst(Str::lower($profile['name'])) }}

                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col">
                                        <input type="text" class="text-danger form-control" readonly
                                            value="No Profile Found" required>
                                    </div>
                                @endforelse
                            </div>
                            @error('sub_profile_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row row-cols-3 mb-3">
                            <div class="col">
                                <label for="vacancy" class="form-label">Vacancy</label>
                                <input type="number" name="vacancy" id="vacancy" class="form-control"
                                    value="{{ $job['vacancy'] }}">
                                @error('vacancy')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="min_salary" class="form-label">Min Salary</label>
                                <input type="number" name="min_salary" id="min_salary" class="form-control"
                                    value="{{ $job['min_salary'] }}">
                                @error('min_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="max_salary" class="form-label">Max Salary</label>
                                <input type="number" name="max_salary" id="max_salary" class="form-control"
                                    value="{{ $job['max_salary'] }}">
                                @error('max_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Work Type</label>
                            <div class="row row-cols-3">
                                @foreach (Config::get('constants.job.work_type') as $key => $value)
                                    <div class="col">
                                        <label for="{{ $key }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $key }}"
                                                    type="radio" value="{{ $key }}" name="work_type"
                                                    @if ($key == $job['work_type']) checked @endif>
                                            </div>
                                            <div class="form-control">
                                                <small>{{ $value }} </small>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>company
                            @error('work_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Qualification</label>
                            <div class="row row-cols-3">
                                @foreach ($qualifications as $qualification)
                                    <div class="col">
                                        <label for="{{ $qualification['name'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $qualification['name'] }}"
                                                    type="checkbox" @if (in_array($qualification['name'], $qjData)) checked @endif
                                                    value="{{ $qualification['id'] }}" name="qualifications[]">
                                            </div>
                                            <div class="form-control">
                                                {{ $qualification['name'] }}
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('qualifications')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Job Type</label>
                            <div class="row row-cols-4">
                                @foreach (Config::get('constants.job.job_type') as $key => $value)
                                    <div class="col">
                                        <label for="{{ $key }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $key }}"
                                                    type="radio" value="{{ $key }}" name="job_type"
                                                    @if ($key == $job['job_type']) checked @endif>
                                            </div>
                                            <div class="form-control">
                                                <small>{{ $value }} </small>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('work_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Experience Level</label>
                            <div class="row row-cols-2">
                                @foreach (Config::get('constants.job.experience_level') as $key => $value)
                                    <div class="col">
                                        <label for="{{ $key }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $key }}"
                                                    type="radio" value="{{ $key }}" name="experience_level"
                                                    @if ($key == $job['experience_level']) checked @endif>
                                            </div>
                                            <div class="form-control">
                                                <small>{{ $value }} </small>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('experience_level')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Experience Type</label>
                            <div class="row row-cols-7">
                                @foreach (Config::get('constants.job.experience_type') as $key => $value)
                                    <div class="col">
                                        <label for="{{ $key }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $key }}"
                                                    type="radio" value="{{ $key }}" name="experience_type"
                                                    @if ($key == $job['experience_type']) checked @endif>
                                            </div>
                                            <div class="form-control">
                                                <small>{{ $value }} </small>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('experience_type')
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
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('company.job.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
