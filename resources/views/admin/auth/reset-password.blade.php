@extends('admin.layout.auth')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">
                    Reset Password
                </h5>
                <p class="text-center small">
                    Enter your new password
                </p>
            </div>
            <form class="row g-3" action="{{ route('admin.doResetPassword', ['token' => $token]) }}" method="POST">
                @csrf
                <div class="col-12">
                    <label for="password" class="form-label">
                        New Password
                    </label>
                    <input type="password" name="password" class="form-control" placeholder="Enter new password"
                        value="{{ old('password') }}" id="password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="confirm_password" class="form-label">
                        Confirm Password
                    </label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password"
                        value="{{ old('confirm_password') }}" id="confirm_password">
                    @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">
                        Reset Password
                    </button>
                </div>
                <div class="col-12">
                    <p class="small mb-0">

                        <a wire:navigate href="{{ route('admin.login') }}">Login?</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
@endsection
