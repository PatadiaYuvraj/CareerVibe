@extends('user.layout.auth')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
            <p class="text-center small">Enter your username & password to login</p>
        </div>

        <form class="row g-3" action="{{ route('user.doLogin') }}" method="POST">
            @csrf
            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}" id="email">
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
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>
            <div class="col-12">
                <p class="small mb-0">Don't have account?
                    <a href="{{ route('user.register') }}">Create an account</a>
                </p>
            </div>
        </form>

    </div>
</div>
@endsection