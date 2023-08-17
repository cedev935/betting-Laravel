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
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                            @endif
                            <img src="{{url('assets/backend/images/big/icon.png')}}" alt="wrapkit">
                        </div>
                        <h2 class="mt-3 text-center">@lang('Reset Password')</h2>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark">E-Mail Address</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required autocomplete="email" autofocus>
                                        @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-block btn-dark btn-sm">@lang('Send Password Reset Link')</button>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-center mt-5">
                                        <p>@lang("Don't have an account?") <a href="{{ route('register') }}" class="text-danger">@lang('Sign Up')</a></p>
                                    </div>
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
