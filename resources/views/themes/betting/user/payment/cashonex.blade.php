@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection

@section('content')

    <style>
        .credit-card-box .form-control.error {
            border-color: red;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
        }

        .credit-card-box label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .dark-mode .input-group-text {
            color: #fffff6;
            background-color: {{config('basic.base_color')??'#8fb568'}};
            border: 1px solid{{config('basic.base_color')??'#8fb568'}};
        }
    </style>

    <section id="dashboard">
        <div class="container add-fund">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card secbg">
                        <div class="card-body">
                            <div class="row justify-content-center">

                                <div class="col-md-12 p-4">

                                    <div class="card-wrapper"></div>
                                    <br><br>

                                    <form role="form" id="payment-form" method="{{$data->method}}"
                                          action="{{$data->url}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><strong>@lang("CARD NAME")</strong></label>
                                                <div class="input-group input-box">
                                                    <input type="text" class="form-control white" name="name"
                                                           placeholder="Card Name" autocomplete="off" required>
                                                    <span class="input-group-addon modal-input-addon"></span>

                                                    <div class="input-group-append">
                                                        <span class="input-group-text py-2"><i
                                                                class="fa fa-font"></i></span>
                                                    </div>
                                                </div>

                                                @error('name')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>@lang("CARD NUMBER")</strong></label>
                                                <div class="input-group input-box">
                                                    <input type="tel" class="form-control white" name="cardNumber"
                                                           placeholder="Valid Card Number" autocomplete="off" autofocus
                                                           required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text py-2">
                                                          <i class="fa fa-credit-card"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                @error('cardNumber')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            </div>

                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><strong>@lang("EXPIRATION DATE")</strong></label>
                                                <div class="input-box">
                                                    <input
                                                        type="tel"
                                                        class="form-control"
                                                        name="cardExpiry"
                                                        placeholder="MM / YYYY"
                                                        autocomplete="off"
                                                        required/>
                                                </div>


                                                @error('cardExpiry')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="col-md-6">

                                                <label><strong>@lang("CVC CODE")</strong></label>
                                                <div class="input-box">
                                                    <input
                                                        type="tel"
                                                        class="form-control"
                                                        name="cardCVC"
                                                        placeholder="CVC"
                                                        autocomplete="off"
                                                        required/>
                                                </div>
                                                @error('cardCVC')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror

                                            </div>
                                        </div>
                                        <br>
                                        <div class="btn-wrapper">
                                            <input class="btn-custom w-100 " type="submit" value="PAY NOW">
                                        </div>
                                    </form>


                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
        (function ($) {
            $(document).ready(function () {
                var card = new Card({
                    form: '#payment-form',
                    container: '.card-wrapper',
                    formSelectors: {
                        numberInput: 'input[name="cardNumber"]',
                        expiryInput: 'input[name="cardExpiry"]',
                        cvcInput: 'input[name="cardCVC"]',
                        nameInput: 'input[name="name"]'
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
