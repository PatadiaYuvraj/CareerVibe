@extends('admin.layout.app')
@section('pageTitle', 'Dashboard | Admin')
@section('content')
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="card">
                <div class="card-header pagetitle">
                    <span class="h3 text-black">Add Location</span>
                    <a href="{{ route('admin.location.index') }}" class="float-end btn btn-sm btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">

                            {{-- Edit Location form --}}
                            <form action="{{ route('admin.location.update', $location['id']) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ old('city', $location['city']) }}">
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" name="state" class="form-control"
                                        value="{{ old('state', $location['state']) }}">
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control"
                                        value="{{ old('country', $location['country']) }}">
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="pincode" class="form-label">Pin Code</label>
                                    <input type="text" name="pincode" class="form-control"
                                        value="{{ old('pincode', $location['pincode']) }}">
                                    @error('pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
