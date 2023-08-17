@extends($theme.'layouts.error')

@section('title','Page Not Found')
@section('content')
    <!-- not found -->
    <section class="not-found">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col">
                    <div class="text-box text-center">
                        <img src="{{ asset($themeTrue . '/images/404.svg')}}" alt="..." />
                        <h1>{{trans('Opps!')}}</h1>
                        <p>{{trans('The page you are looking for was not found.')}}</p>
                        <a href="{{url('/')}}" class="btn-custom text-white line-h22">@lang('Back To Home')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
