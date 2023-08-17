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
                                <h2>@lang('Account Recover')</h2>
                                <a href="{{route('home')}}">@lang('back to home')</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-wrapper d-flex align-items-center h-100">
                        <form action="{{ route('password.email') }}" method="post">
                            @csrf
                            <div class="row g-4">
                                <div class="text-center">
                                    @if (session('status'))
                                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                            {{ trans(session('status')) }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <h4>@lang('Recover password')</h4>
                                </div>
                                <div class="input-box col-12">
                                    <input
                                        type="text"
                                        name="email" value="{{old('email')}}"
                                        class="form-control"
                                        placeholder="Email address"/>
                                    @error('email')<span class="text-danger  mt-1">{{ trans($message) }}</span>@enderror
                                </div>
                            </div>

                            <button type="submit"
                                    class="btn-custom w-100 mt-4">@lang('Send Password Reset Link')</button>
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
