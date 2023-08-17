@extends($theme.'layouts.app')
@section('title','Login')
@section('content')
    <section class="login-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-lg-6 p-0">
                    <div class="text-box h-100">
                        <div class="overlay h-100">
                            <div class="text">
                                <h2>@lang('Sign in to your account')</h2>
                                <a href="{{route('home')}}">@lang('back to home')</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-wrapper d-flex align-items-center h-100">
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <h4>@lang('Login here')</h4>
                                </div>
                                <div class="input-box col-12">
                                    <input type="text" class="form-control" name="username"
                                           placeholder="@lang('Email Or Username')"/>
                                    @error('username')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('email')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="input-box col-12">
                                    <input type="password" class="form-control" name="password"
                                           placeholder="@lang('Password')"/>
                                    @error('password')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if(basicControl()->reCaptcha_status_login)
                                    <div class="box mb-4 form-group">
                                        {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                        {!! NoCaptcha::display(['data-theme' => 'dark']) !!}
                                        @error('g-recaptcha-response')
                                        <span class="text-danger mt-1">@lang($message)</span>
                                        @enderror
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="links">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="remember" {{ old('remember') ? 'checked' : '' }}
                                                id="flexCheckDefault"/>
                                            <label
                                                class="form-check-label"
                                                for="flexCheckDefault">
                                                @lang('Remember Me')
                                            </label>
                                        </div>
                                        <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-custom w-100">@lang('sign in')</button>
                            <div class="bottom">
                                @lang("Don't have an account?")

                                <a href="{{ route('register') }}">@lang('Create account')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .modal .text-box,
        .login-section .text-box {
            background: url({{getFile(config('location.logo.path').'loginImage.png')}});
            background-size: cover;
        }
    </style>
@endpush
