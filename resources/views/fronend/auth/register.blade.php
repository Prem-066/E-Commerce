@extends('fronend.partials.app')
@section('title', 'Register')
@section('contentt')

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Customer Registration</h1>
            </div>
        </div>
    </div>
</section>

<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="{{asset('assets/img/login.jpg')}}" alt="">
                    <div class="hover">
                        <h4>Already have an account?</h4>
                        <p>If you are already registered, please login to access your cart and profile.</p>
                        <a class="primary-btn" href="{{ route('login-front') }}">Login Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Create an Account</h3>
                    <form class="row login_form" action="{{ route('trend-era-register.post') }}" method="post" id="contactForm">
                        @csrf
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                            @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection