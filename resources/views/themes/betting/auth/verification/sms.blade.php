@extends($theme.'layouts.app')
@section('title',$page_title)
@section('content')
    <section class="login-section">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-lg-6 p-0">
                    <div class="text-box h-100">
                        <div class="overlay h-100">
                            <div class="text">
                                <h2>@lang('Sms Verification')</h2>
                                <a href="{{route('home')}}">@lang('back to home')</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-wrapper d-flex align-items-center h-100">
                        <form action="{{route('user.smsVerify')}}" method="post">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12">
                                    <h4>@lang('Sms Verification')</h4>
                                </div>
                                <div class="input-box col-12">
                                    <input
                                        type="text"
                                        name="code" value="{{old('code')}}"
                                        class="form-control"
                                        placeholder="@lang('Sms Verification Code')"/>
                                    @error('code')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                    @error('error')<span class="text-danger  mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn-custom w-100 mt-4">@lang('Submit')</button>
                            <div class="bottom">
                                @lang("Didn't get Code? Click to") <br />
                                <a href="{{route('user.resendCode')}}?type=mobile">@lang('Resend Code')</a>
                                @error('resend')
                                <p class="text-danger  mt-1">{{ $message }}</p>
                                @enderror
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
