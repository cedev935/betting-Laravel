@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection


@section('content')

    <script src="https://js.stripe.com/v3/"></script>
    <style>
        form.form{box-shadow: none!important;}
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>

    <div class="row">
        <div class="col-md-8">
            <div class="card secbg br-4">
                <div class="card-body br-4">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <img
                                src="{{getFile(config('location.gateway.path').optional($order->gateway)->image)}}"
                                class="card-img-top gateway-img br-4" alt="...">
                        </div>
                        <div class="col-md-9">
                            <h4>@lang('Please Pay') {{getAmount($order->final_amount)}} {{$order->gateway_currency}}</h4>
                            <h4 class="mt-15 mb-15">@lang('To Get') {{getAmount($order->amount)}}  {{$basic->currency}}</h4>
                            <form action="{{$data->url}}" method="{{$data->method}}" class="form">
                                <script
                                    src="{{$data->src}}"
                                    class="stripe-button"
                                    @foreach($data->val as $key=> $value)
                                        data-{{$key}}="{{$value}}"
                                    @endforeach>
                                </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function () {
                $('button[type="submit"]').removeClass("stripe-button-el").addClass("btn-custom").find('span').css('min-height', 'initial');
            })
        </script>
    @endpush

@endsection




