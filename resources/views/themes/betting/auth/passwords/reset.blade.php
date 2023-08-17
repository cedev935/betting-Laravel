@extends($theme.'layouts.app')
@section('title','Reset Password')

@section('content')
    <section class="login-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-lg-6 p-0">
                    <div class="text-box h-100">
                        <div class="overlay h-100">
                            <div class="text">
                                <h2>@lang('Reset your Password')</h2>
                                <a href="{{route('home')}}">@lang('back to home')</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-wrapper d-flex align-items-center h-100">
                        <form action="{{route('password.update')}}" method="post">
                            @csrf
                            <div class="row g-4">
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                        {{ trans(session('status')) }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"></span>
                                        </button>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <h4>@lang('Reset Password')</h4>
                                </div>
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="input-box col-12">
                                    <input type="password" class="form-control" name="password"
                                           placeholder="@lang('New Password')"/>
                                    @error('password')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-box col-12">
                                    <input type="password" class="form-control" name="password_confirmation"
                                           placeholder="@lang('Confirm Password')"/>
                                    @error('password')
                                    <span class="text-danger mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn-custom w-100">@lang('submit')</button>
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
