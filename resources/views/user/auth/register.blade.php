@extends('user.layout.auth')
@section('title', 'Register| Career Vibe')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                <p class="text-center small">Enter your personal details to create account</p>
            </div>
            <form class="row g-2" action="{{ route('user.doRegister') }}" method="POST">
                @csrf
                <div class="col-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name"
                        class="form-control
                        @error('name') is-invalid @enderror
                    "
                        placeholder="Enter Email" value="{{ old('name') }}" id="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email"
                        class="form-control
                        @error('email') is-invalid @enderror    
                    "
                        placeholder="Enter Email" value="{{ old('email') }}" id="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password"
                        class="form-control
                    @error('password') is-invalid @enderror
                    "
                        id="password" placeholder="Enter Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="confirm_password" class="form-label">Re-Type Password</label>
                    <input type="password" name="confirm_password"
                        class="form-control
                    @error('confirm_password') is-invalid @enderror    
                    "
                        id="confirm_password" placeholder="Confirm Password">
                    @error('confirm_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">
                        Create Account</button>
                </div>
                <div class="col-12">
                    <p class="small mb-1">Already have an account?
                        <a href="{{ route('user.login') }}">Log in</a>
                    </p>
                    <p class="small mb-1">

                        <a href="{{ route('company.register') }}">
                            Want to register as Company?
                        </a>
                    </p>
                </div>
            </form>

        </div>
    </div>
@endsection
