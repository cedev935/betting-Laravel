@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection


@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card secbg">
                <div class="card-body text-center">
                    <h3 class="card-title">@lang('Payment Preview')</h3>

                    <h4> @lang('PLEASE SEND EXACTLY') <span
                            class="text-success"> {{ getAmount($data->amount) }}</span> {{$data->currency}}
                    </h4>
                    <h5>@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                    <img class="" src="{{$data->img}}" alt="...">
                    <h4 class="text-color font-weight-bold">@lang('SCAN TO SEND')</h4>
                </div>
            </div>
        </div>
    </div>
@endsection

