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
                            <img src="{{url('assets/backend/images/big/icon.png')}}" alt="wrapkit">
                        </div>
                        <h2 class="mt-3 text-center">@lang('Reset Password')</h2>


                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif


                        @error('token')
                        <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @enderror




                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="text" name="token" value="{{ $token }}">
                            <input type="text" name="email" value="{{ $email }}">
                            <div class="row">
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="password" class="text-md-right">{{ __('Password') }}</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label for="password-confirm" class="text-md-right">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="col-sm-12 mt-5">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-block btn-dark btn-sm">@lang('Reset Password')</button>
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
