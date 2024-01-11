@extends('front.layout.app') @section('pageTitle', 'Login') @section('content')
<!-- HOME -->
<section class="section-hero overlay inner-page bg-image"
    style="background-image: url('{{ asset('front/images/hero_1.jpg') }}');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold">Sign Up</h1>
                <div class="custom-breadcrumbs">
                    <a href="#">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Sign Up</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5">
                <h2 class="mb-4">Sign Up To JobBoard</h2>
                <form action="{{ route('doRegister') }}" method="POST" class="p-4 border rounded">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="text-black" for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="form-control" placeholder="Full name" />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
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
                    <div class="row form-group mb-4">
                        <div class="col-md-12 mb-3 mb-md-0">
                            <label class="text-black" for="password_confirmation">Re-Type Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Re-type Password" />
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <input type="submit" value="Sign Up" class=" mr-1 btn px-4 btn-primary text-white" />
                            Already have an account! <a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
