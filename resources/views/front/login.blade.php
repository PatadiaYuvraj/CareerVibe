@extends('front.layout.app') @section('pageTitle', 'Login') @section('content')
<!-- HOME -->
<section class="section-hero overlay inner-page bg-image"
    style="background-image: url('{{ asset('front/images/hero_1.jpg') }}');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold">Login</h1>
                <div class="custom-breadcrumbs">
                    <a href="#">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Log In</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="mb-4">Log In To JobBoard</h2>
                <form action="{{ route('doLogin') }}" method="POST" class="p-4 border rounded">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="text-black" for="email">Email</label>
                            <input type="text" id="email" name="email" value="{{ old('email') }}"
                                class="form-control" placeholder="Email address" />
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="text-black" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password" />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="submit" value="Log In" class="mr-1 btn px-4 btn-primary text-white" />
                            Not have account?<a href="{{ route('register') }}"> Register</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
