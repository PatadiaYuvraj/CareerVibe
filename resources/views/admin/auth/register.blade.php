@extends('admin.layout.auth')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                <p class="text-center small">Enter your personal details to create account</p>
            </div>
            <form class="row g-3" action="{{ route('admin.doRegister') }}" method="POST">
                @csrf
                <div class="col-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Email"
                        value="{{ old('name') }}" id="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter Email"
                        value="{{ old('email') }}" id="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="confirm_password" class="form-label">Re-Type Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password"
                        placeholder="Confirm Password">
                    @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">
                        Create Account</button>
                </div>
                <div class="col-12 text-center">
                    <p class="small mb-0">Already have an account?
                        <a wire:navigate href="{{ route('admin.login') }}">Log in</a>
                    </p>
                    <p class="small mb-0">
                        <a wire:navigate href="{{ route('user.register') }}">User</a> |
                        <a wire:navigate href="{{ route('company.register') }}">Company</a>
                    </p>
                </div>
            </form>

        </div>
    </div>
@endsection
