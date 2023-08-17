@extends($theme.'layouts.error')

@section('title','405')
@section('content')
    <!-- not found -->
    <section class="not-found">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col">
                    <div class="text-box text-center">
                        <img src="{{ asset($themeTrue . '/images/405.svg')}}" alt="..." />
                        <h1>{{trans('405')}}</h1>
                        <p>{{trans("Method Not Allowed")}}</p>
                        <a href="{{url('/')}}" class="btn-custom text-white line-h22">@lang('Back To Home')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
