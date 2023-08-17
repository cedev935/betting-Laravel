@extends('admin.layouts.app')
@section('title')
    {{ trans($page_title) }}
@endsection
@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ trans($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <form method="post" action="{{route('admin.deposit.manual.update',$method)}}"
                              class="needs-validation base-form" novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>{{trans('Name')}}</label>
                                    <input type="text" class="form-control "
                                           name="name"
                                           value="{{ old('name', $method->name) }}" required="">
                                    @if ($errors->has('name'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('name')) }}
                                            </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-4">
                                    <label>{{trans('Currency')}}</label>
                                    <input type="text" class="form-control "
                                           name="currency"
                                           value="{{ old('currency',$method->currency) }}" required="required">

                                    @if ($errors->has('currency'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('currency')) }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label>{{trans('Convention Rate')}}</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                1 {{ $basic->currency ? : 'USD' }} =
                                            </div>
                                        </div>
                                        <input type="text" class="form-control "
                                               name="convention_rate"
                                               value="{{ old('convention_rate',getAmount($method->convention_rate)) }}"
                                               required>
                                        <div class="input-group-append">
                                            <div class="input-group-text set-currency">

                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('convention_rate'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('currency_symbol')) }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-6">
                                    <label>{{trans('Minimum Deposit Amount')}}</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="minimum_deposit_amount"
                                               value="{{ old('minimum_deposit_amount',getAmount($method->min_amount)) }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{ $basic->currency ?? trans('USD') }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('minimum_deposit_amount'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('minimum_deposit_amount')) }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label>{{trans('Maximum Deposit Amount')}}</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="maximum_deposit_amount"
                                               value="{{ old('maximum_deposit_amount', getAmount($method->max_amount)) }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{ $basic->currency ?? trans('USD') }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('maximum_deposit_amount'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('maximum_deposit_amount')) }}
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-6">
                                    <label>{{trans('Percentage Charge')}}</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="percentage_charge"
                                               value="{{ old('percentage_charge',getAmount($method->percentage_charge)) }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{trans('%')}}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('percentage_charge'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('percentage_charge')) }}
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label>@lang('Fixed Charge')</label>
                                    <div class="input-group ">
                                        <input type="text" class="form-control "
                                               name="fixed_charge"
                                               value="{{ old('fixed_charge',getAmount($method->fixed_charge)) }}"
                                               required="">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{ $basic->currency ?? trans('USD') }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($errors->has('fixed_charge'))
                                        <span class="invalid-text">
                                                {{ trans($errors->first('fixed_charge')) }}
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row justify-content-between">
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Gateway Logo')</label>

                                        <div class="image-input ">
                                            <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                            <input type="file" name="image" placeholder="@lang('Choose image')" id="image">
                                            <img id="image_preview_container" class="preview-image" src="{{ getFile(config('location.gateway.path').$method->image)}}"
                                                 alt="preview image">
                                        </div>
                                    </div>
                                    @error('image')
                                    <span class="text-danger">{{ trans($message) }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-9">
                                    <div class="form-group ">
                                        <label>@lang('Note')</label>
                                        <textarea class="form-control summernote" name="note" id="summernote" rows="15">{{old('note',$method->note)}}</textarea>
                                        @error('note')
                                        <span class="text-danger">{{ trans($message) }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 justify-content-between">

                                <div class="form-group col-lg-3 col-md-6">
                                    <label>@lang('Status')</label>

                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='status'>
                                        <input type="checkbox" name="status" class="custom-switch-checkbox" id="status" value = "0"
                                            {{($method->status == 0)? 'checked' : ''}}>
                                        <label class="custom-switch-checkbox-label" for="status">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <a href="javascript:void(0)" class="btn btn-success float-right mt-3" id="generate"><i
                                                class="fa fa-plus-circle"></i> {{trans('Add Field')}}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row addedField">
                                @if($method->parameters)
                                    @foreach ($method->parameters as $k => $v)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">

                                                    <input name="field_name[]" class="form-control"
                                                           type="text" value="{{$v->field_level}}" required
                                                           placeholder="{{trans('Field Name')}}">

                                                    <select name="type[]" class="form-control  ">
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

                            <button type="submit" class="btn btn-rounded btn-primary btn-block mt-3">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css')}}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js')}}"></script>
@endpush

@push('js')
    <script>
        "use strict";

        $(document).ready(function () {
            setCurrency();
            $(document).on('change', 'input[name="currency"]', function (){
                setCurrency();
            });

            function setCurrency() {
                let currency = $('input[name="currency"]').val();
                $('.set-currency').text(currency);
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
        })



        $(document).ready(function (e) {

            $("#generate").on('click', function () {
                var form = `<div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input name="field_name[]" class="form-control " type="text" value="" required placeholder="{{trans('Field Name')}}">

                                        <select name="type[]"  class="form-control  ">
                                            <option value="text">{{trans('Input Text')}}</option>
                                            <option value="textarea">{{trans('Textarea')}}</option>
                                            <option value="file">{{trans('File upload')}}</option>
                                        </select>

                                        <select name="validation[]"  class="form-control  ">
                                            <option value="required">{{trans('Required')}}</option>
                                            <option value="nullable">{{trans('Optional')}}</option>
                                        </select>

                                        <span class="input-group-btn">
                                            <button class="btn btn-danger delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div> `;

                $('.addedField').append(form)
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });


            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('.summernote').summernote({
                height: 250,
                callbacks: {
                    onBlurCodeview: function() {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
        });



    </script>
    <script>
        $(document).ready(function (e) {
            "use strict";

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
