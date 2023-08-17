@extends($theme.'layouts.user')
@section('title', 'Warning')
@section('content')
    <div class="row">
        <div class="col-md-8">

            <div class="card secbg">
                <div class="card-body ">
                    <h1 class="text-center text-warning mt-5"><i
                            class="fa fa-warning"></i>
                        @lang('Warning')
                    </h1>
                    <h4 class="text-center">@lang('Uh-ho! We are unable to process your Payment by this method.
                        <br>This method is under construction!!')
                    </h4>
                    <br>
                    <h4 class="text-center">@lang('Select') <b>@lang('bkash')</b> @lang('as your payment method.')</h4>
                    <div class="col-md-8 col-md-offset-2">

                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="text-center">
                                    <a href="{{ route('addFund',["bkash",session()->get('id')]) }}">
                                        <img class="w-100" src="{{ asset('assets/upload/logo/bkash.png') }}"
                                             style="max-width: 100px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
