@extends($theme.'layouts.user')
@section('title', trans($title))

@section('content')
    <div class="row">
        <div class="card col-md-3 ms-3">
            <div class="payment-info text-center">
                <ul class="list-group">
                    <li class="list-group-item font-weight-bold bg-transparent">
                        <img
                            src="{{getFile(config('location.withdraw.path').optional($withdraw->method)->image)}}"
                            class="card-img-top w-50" alt="{{optional($withdraw->method)->name}}">
                    </li>
                    <li class="list-group-item bg-transparent">@lang('Request Amount') :
                        <span
                            class="float-right text-success">{{@$basic->currency_symbol}}{{getAmount($withdraw->amount)}} </span>
                    </li>
                    <li class="list-group-item bg-transparent">@lang('Charge Amount') :
                        <span
                            class="float-right text-danger">{{@$basic->currency_symbol}}{{getAmount($withdraw->charge)}} </span>
                    </li>
                    <li class="list-group-item bg-transparent">@lang('Total Payable') :
                        <span
                            class="float-right text-danger">{{@$basic->currency_symbol}}{{getAmount($withdraw->net_amount)}} </span>
                    </li>
                    <li class="list-group-item bg-transparent">@lang('Available Balance') :
                        <span
                            class="float-right text-success">{{@$basic->currency_symbol}}{{$remaining}} </span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header custom-header text-center">
                    <h5 class="card-title">@lang('Additional Information To Withdraw Confirm')</h5>
                </div>
                <div class="card-body">

                    <form @if($layout == 'layouts.payment') action="{{route('user.payout.submit',$billId)}}"
                          @else action="" @endif method="post" enctype="multipart/form-data"
                          class="form-row text-left preview-form">
                        @csrf
                        @if($payoutMethod->supported_currency)
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group input-box search-currency-dropdown">
                                        <label for="from_wallet">@lang('Select Bank Currency')</label>
                                        <select id="from_wallet" name="currency_code"
                                                class="form-control form-control-sm transfer-currency"
                                                required>
                                            <option value="" disabled=""
                                                    selected="">@lang('Select Currency')</option>
                                            @foreach($payoutMethod->supported_currency as $singleCurrency)
                                                <option
                                                    value="{{$singleCurrency}}"
                                                    @foreach($payoutMethod->convert_rate as $key => $rate)
                                                        @if($singleCurrency == $key) data-rate="{{$rate}}" @endif
                                                    @endforeach {{old('transfer_name') == $singleCurrency ?'selected':''}}>{{$singleCurrency}}</option>
                                            @endforeach
                                        </select>
                                        @error('currency_code')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($payoutMethod->code == 'paypal')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group input-box search-currency-dropdown">
                                        <label for="from_wallet">@lang('Select Recipient Type')</label>
                                        <select id="from_wallet" name="recipient_type"
                                                class="form-control form-control-sm mb-3" required>
                                            <option value="" disabled=""
                                                    selected="">@lang('Select Recipient')</option>
                                            <option value="EMAIL">@lang('Email')</option>
                                            <option value="PHONE">@lang('phone')</option>
                                            <option value="PAYPAL_ID">@lang('Paypal Id')</option>
                                        </select>
                                        @error('recipient_type')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(optional($withdraw->method)->input_form)
                            @foreach($withdraw->method->input_form as $k => $v)
                                @if($v->type == "text")
                                    <div class="col-md-12 mb-3">
                                        <label><strong>{{trans(@$v->label??$v->field_level)}} @if($v->validation == 'required')
                                                    <span class="text-danger">*</span>
                                                @endif</strong></label>
                                        <div class="form-group input-box">
                                            <input type="text" name="{{$k}}"
                                                   class="form-control"
                                                   @if($v->validation == "required") required @endif>
                                            @if ($errors->has($k))
                                                <span
                                                    class="text-danger">{{ trans($errors->first($k)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($v->type == "textarea")
                                    <div class="col-md-12 mb-3">
                                        <label><strong>{{trans(@$v->label??$v->field_level)}} @if($v->validation == 'required')
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </strong></label>
                                        <div class="form-group input-box">
                                            <textarea name="{{$k}}" class="form-control" rows="3"
                                                      @if($v->validation == "required") required @endif></textarea>
                                            @if ($errors->has($k))
                                                <span class="text-danger">{{ trans($errors->first($k)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($v->type == "file")

                                    <div class="col-md-12 mb-3">
                                        <label><strong>{{trans(@$v->label??$v->field_level)}} @if($v->validation == 'required')
                                                    <span class="text-danger">*</span>
                                                @endif
                                            </strong></label>

                                        <div class="form-group">
                                            <div class="fileinput fileinput-new " data-provides="fileinput">
                                                <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                     data-trigger="fileinput">
                                                    <img class="wh-200-150"
                                                         src="{{ getFile(config('location.default')) }}"
                                                         alt="...">
                                                </div>
                                                <div
                                                    class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>

                                                <div class="img-input-div">
                                                                <span class="btn btn-info btn-file">
                                                                    <span
                                                                        class="fileinput-new "> @lang('Select') {{@$v->label??$v->field_level}}</span>
                                                                    <span
                                                                        class="fileinput-exists"> @lang('Change')</span>
                                                                    <input type="file" name="{{$k}}" accept="image/*"
                                                                           @if($v->validation == "required") required @endif>
                                                                </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> @lang('Remove')</a>
                                                </div>

                                            </div>
                                            @if ($errors->has($k))
                                                <br>
                                                <span
                                                    class="text-danger">{{ __($errors->first($k)) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="col-md-12 mt-4">
                            <div class=" form-group">
                                <button type="submit" class="btn-custom">
                                    <span>@lang('Confirm Now')</span>
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css-lib')
    <link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap-fileinput.css')}}">
@endpush

@push('extra-js')
    <script src="{{asset($themeTrue.'js/bootstrap-fileinput.js')}}"></script>
@endpush

@push('script')

@endpush

