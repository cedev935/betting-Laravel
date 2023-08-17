@extends('admin.layouts.login')
@section('title','Admin Reset Password')

@section('content')
    <div class="p-3">
        <div class="text-center">
            <img src=" {{getFile(config('location.logoIcon.path').'favicon.png')}}" alt="wrapkit">
        </div>
        <h2 class="mt-3 text-center">@lang('Reset Password')</h2>

        <form method="POST" action="{{ route('admin.password.email') }}" class=" mt-4">
            @csrf
            <div class="row">

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="text-dark" for="pwd">@lang('Enter Email Address')</label>
                        <input  type="email" class="form-control" name="email" value="{{old('email')}}" required autocomplete="off">
                        @error('email')
                        <p class="text-danger" >{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-block btn-dark">@lang('Send to reset link')</button>
                </div>

                <div class="col-lg-12 text-center mt-5">
                    @lang('Click to')  <a href="{{route('admin.login')}}" class="text-danger">{{trans('Sign In')}}</a>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('css')
    <style>
        .auth-wrapper .auth-box {
            min-width: 600px;
        }
    </style>
@endpush
