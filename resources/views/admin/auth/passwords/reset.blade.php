@extends('admin.layouts.login')
@section('title','Admin Reset Password')

@section('content')
    <div class="p-3">
        <div class="text-center">
            <img src=" {{getFile(config('location.logoIcon.path').'favicon.png')}}" alt="wrapkit">
        </div>
        <h2 class="mt-3 text-center">@lang('Reset Password')</h2>

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">


            <div class="row mb-5">

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="text-dark">@lang('Password')</label>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        @error('password')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-dark">@lang('Confirm Password')</label>
                        <input id="password" type="password" class="form-control" name="password_confirmation" required autocomplete="current-password">
                    </div>

                </div>

                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-block btn-dark">@lang('Reset Password')</button>
                </div>

            </div>
        </form>
    </div>
@endsection


@push('css')
    <style>
        .auth-wrapper .auth-box {
            min-width: 800px;
        }
    </style>
@endpush

