<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    @include('user.layouts.head')
</head>
<body>
@include('user.layouts.notification')
    <section class="login">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
             style="background:url({{url('assets/backend/images/big/auth-bg.jpg')}}) no-repeat center center;">
            <div class="auth-box row">
                <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{url('assets/backend/images/big/3.jpg')}});">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <div class="text-center">
                            <img src=" {{url('assets/backend/images/big/icon.png')}}" alt="wrapkit">
                        </div>
                        <h2 class="mt-3 text-center">@lang('Sign In')</h2>
                        <p class="text-center">@lang('Enter your email address and password to access admin panel.')</p>
                        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="uname">@lang('Email Or Username')</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pwd">@lang('Password')</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">@lang('Sign In')</button>
                                </div>
                                <div class="col-lg-12 text-center mt-5">
                                    <p><a href="{{ route('password.request') }}">@lang("Forgot Your Password?")</a></p>
                                    <p>@lang("Don't have an account?") <a href="{{ route('register') }}" class="text-danger">@lang('Sign Up')</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('user.layouts.footer')
<script src="{{ asset('assets/backend/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/backend/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/app-style-switcher.js')}}"></script>
</body>
