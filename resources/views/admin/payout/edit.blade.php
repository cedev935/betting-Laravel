@extends('admin.layouts.app')
@section('title',trans($page_title))
@push('style')
    <link href="{{ asset('assets/admin/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-select.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">

                    <div class="media mb-4 justify-content-end">
                        <a href="{{route('admin.payout-method')}}" class="btn btn-sm  btn-primary mr-2">
                            <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                        </a>
                    </div>


                    <form method="post" action="{{route('admin.payout-method.update', $method->id)}}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="form-group col-md-6 col-6">
                                <label>{{trans('Name')}}</label>
                                <input type="text" class="form-control"
                                       name="name"
                                       value="{{ old('name', $method->name ?? '') }}" required>

                                @error('name')
                                <span class="text-danger">{{ $message  }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label> {{trans('Duration')}} </label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           name="duration"
                                           value="{{ old('duration', $method->duration) }}"
                                           required="">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            {{ trans('Hour / Minutes/ Days ') }}
                                        </div>
                                    </div>
                                </div>

                                @error('duration')
                                <span class="text-danger">{{ $message  }}</span>
                                @enderror
                            </div>
                        </div>
                        @if($method->is_automatic == 1)
                            <div class="row">
                                @if($method->bank_name)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency">@lang('Bank')</label>
                                            <select
                                                class="form-select form-control"
                                                name="banks[]" multiple="multiple" id="selectCurrency"
                                                required>
                                                @foreach($method->bank_name as $key => $bank)
                                                    @foreach($bank as $curKey => $singleBank)
                                                        <option value="{{ $curKey }}"
                                                                {{ in_array($curKey,$method->banks) == true ? 'selected' : '' }} data-fiat="{{ $key }}"
                                                                required>{{ trans($curKey) }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                @error('banks') @lang($message) @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($method->currency_lists)
                                    <div
                                        class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency">@lang('Supported Currency')</label>
                                            <select
                                                class="form-select form-control @error('supported_currency') is-invalid @enderror"
                                                name="supported_currency[]" multiple="multiple"
                                                id="selectSupportedCurrency"
                                                required>
                                                @foreach($method->currency_lists as $key => $currency)
                                                    <option
                                                        value="{{$key}}"
                                                        @foreach($method->supported_currency as $sup)
                                                            @if($sup == $currency)
                                                                selected
                                                        @endif
                                                        @endforeach>{{$currency}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                @error('currency_lists') @lang($message) @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-md-6 col-6">
                                <label>{{trans('Minimum Amount')}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           name="minimum_amount"
                                           value="{{ old('minimum_amount', round($method->minimum_amount, 2) ?? '') }}"
                                           required="">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            {{ $basic->currency ?? 'USD' }}
                                        </div>
                                    </div>
                                </div>

                                @error('minimum_amount')
                                <span class="text-danger">{{ $message  }}</span>
                                @enderror
                            </div>


                            <div class="form-group col-md-6 col-6">
                                <label>{{trans('Maximum Amount')}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           name="maximum_amount"
                                           value="{{ old('maximum_amount', round($method->maximum_amount, 2) ?? '') }}"
                                           required="">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            {{ $basic->currency ?? 'USD' }}
                                        </div>
                                    </div>
                                </div>

                                @error('maximum_amount')
                                <span class="text-danger">{{ $message  }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 col-6">
                                <label>@lang('Percent Charge')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           name="percent_charge"
                                           value="{{ old('percent_charge', round($method->percent_charge, 2) ?? '') }}"
                                           required="">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            %
                                        </div>
                                    </div>
                                </div>
                                @error('percent_charge')
                                <span class="text-danger">{{ $message  }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label>@lang('Fixed Charge')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           name="fixed_charge"
                                           value="{{ old('fixed_charge', round($method->fixed_charge, 2) ?? '') }}"
                                           required="">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            {{ $basic->currency ?? 'USD' }}
                                        </div>
                                    </div>
                                </div>

                                @error('fixed_charge')
                                <span class="text-danger">{{ $message  }}</span>
                                @enderror

                            </div>
                        </div>

                        @if($method->is_automatic == 1)
                            @if($method->supported_currency)
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="card card-primary shadow params-color">
                                            <div
                                                class="card-header text-dark font-weight-bold"> @lang('Conversion Rate')</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($method->supported_currency as $key => $currency)
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-append">
																			<span
                                                                                class="form-control">@lang('1 '){{config('basic.currency')}} =</span>
                                                                    </div>
                                                                    <input type="text"
                                                                           name="rate[{{$key}}]"
                                                                           step="0.001"
                                                                           class="form-control"
                                                                           @foreach ($method->convert_rate as $key1 => $rate )
                                                                               @php
                                                                                   if($key == $key1){
                                                                                       $rate = $rate;
                                                                                       break;
                                                                                   }else{
                                                                                       $rate =1;
                                                                                   }
                                                                               @endphp
                                                                           @endforeach
                                                                           value="{{$rate}}">
                                                                    <div class="input-group-prepend">
																				<span
                                                                                    class="form-control">{{$currency}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if($method->is_automatic == 1)
                            @if($method->parameters)
                                <div class="row mt-4">
                                    @foreach ($method->parameters as $key => $parameter)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="{{ $key }}">{{ __(strtoupper(str_replace('_',' ', $key))) }}</label>
                                                <input type="text" name="{{ $key }}"
                                                       value="{{ old($key, $parameter) }}"
                                                       id="{{ $key }}"
                                                       class="form-control @error($key) is-invalid @enderror">
                                                <div class="invalid-feedback">
                                                    @error($key) @lang($message) @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if($method->extra_parameters)
                                <div class="row">
                                    @foreach($method->extra_parameters as $key => $param)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    for="{{ $key }}">{{ __(strtoupper(str_replace('_',' ', $key))) }}</label>
                                                <div class="input-group">
                                                    <input type="text" name="{{ $key }}"
                                                           class="form-control @error($key) is-invalid @enderror"
                                                           value="{{ old($key, route($param, $method->code )) }}"
                                                           disabled>
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                                class="btn btn-info copy-btn btn-sm">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">
                                                    @error($key) @lang($message) @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif

                        <div class="row justify-content-between">

                            <div class="col-sm-6 col-md-3">
                                <div class="image-input ">
                                    <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                    <input type="file" name="image" placeholder="@lang('Choose image')" id="image">
                                    <img id="image_preview_container" class="preview-image"
                                         src="{{ getFile(config('location.withdraw.path').$method->image)}}"
                                         alt="preview image">
                                </div>
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div
                            class="row mt-3 {{$method->is_automatic == 1?'justify-content-start':'justify-content-between'}}">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Status')</label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='status'>
                                        <input type="checkbox" name="status" class="custom-switch-checkbox" id="status"
                                               value="0" {{($method->status == 0) ? 'checked':''}}>
                                        <label class="custom-switch-checkbox-label" for="status">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>

                            @if($method->is_automatic == 1)
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group ">
                                        <label>@lang('Test Environment')</label>
                                        <div class="custom-switch-btn">
                                            <input type='hidden' value='1' name='environment'>
                                            <input type="checkbox" name="environment" class="custom-switch-checkbox"
                                                   id="environment"
                                                   value="0" {{($method->environment == 0) ? 'checked':''}}>
                                            <label class="custom-switch-checkbox-label" for="environment">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            @if($method->is_automatic == 0)
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <a href="javascript:void(0)" class="btn btn-success float-right mt-3"
                                           id="generate"><i
                                                class="fa fa-plus-circle"></i> @lang('Add Field')</a>
                                    </div>
                                </div>
                            @endif

                        </div>

                        @if($method->is_automatic == 0)
                            <div class="row addedField">
                                @if($method->input_form)
                                    @foreach ($method->input_form as $k => $v)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">

                                                    <input name="field_name[]" class="form-control"
                                                           type="text" value="{{$v->label}}" required
                                                           placeholder="{{trans('Field Name')}}">

                                                    <select name="type[]" class="form-control">
                                                        <option value="text"
                                                                @if($v->type == 'text') selected @endif>{{trans('Input Text')}}</option>
                                                        <option value="textarea"
                                                                @if($v->type == 'textarea') selected @endif>{{trans('Textarea')}}</option>
                                                        <option value="file"
                                                                @if($v->type == 'file') selected @endif>{{trans('File upload')}}</option>
                                                    </select>

                                                    <select name="validation[]" class="form-control  ">
                                                        <option value="required"
                                                                @if($v->validation == 'required') selected @endif>{{trans('Required')}}</option>
                                                        <option value="nullable"
                                                                @if($v->validation == 'nullable') selected @endif>{{trans('Optional')}}</option>
                                                    </select>

                                                    <span class="input-group-btn">
                                                    <button class="btn btn-danger  delete_desc" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif

                        <button type="submit"
                                class="btn  btn-primary btn-block mt-3">@lang('Save Changes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
    <script>
        $(document).ready(function (e) {
            "use strict";

            $(function () {
                $('#selectCurrency').selectpicker();
                $('#selectSupportedCurrency').selectpicker();
            });

            $("#generate").on('click', function () {
                var form = `<div class="col-md-12">
        <div class="form-group">
            <div class="input-group">
                <input name="field_name[]" class="form-control " type="text" value="" required
                       placeholder="@lang("Field Name")">

                <select name="type[]" class="form-control ">
                    <option value="text">@lang("Input Text")</option>
                    <option value="textarea">@lang("Textarea")</option>
                    <option value="file">@lang("File upload")</option>
                </select>

                <select name="validation[]" class="form-control  ">
                    <option value="required">@lang('Required')</option>
                    <option value="nullable">@lang('Optional')</option>
                </select>

                <span class="input-group-btn">
                    <button class="btn btn-danger  delete_desc" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>`;
                $('.addedField').append(form)
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });


            $('#image').on('change',function () {
                var reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });

    </script>
@endpush
