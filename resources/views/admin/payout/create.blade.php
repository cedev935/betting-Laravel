@extends('admin.layouts.app')
@section('title',trans($page_title))
@section('content')

    <div class="row ">
        <div class="col-12">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <div class="media mb-4 justify-content-end">
                        <a href="{{route('admin.payout-method')}}" class="btn btn-sm  btn-primary mr-2">
                            <span><i class="fas fa-eye"></i> @lang('Payout Method')</span>
                        </a>
                    </div>

                    <form method="post" action="{{route('admin.payout-method.store')}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 col-6">
                                <label>{{trans('Name')}}</label>
                                <input type="text" class="form-control"
                                       name="name"
                                       value="{{ old('name') }}" >

                                @error('name')
                                <span class="text-danger">{{ $message  }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6 col-6">
                                <label> {{trans('Duration')}} </label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           name="duration"
                                           value="{{ old('duration') }}"
                                           >
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


                        <div class="row">
                            <div class="form-group col-md-6 col-6">
                                <label>{{trans('Minimum Amount')}}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           name="minimum_amount"
                                           value="{{ old('minimum_amount') }}"
                                           >
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
                                           value="{{ old('maximum_amount') }}"
                                           >
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
                                           value="{{ old('percent_charge') }}"
                                           >
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
                                           value="{{ old('fixed_charge') }}"
                                           >
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


                        <div class="row justify-content-between">

                            <div class="col-sm-6 col-md-3">
                                <div class="image-input ">
                                    <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                    <input type="file" name="image" placeholder="@lang('Choose image')" id="image">
                                    <img id="image_preview_container" class="preview-image"
                                         src="{{ getFile(config('location.withdraw.path'))}}"
                                         alt="preview image">
                                </div>
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-between">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group ">
                                    <label>@lang('Status')</label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='status'>
                                        <input type="checkbox" name="status" class="custom-switch-checkbox" id="status"
                                               value="0">
                                        <label class="custom-switch-checkbox-label" for="status">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>


                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <a href="javascript:void(0)" class="btn btn-success float-right mt-3" id="generate"><i
                                            class="fa fa-plus-circle"></i> Add Field</a>
                                </div>
                            </div>

                        </div>


                        <div class="row addedField">

                        </div>

                        <button type="submit"
                                class="btn  btn-primary btn-block mt-3">@lang('Save Changes')</button>
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


        });

        $(document).ready(function () {
            $('select').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush
