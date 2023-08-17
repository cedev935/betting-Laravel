@extends('admin.layouts.app')
@section('title')
    @lang($title)
@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between mb-3">
                        <div class="col-md-6">
                            <h5 class="card-title  font-weight-bold color-primary">@lang('CurrencyLayer Api Config (Fiat Currency)')</h5>
                        </div>
                    </div>
                    <form action="{{ route('admin.currency.exchange.api.config') }}" method="post"
                          class="needs-validation base-form">
                        @csrf
                        <div class="row my-3">
                            <div class="form-group col-sm-4 col-12">
                                <label for="currency_layer_access_key">@lang('Currency Layer Access Key')</label>
                                <input type="text" name="currency_layer_access_key"
                                       value="{{ old('currency_layer_access_key',$basicControl->currency_layer_access_key) }}"
                                       placeholder="@lang('Enter your currency layer access key')"
                                       class="form-control @error('currency_layer_access_key') is-invalid @enderror">
                                @error('currency_layer_access_key')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-sm-4 col-12">
                                <label for="currency_layer_auto_update_at">@lang('Select Update Time')</label>
                                <select name="currency_layer_auto_update_at" id="update_time_currency_layer"
                                        class="form-control @error('how_many_days') is-invalid @enderror">
                                    @foreach(config('basic.schedule_list') as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ $key == old('currency_layer_auto_update_at',$basicControl->currency_layer_auto_update_at) ? 'selected' : '' }}> @lang($value)</option>
                                    @endforeach
                                </select>
                                @error('currency_layer_auto_update_at')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>


                            <div class="form-group col-sm-4  col-12">
                                <label for="currency_layer_auto_update">@lang('Auto Update Currency Rate')</label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='currency_layer_auto_update'>
                                    <input type="checkbox" name="currency_layer_auto_update"
                                           class="custom-switch-checkbox"
                                           id="currency_layer_auto_update"
                                           value="0" {{ old('currency_layer_auto_update', $basicControl->currency_layer_auto_update) == 0 ? 'checked' : ''}} >
                                    <label class="custom-switch-checkbox-label" for="currency_layer_auto_update">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="row align-items-center justify-content-between mb-3">
                            <div class="col-md-6">
                                <h5 class="card-title  font-weight-bold color-primary">@lang('CoinMarketCap Api Config (Crypto Currency)')</h5>
                            </div>
                        </div>


                        <div class="row my-3">
                            <div class="form-group col-sm-4 col-12">
                                <label for="coin_market_cap_app_key">@lang('Coin Market Cap App Key')</label>
                                <input type="text" name="coin_market_cap_app_key"
                                       value="{{ old('coin_market_cap_app_key',$basicControl->coin_market_cap_app_key) }}"
                                       placeholder="@lang('Enter your coin market cap app key')"
                                       class="form-control @error('coin_market_cap_app_key') is-invalid @enderror">
                                @error('coin_market_cap_app_key')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-sm-4 col-12">
                                <label for="coin_market_cap_auto_update_at">@lang('Select Update Time')</label>
                                <select name="coin_market_cap_auto_update_at" id="update_time_coin_market_cap"
                                        class="form-control @error('how_many_days') is-invalid @enderror">
                                    @foreach(config('basic.schedule_list') as $key => $value)
                                        <option
                                            value="{{ $key }}" {{ $key == old('coin_market_cap_auto_update_at',$basicControl->coin_market_cap_auto_update_at) ? 'selected' : '' }}> @lang($value)</option>
                                    @endforeach
                                </select>
                                @error('coin_market_cap_auto_update_at')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>



                            <div class="form-group col-sm-4  col-12">
                                <label for="coin_market_cap_auto_update">@lang('Auto Update Currency Rate')</label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='coin_market_cap_auto_update'>
                                    <input type="checkbox" name="coin_market_cap_auto_update" class="custom-switch-checkbox"
                                           id="coin_market_cap_auto_update"
                                           value="0" {{ old('coin_market_cap_auto_update', $basicControl->coin_market_cap_auto_update) == 0 ? 'checked' : ''}}>
                                    <label class="custom-switch-checkbox-label" for="coin_market_cap_auto_update">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                                class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3"><span><i
                                    class="fas fa-save pr-2"></i> @lang('Save Changes')</span></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between mb-3">
                        <div class="col-md-6">
                            <h5 class="card-title  font-weight-bold color-primary">@lang('Currency Layer Instructions')</h5>
                        </div>
                    </div>

                    <p>
                        @lang('Currencylayer provides a simple REST API with real-time and historical exchange rates for 168 world currencies, delivering currency pairs in universally usable JSON format - compatible with any of your applications.
                    <br><br>
                    Spot exchange rate data is retrieved from several major forex data providers in real-time, validated, processed and delivered hourly, Every 10 minutes, or even within the 60-second market window.')
                        <a href="https://currencylayer.com/product"
                           target="_blank">@lang('Create an account') <i class="fas fa-external-link-alt"></i></a>
                    </p>

                    <div class="row align-items-center justify-content-between mb-3 mt-5">
                        <div class="col-md-6">
                            <h5 class="card-title  font-weight-bold color-primary">@lang('Coin Market Cap Instructions')</h5>
                        </div>
                    </div>

                    <p>
                        @lang('CoinMarketCap is the world\'s most-referenced price-tracking website for cryptoassets in the rapidly growing cryptocurrency space.
												Its mission is to make crypto discoverable and efficient globally by empowering retail users with unbiased,
												high quality and accurate information for drawing their own informed conclusions.
												Get your free API keys')
                        <a href="https://coinmarketcap.com/"
                           target="_blank">@lang('Create an account') <i class="fas fa-external-link-alt"></i></a>
                    </p>

                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        'use strict';
        $("#update_time_coin_market_cap").select2({
            selectOnClose: true,
            width: '100%'
        })
        $("#update_time_currency_layer").select2({
            selectOnClose: true,
            width: '100%'
        })
    </script>
@endpush

