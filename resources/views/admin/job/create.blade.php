{{-- 

    $company = Company::where('id', $company_id)->get()->toArray();
    if (!$company) {
        return redirect()->back()->with("warning", "Company is not found");
    }
    $company = $company[0];
    if ($company['is_verified'] == 0) {
        return redirect()->back()->with("warning", "Company is not verified");
    }
    $job_profiles = JobProfile::all()->toArray();
    $locations = Location::all()->toArray();
    $qualifications = Qualification::all()->toArray();

    dd($company, $job_profiles, $locations, $qualifications);
    return view('admin.job.create', compact('company', 'job_profiles', 'locations', 'qualifications'));

--}}
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
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.job.store', $company['id']) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Company Name</label>
                                    <span class="form-control">{{ $company['name'] }}</span>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Select Job Profile</label>
                                    <select class="form-select" aria-label="Default select example" name="profile_id">
                                        <option disabled selected required="">Select any one profile
                                        </option>
                                        @foreach ($job_profiles as $profile)
                                            <option value="{{ $profile['id'] }}">{{ $profile['profile'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('profile_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Select Qualification</label>
                                    <div class="row row-cols-3">
                                        @foreach ($qualifications as $qualification)
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox"
                                                            value="{{ $qualification['id'] }}" name="q[]">
                                                    </div>
                                                    <span class="form-control">{{ $qualification['qualification'] }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Select Location</label>
                                    <div class="row row-cols-3">
                                        @foreach ($locations as $location)
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox"
                                                            value="{{ $location['id'] }}" name="q[]">
                                                    </div>
                                                    <span class="form-control">
                                                        {{ $location['city'] . ', ' . $location['state'] . '(' . $location['country'] . ')' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="email" class="form-label">Company Email address</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <label for="email" class="form-label">Company Email address</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <label for="email" class="form-label">Company Email address</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
