@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Job to {{ $company['name'] }}</span>
                    <a href="{{ route('admin.job.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.job.store', $company['id']) }}" method="POST">
                        @csrf
                        <div class="my-3">
                            <label for="email" class="form-label">Company Name</label>
                            <label class="form-control">{{ $company['name'] }}</label>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="vacancy" class="form-label">Vacancy</label>
                                <input type="number" name="vacancy" class="form-control" value="{{ old('vacancy') }}">
                                @error('vacancy')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="min_salary" class="form-label">Min Salary</label>
                                <input type="number" name="min_salary" class="form-control"
                                    value="{{ old('min_salary') }}">
                                @error('min_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="max_salary" class="form-label">Max Salary</label>
                                <input type="number" name="max_salary" class="form-control"
                                    value="{{ old('max_salary') }}">
                                @error('max_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Work Type</label>
                            <div class="row row-cols-3">
                                @foreach ($work_types as $work_type)
                                    <div class="col">
                                        <label for="{{ $work_type }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $work_type }}"
                                                    type="radio" value="{{ $work_type }}" name="work_type">
                                            </div>
                                            <div class="form-control">
                                                {{ Str::ucfirst(Str::lower($work_type)) }}
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
                            <label for="email" class="form-label">Select Job Profile</label>
                            <div class="row row-cols-3">
                                @foreach ($job_profiles as $profile)
                                    <div class="col">
                                        <label for="{{ $profile['profile'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $profile['profile'] }}"
                                                    type="radio" value="{{ $profile['id'] }}" name="profile_id">
                                            </div>
                                            <div class="form-control">
                                                {{ Str::ucfirst(Str::lower($profile['profile'])) }}
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('job_profile_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Qualification</label>
                            <div class="row row-cols-3">
                                @foreach ($qualifications as $qualification)
                                    <div class="col">
                                        <label for="{{ $qualification['qualification'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0"
                                                    id="{{ $qualification['qualification'] }}" type="checkbox"
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
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Location</label>
                            <div class="row row-cols-3">
                                @foreach ($locations as $location)
                                    <div class="col">
                                        <label for="{{ $location['city'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $location['city'] }}"
                                                    type="checkbox" value="{{ $location['id'] }}" name="locations[]">
                                            </div>
                                            <div class="form-control">
                                                {{ $location['city'] }}<span
                                                    class="small">{{ ' (' . $location['state'] . ')' }}</span>
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
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                            <div class="col">
                                <label for="responsibility" class="form-label">Responsibilities</label>
                                <textarea class="form-control" id="responsibility" name="responsibility" rows="3">{{ old('responsibility') }}</textarea>
                            </div>
                        </div>
                        <div class="row row-cols-2 mb-3">
                            <div class="col">
                                <label for="benifits_perks" class="form-label">Benifits & Perks</label>
                                <textarea class="form-control" id="benifits_perks" name="benifits_perks" rows="3">{{ old('benifits_perks') }}</textarea>
                            </div>
                            <div class="col">
                                <label for="other_benifits" class="form-label">Other Benifits</label>
                                <textarea class="form-control" id="other_benifits" name="other_benifits" rows="3">{{ old('other_benifits') }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keywords" class="form-label">Keywords</label>
                            <textarea class="form-control" id="keywords" name="keywords" rows="3">{{ old('keywords') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection
