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
                        <div class="mb-3">
                            <label for="email" class="form-label">Company Name</label>
                            <label class="form-control">{{ $company['name'] }}</label>
                        </div>
                        <div class="row row-cols-2 mb-3">
                            <div class="">
                                <label for="sub_profile_id" class="form-label">Select Job Profile
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="row row-cols-2">
                                    <select class="job-profile-selector form-select" name="sub_profile_id"
                                        id="sub_profile_id" data-placeholder="Select Job Profile">
                                        <option></option>
                                        @foreach ($profile_categories as $category)
                                            <optgroup label="{{ $category['name'] }}">
                                                @foreach ($category['sub_profiles'] as $sub_profile)
                                                    <option value="{{ $sub_profile['id'] }}">
                                                        {{ Str::ucfirst(Str::lower($sub_profile['name'])) }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                @error('sub_profile_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="">
                                <label for="email" class="form-label">Select Job Type
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="row row-cols-4">
                                    <select class="job-type-selector form-select" name="job_type" id="job_type"
                                        data-placeholder="Select Job Type">
                                        <option></option>
                                        @foreach (Config::get('constants.job.job_type') as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('work_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2 mb-3">
                            <div class="col">
                                <label for="email" class="form-label">Select Work Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="work-type-selector form-control" name="work_type" id="work_type"
                                    data-placeholder="Select Work Type">
                                    <option></option>
                                    @foreach (Config::get('constants.job.work_type') as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('work_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="vacancy" class="form-label">
                                    Vacancy
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="vacancy" class="form-control" value="{{ old('vacancy') }}"
                                    placeholder="Enter Vacancy">
                                @error('vacancy')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row row-cols-2 mb-3">

                            <div class="col">
                                <label for="min_salary" class="form-label">Min Salary
                                    <span class="text-danger">*</span></label>
                                <input type="number" name="min_salary" class="form-control" placeholder="Enter Min Salary"
                                    value="{{ old('min_salary') }}">
                                @error('min_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="max_salary" class="form-label">Max Salary
                                    <span class="text-danger">*</span></label>
                                <input type="number" name="max_salary" class="form-control" placeholder="Enter Max Salary"
                                    value="{{ old('max_salary') }}">
                                @error('max_salary')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Select Qualification
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-3">
                                <select class="qualifications-selector form-select" name="qualifications[]"
                                    id="qualifications" data-placeholder="Select Qualifications" multiple>
                                    <option></option>
                                    @foreach ($qualifications as $qualification)
                                        <option value="{{ $qualification['id'] }}">
                                            {{ $qualification['name'] }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            @error('qualifications')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Select Location
                                <span class="text-danger">*</span>
                            </label>
                            <div class="row row-cols-3">
                                <select class="locations-selector form-select" name="locations[]" id="locations" multiple
                                    data-placeholder="Select Locations">
                                    <option></option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location['id'] }}">
                                            {{ $location['city'] }}
                                            @if ($location['state'])
                                                <span class="small">({{ $location['state'] }})</span>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('locations')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row row-cols-2 mb-3">

                            <div class="">
                                <label for="experience_level" class="form-label">Select Experience Level</label>
                                <select class="experience-level-selector form-select" name="experience_level"
                                    id="experience_level" data-placeholder="Select Experience Level">
                                    <option></option>
                                    @foreach (Config::get('constants.job.experience_level') as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('experience_level')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="">
                                <label for="experience_type" class="form-label">Select Experience Type</label>
                                <div class="row row-cols-4">
                                    <select class="experience-type-selector form-select" name="experience_type"
                                        id="experience_type" data-placeholder="Select Experience Type">
                                        <option></option>
                                        @foreach (Config::get('constants.job.experience_type') as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('experience_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col">
                                <label for="description" class="form-label">
                                    Description
                                </label>
                                <textarea class="form-control" id="description" name="description" rows="5"
                                    placeholder="Enter Job Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col">
                                <label for="responsibility" class="form-label">
                                    Responsibilities
                                </label>
                                <textarea class="form-control" id="responsibility" name="responsibility" rows="5"
                                    placeholder="Enter Job Responsibilities">{{ old('responsibility') }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col">
                                <label for="benifits_perks" class="form-label">
                                    Benifits & Perks
                                </label>
                                <textarea class="form-control" id="benifits_perks" name="benifits_perks" rows="5"
                                    placeholder="Enter Job Benifits & Perks">{{ old('benifits_perks') }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col">
                                <label for="other_benifits" class="form-label">
                                    Other Benifits
                                </label>
                                <textarea class="form-control" id="other_benifits" name="other_benifits" rows="5"
                                    placeholder="Enter Other Benifits">{{ old('other_benifits') }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keywords" class="form-label">
                                Keywords
                            </label>
                            <textarea class="form-control" id="keywords" name="keywords" rows="5" placeholder="Enter Keywords">{{ old('keywords') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('admin.job.index') }}" class="btn btn-danger">Cancel</a>
                    </form>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.work-type-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

            $('.job-profile-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

            $('.qualifications-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
            });

            $('.locations-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                // close on escape key
                closeOnSelect: false,

            });

            $('.job-type-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

            $('.experience-level-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

            $('.experience-type-selector').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: true,
            });

        });
    </script>
@endsection
