@extends('company.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">
        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Job</span>
                    <a href="{{ route('company.job.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">

                    <form action="{{ route('company.job.store', $company['id']) }}" method="POST">
                        @csrf
                        <div class="my-3">
                            <label for="email" class="form-label">Company Name</label>
                            <label class="form-control">{{ $company['name'] }}</label>
                        </div>
                        {{-- divide sub profiles in category wise --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Select Job Profile
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-2">
                                @forelse ($sub_profiles as $sub_profile)
                                    <div class="col">
                                        <label for="{{ $sub_profile['name'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $sub_profile['name'] }}"
                                                    type="radio" value="{{ $sub_profile['id'] }}" name="sub_profile_id">
                                            </div>
                                            <div class="form-control">
                                                {{ Str::ucfirst(Str::lower($sub_profile['name'])) }}
                                                {{-- <span class="small">({{ $sub_profile['profile_category']['name'] }})</span> --}}
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
                        <div class="row mb-3">
                            <div class="col">
                                <label for="vacancy" class="form-label">
                                    Vacancy
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="vacancy" class="form-control" value="{{ old('vacancy') }}">
                                @error('vacancy')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="min_salary" class="form-label">Min Salary
                                    <span class="text-danger">*</span></label>
                                <input type="number" name="min_salary" class="form-control"
                                    value="{{ old('min_salary') }}">
                                @error('min_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="max_salary" class="form-label">Max Salary
                                    <span class="text-danger">*</span></label>
                                <input type="number" name="max_salary" class="form-control"
                                    value="{{ old('max_salary') }}">
                                @error('max_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Work Type
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-3">
                                @foreach (Config::get('constants.job.work_type') as $key => $value)
                                    <div class="col">
                                        <label for="{{ $key }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $key }}"
                                                    type="radio" value="{{ $key }}" name="work_type">
                                            </div>
                                            <div class="form-control">
                                                {{ Str::ucfirst(Str::lower($value)) }}
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
                            <label for="email" class="form-label">Select Qualification
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-3">
                                @forelse ($qualifications as $qualification)
                                    <div class="col">
                                        <label for="{{ $qualification['name'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $qualification['name'] }}"
                                                    type="checkbox" value="{{ $qualification['id'] }}"
                                                    name="qualifications[]">
                                            </div>
                                            <div class="form-control">
                                                {{ $qualification['name'] }}
                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col">
                                        <input type="text" class="form-control text-danger" readonly
                                            value="No Qualification Found" required>
                                    </div>
                                @endforelse
                            </div>
                            @error('qualifications')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Select Location
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-3">
                                @forelse ($locations as $location)
                                    <div class="col">
                                        <label for="{{ $location['city'] }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $location['city'] }}"
                                                    type="checkbox" value="{{ $location['id'] }}" name="locations[]">
                                            </div>
                                            <div class="form-control">
                                                {{ $location['city'] }}

                                                @if ($location['state'])
                                                    <span class="small">({{ $location['state'] }})</span>
                                                @endif

                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <div class="col">
                                        <input type="text" class="form-control text-danger" readonly
                                            value="No Location Found" required>
                                    </div>
                                @endforelse
                            </div>
                            @error('locations')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="email" class="form-label">Select Job Type
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-4">
                                @foreach (Config::get('constants.job.job_type') as $key => $value)
                                    <div class="col">
                                        <label for="{{ $key }}" class="input-group mb-3">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" id="{{ $key }}"
                                                    type="radio" value="{{ $key }}" name="job_type">
                                            </div>
                                            <div class="form-control">
                                                {{ $value }}
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
                                                    type="radio" value="{{ $key }}" name="experience_level">
                                            </div>
                                            <div class="form-control">
                                                {{ $value }}
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
                                                    type="radio" value="{{ $key }}" name="experience_type">
                                            </div>
                                            <div class="form-control">
                                                {{ $value }}
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
                        <a href="{{ route('company.job.index') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
    <script></script>
@endsection
