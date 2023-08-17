<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ getFile(config('location.logoIcon.path').'favicon.png')}}">
    <title>@yield('title') | {{$basic->site_title}}</title>
    <link href="{{asset('assets/admin/css/style.min.css')}}" rel="stylesheet">
    @stack('css')
</head>
<body>
        <div class="main-wrapper">
            <div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>

            <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
                 style="background:url({{getFile(config('location.logoIcon.path').'auth-bg.jpg')}}) no-repeat center center;">
                <div class="auth-box row">
                    <div class="col-lg-6 col-md-5 modal-bg-img"
                         style="background-image: url({{getFile(config('location.logoIcon.path').'theme.jpg')}});">
                    </div>

                    <div class="col-lg-6 col-md-7 bg-white">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>



    <script src="{{asset('assets/global/js/jquery.min.js') }}"></script>
    <script src="{{asset('assets/global/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/global/js/notiflix-aio-2.7.0.min.js')}}"></script>
    @stack('js-lib')

    @stack('js')
    @include('admin.layouts.notification')
    <script>
        "use strict";
        $(".preloader ").fadeOut();
    </script>

</body>
</html>

