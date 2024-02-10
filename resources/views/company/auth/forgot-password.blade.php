@extends('company.layout.auth')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">
                    Forgot Password
                </h5>
                <p class="text-center small">
                    Enter your email to reset password
                </p>
            </div>

            <form class="row g-3" action="{{ route('company.doForgotPassword') }}" method="POST">
                @csrf
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email"
                        class="form-control
                    @error('email') is-invalid @enderror
                        "
                        placeholder="Enter Email" value="{{ old('email') }}" id="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">
                        Send Password Reset Link
                    </button>
                </div>
                <div class="col-12">
                    <p class="small mb-0">
                        <a href="{{ route('company.login') }}">Login?</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
@endsection
