@extends($theme.'layouts.app')
@section('title','Verification')

@section('content')
    <!-- LOGIN-SIGNUP -->
    <section style="padding: 120px 0"id="login-signup">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="wrapper">
                            <div class="login-info-wrapper">

                                <img class="w-100"src="{{asset(template(true).'images/verification.jpg')}}" alt="..." class="w-100">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-7">
                    <div
                        class="form-wrapper w-100 h-100 d-flex flex-column align-items-start justify-content-center pl-65">
                        <h4 class="h4 text-uppercase mb-30">@lang('Email Verification')</h4>

                        <form method="POST" action="" class="form-content w-100">
                            @csrf
                            <div class="login">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="username" value="{{old('username')}}"
                                           placeholder="@lang('Code')">
                                    @error('username')
                                    <p class="text-danger  mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                            <button class="btn mt-20" type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /LOGIN-SIGNUP -->
@endsection
