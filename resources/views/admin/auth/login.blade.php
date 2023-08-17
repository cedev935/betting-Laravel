@extends('admin.layouts.login')
@section('title','Admin Login')
@push('css')
    <style>
        .logoWidth-64 img{
            width: 64px!important;
        }
    </style>
@endpush
@section('content')
    <div class="p-3">
        <div class="text-center logoWidth-64">
            <img src=" {{getFile(config('location.logoIcon.path').'favicon.png')}}" alt="wrapkit">
        </div>
        <h2 class="mt-3 text-center">@lang('Admin Login')</h2>

        <form method="POST" action="{{ route('admin.login') }}" aria-label="{{ __('Login') }}">
            @csrf
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="text-dark" for="email">@lang('Email Or Username')</label>
                        <input id="username" type="text"
                               class="form-control
                                @error('username') is-invalid @enderror
                                @error('email') is-invalid @enderror
                            " name="username"
                               value="{{old('username')}}"  autocomplete="off" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="text-dark" for="pwd">@lang('Password')</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" value="{{old('password')}}" autocomplete="off">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-block btn-dark">@lang('Sign In')</button>
                </div>
                <div class="col-lg-12 text-center mt-5">
                    <a href="{{route('admin.password.request')}}" class="text-danger">{{trans('Forgot Your Password?')}}</a>
                </div>
            </div>
        </form>
    </div>
@endsection
