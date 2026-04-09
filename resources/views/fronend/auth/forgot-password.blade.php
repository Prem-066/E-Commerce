@extends('fronend.partials.app')
@section('title', 'Forgot Password')
@section('contentt')

<section class="login_box_area section_gap" style="margin-top: 100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Reset Password</h3>
                    @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form class="row login_form" action="{{ route('trend-era.password.email') }}" method="post">
                        @csrf
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Enter your registered email" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="primary-btn">Send Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection