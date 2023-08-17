@extends('admin.layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.update.payment.methods', $method->id) }}"
                              class="needs-validation base-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mt-0 section-title">
                                Edit {{ strtoupper($method->name) }}
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control "
                                           name="name"
                                           value="{{ old('name', $method->name ? : '') }}" disabled required="">
                                    <div class="invalid-feedback">
                                        Please fill in the payment method name
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-text">
                                                {{ $errors->first('name') }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label>Currency</label>
                                    <select class="form-control  selectpicker currency-change"
                                            data-live-search="true" name="currency"
                                            required="">
                                        <option disabled selected>Select Currency</option>
                                        @foreach($method->currencies as $key => $currency)
                                            @foreach($currency as $curKey => $singleCurrency)
                                                <option
                                                    value="{{ $curKey }}" {{ old('currency', $method->currency) == $curKey ? 'selected' : '' }} data-fiat="{{ $key }}">{{ $curKey }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please fill in the currency
                                    </div>
                                    @if ($errors->has('currency'))
                                        <span class="invalid-text">
                                                {{ $errors->first('currency') }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-6">
                                    <label>Currency Symbol</label>
                                    <input type="text" class="form-control "
                                           name="currency_symbol"
                                           value="{{ old('currency_symbol', $method->symbol ?: '') }}" required="">
                                    <div class="invalid-feedback">
                                        Please fill in the currency symbol
                                    </div>
                                    @if ($errors->has('currency_symbol'))
                                        <span class="invalid-text">
                                                {{ $errors->first('currency_symbol') }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label>Convention Rate</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                1 {{ $basic->currency ? : 'USD' }} =
                                            </div>
                                        </div>
                                        <input type="text" class="form-control "
                                               name="convention_rate"
                                               value="{{ old('convention_rate', getAmount($method->convention_rate) ?: '') }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text set-currency">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please fill in the convention rate
                                    </div>
                                    @if ($errors->has('convention_rate'))
                                        <span class="invalid-text">
                                                {{ $errors->first('currency_symbol') }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-6">
                                    <label>Minimum Deposit Amount</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="minimum_deposit_amount"
                                               value="{{ old('minimum_deposit_amount', round($method->min_amount, 2) ?: '') }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{ $basic->currency ?? 'USD' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please fill in the minimum deposit amount
                                    </div>
                                    @if ($errors->has('minimum_deposit_amount'))
                                        <span class="invalid-text">
                                                {{ $errors->first('minimum_deposit_amount') }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label>Maximum Deposit Amount</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="maximum_deposit_amount"
                                               value="{{ old('maximum_deposit_amount', round($method->max_amount, 2) ?: '') }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{ $basic->currency ?? 'USD' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please fill in the maximum deposit amount
                                    </div>
                                    @if ($errors->has('maximum_deposit_amount'))
                                        <span class="invalid-text">
                                                {{ $errors->first('maximum_deposit_amount') }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-6">
                                    <label>Percentage Charge</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="percentage_charge"
                                               value="{{ old('percentage_charge', round($method->percentage_charge, 2) ?: 0) }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                %
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please fill in the percentage charge
                                    </div>
                                    @if ($errors->has('percentage_charge'))
                                        <span class="invalid-text">
                                                {{ $errors->first('percentage_charge') }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label>Fixed Charge</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="fixed_charge"
                                               value="{{ old('fixed_charge', round($method->fixed_charge, 2) ?: 0) }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{ $basic->currency ?? 'USD' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please fill in the fixed charge
                                    </div>
                                    @if ($errors->has('fixed_charge'))
                                        <span class="invalid-text">
                                                {{ $errors->first('fixed_charge') }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($method->parameters as $key => $parameter)
                                    <div class="form-group  col-md-6 col-6">
                                        <label for="{{ $key }}">{{ strtoupper(str_replace('_',' ', $key)) }}</label>
                                        <input type="text" name="{{ $key }}" value="{{ old($key, $parameter) }}"
                                               class="form-control " id="{{ $key }}">
                                        <div class="invalid-feedback">
                                            Please fill in the {{ str_replace('_',' ', $key) }}
                                        </div>
                                        @if ($errors->has($key))
                                            <span class="invalid-text">
                                                {{ $errors->first($key) }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if($method->extra_parameters)
                                <div class="row">
                                    @foreach($method->extra_parameters as $key => $param)
                                        <div class="form-group  col-md-6 col-6">
                                            <label>{{ strtoupper(str_replace('_',' ', $key)) }}</label>
                                            <div class="input-group">
                                                <input type="text" name="{{ $key }}"
                                                       value="{{ old($key, route($param, $method->code )) }}"
                                                       class="form-control" disabled>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-info copy-btn">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="row justify-content-between">

                                <div class="col-sm-6 col-md-3">
                                    <div class="image-input ">
                                        <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                        <input type="file" name="image" placeholder="@lang('Choose image')" id="image">
                                        <img id="image_preview_container" class="preview-image" src="{{ getFile(config('location.gateway.path').$method->image)}}"
                                             alt="preview image">
                                    </div>
                                    @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>@lang('Status')</label>

                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='status'>
                                        <input type="checkbox" name="status" class="custom-switch-checkbox" id="status" value = "0" <?php if( $method->status == 0):echo 'checked'; endif ?> >
                                        <label class="custom-switch-checkbox-label" for="status">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        "use strict";

        $(document).ready(function () {
            setCurrency();
            $(document).on('change', '.currency-change', function (){
                setCurrency();
            });

            function setCurrency() {
                let currency = $('.currency-change').val();
                let fiatYn = $('.currency-change option:selected').attr('data-fiat');
                if(fiatYn == 0){
                    $('.set-currency').text(currency);
                }else{
                    $('.set-currency').text('USD');
                }
            }

            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).parents('.input-group-append').siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });

            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('select').select2({
                selectOnClose: true
            });

        });
    </script>
@endpush
