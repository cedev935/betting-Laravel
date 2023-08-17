@extends('admin.layouts.app')
@section('title', trans($page_title))
@section('content')

    @if(adminAccessRoute(config('role.identify_form.access.edit')))
        <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
            <div class="card-body">
                <form method="post" action="{{route('admin.identify-form.action')}}"
                      class="form-row align-items-center ">
                    @csrf

                    <div class="form-group col-md-3">
                        <label class="d-block">@lang('Address Verification')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='address_verification'>
                            <input type="checkbox" name="address_verification" class="custom-switch-checkbox"
                                   id="address_verification"
                                   value="0" {{($control->address_verification == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="address_verification">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="d-block">@lang('Identity Verification')</label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='identity_verification'>
                            <input type="checkbox" name="identity_verification" class="custom-switch-checkbox"
                                   id="identity_verification"
                                   value="0" {{($control->identity_verification == 0) ? 'checked' : ''}} >
                            <label class="custom-switch-checkbox-label" for="identity_verification">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit"
                                class="btn btn-primary btn-block  btn-rounded mx-2 mt-4">
                            <span>@lang('Save Changes')</span></button>
                    </div>

                </form>
            </div>
        </div>
    @endif



    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @php
                $newArr = ['Driving License','Passport','National ID'];
            @endphp

            @if(count($formExist) != count($newArr) )
                <div class="d-flex justify-content-end mb-2 text-right">
                    <button data-toggle="modal" data-target="#btn_add" type="button" class="btn btn-primary btn-sm"><i
                            class="fa fa-plus-circle"></i> {{trans('Add Form')}} </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Identity Type')</th>
                        <th scope="col">@lang('Status')</th>
                        @if(adminAccessRoute(config('role.identify_form.access.edit')))
                            <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($forms as $key => $data)
                        <tr>
                            <td data-label="@lang('SL')">{{++$key}}</td>
                            <td data-label="@lang('Name')">
                                <h5 class="text-dark mb-0 font-16 ">@lang($data->name)</h5>
                            </td>
                            <td data-label="@lang('Status')">
                                <span
                                    class="badge badge-pill {{ $data->status == 0 ? 'badge-danger' : 'badge-success' }}">{{ $data->status == 0 ? 'Inactive' : 'Active' }}</span>
                            </td>

                            @if(adminAccessRoute(config('role.identify_form.access.edit')))
                                <td data-label="@lang('Action')">
                                    <a href="javascript:void(0)"
                                       data-id="{{$data->id}}"
                                       data-name="{{$data->name}}"
                                       data-status="{{$data->status}}"
                                       data-services_form="{{($data->services_form == null) ? null :  json_encode(@$data->services_form)}}"
                                       data-toggle="modal" data-target="#editModal" data-original-title="Edit"
                                       class="btn btn-primary btn-sm editButton"><i class="fa fa-edit"></i></a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="100%">@lang('No Data Found')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>


    <div class="modal  fade " id="btn_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <form action="" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i> {{trans('Add New')}}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>


                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-6 form-group">
                                <label for="inputName" class="control-label"><strong>{{trans('Identity Type')}}
                                        :</strong></label>

                                <select class="form-control  w-100"
                                        data-live-search="true" name="name"
                                        required="">
                                    <option disabled selected>@lang("Select Type")</option>
                                    @if(!in_array('Driving License', $formExist))
                                        <option value="Driving License">{{trans('Driving License')}}</option>
                                    @endif
                                    @if(!in_array('Passport', $formExist))
                                        <option value="Passport">{{trans('Passport')}}</option>
                                    @endif
                                    @if(!in_array('National ID', $formExist))
                                        <option value="National ID">{{trans('National ID')}}</option>
                                    @endif
                                </select>
                                <br>
                                <br>
                                @error('name')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group ">
                                <label for="inputName" class="control-label d-block"><strong>{{trans('Status')}}
                                        :</strong></label>

                                <select class="form-control  w-100"
                                        data-live-search="true" name="status"
                                        required="">
                                    <option disabled selected>@lang("Select Status")</option>
                                    <option value="1">{{trans('Active')}}</option>
                                    <option value="0">{{trans('Deactive')}}</option>
                                </select>
                                <br>

                                <br>
                                @error('status')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <br>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm float-right generate"><i
                                        class="fa fa-plus-circle"></i> {{trans('Add Field')}}</a>

                            </div>
                        </div>

                        <div class="row addedField mt-3">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">
                            {{trans('Close')}}
                        </button>
                        <button type="submit" class="btn btn-primary"> {{trans('Save')}}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <div class="modal  fade " id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <form action="" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i
                                class="fa fa-sync-alt"></i> {{trans('Update Identity Form')}}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>


                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-6 form-group d-none">
                                <label for="inputName" class="control-label"><strong>{{trans('Identity Type')}}
                                        :</strong></label>

                                <select class="form-control  w-100 edit_name d-none"
                                        data-live-search="true" name="name"
                                        required="">
                                    <option disabled selected>@lang("Select Type")</option>
                                    <option value="Driving License">{{trans('Driving License')}}</option>
                                    <option value="Passport">{{trans('Passport')}}</option>
                                    <option value="National ID">{{trans('National ID')}}</option>
                                </select>
                                <br>
                                <br>
                                @error('name')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group ">
                                <label for="inputName" class="control-label d-block"><strong>{{trans('Status')}}
                                        :</strong></label>
                                <select class="form-control  w-100 edit_status"
                                        data-live-search="true" name="status"
                                        required="">
                                    <option disabled>@lang("Select Status")</option>
                                    <option value="1">{{trans('Active')}}</option>
                                    <option value="0">{{trans('Deactive')}}</option>
                                </select>
                                <br>
                                @error('status')
                                <span class="text-danger">{{ trans($message) }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <br>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm float-right generate"><i
                                        class="fa fa-plus-circle"></i> {{trans('Add Field')}}</a>

                            </div>
                        </div>

                        <div class="row addedField mt-3">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">
                            {{trans('Close')}}
                        </button>
                        <button type="submit" class="btn btn-primary"> {{trans('Update')}}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>




@endsection


@push('js')
    <script>
        "use strict";
        $(document).ready(function () {

            $(".generate").on('click', function () {
                var form = `<div class="col-md-12">
                                 <div class="card border-primary">
                                        <div class="card-header  bg-primary p-2 d-flex justify-content-between">
                                            <h5 class="card-title text-white font-weight-bold">{{trans('Field information')}}</h3>
                                            <button  class="btn  btn-danger btn-sm delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Field Name')}}</label>
                                                    <input name="field_name[]" class="form-control " type="text" value="" required
                                                           placeholder="{{trans('Field Name')}}">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Form Type')}}</label>
                                                    <select name="type[]" class="form-control  ">
                                                        <option value="text">{{trans('Input Text')}}</option>
                                                        <option value="textarea">{{trans('Textarea')}}</option>
                                                        <option value="file">{{trans('File upload')}}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Field Length')}}</label>
                                                    <input name="field_length[]" class="form-control " type="number" min="2" value="" required
                                                           placeholder="{{trans('Length')}}">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Field Length Type')}}</label>
                                                    <select name="length_type[]" class="form-control">
                                                        <option value="max">{{trans('Maximum Length')}}</option>
                                                        <option value="digits">{{trans('Fixed Length')}}</option>
                                                    </select>
                                                </div>



                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Form Validation')}}</label>
                                                    <select name="validation[]" class="form-control  ">
                                                        <option value="required">{{trans('Required')}}</option>
                                                        <option value="nullable">{{trans('Optional')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                            </div> `;

                $('.addedField').append(form)
            });

            $('select').select2({
                width: '100%'
            });


            $(document).on('click', '.editButton', function (e) {
                $('.addedField').html('')

                var obj = $(this).data()
                $('.edit_id').val(obj.id)
                $('.edit_name').val(obj.name).trigger('change');
                $(".edit_status").val(obj.status).trigger('change');
                $(".edit_service_id").val(obj.service_id).trigger('change');

                if (obj.services_form == 'null') {

                } else {
                    var objData = Object.entries(obj.services_form);

                    var form = '';
                    for (let i = 0; i < objData.length; i++) {
                        form += `<div class="col-md-12">

                                    <div class="card border-primary">

                                        <div class="card-header  bg-primary p-2 d-flex justify-content-between">
                                            <h5 class="card-title text-white font-weight-bold">{{trans('Field information')}}</h3>
                                            <button  class="btn  btn-danger btn-sm delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Field Name')}}</label>
                                                    <input name="field_name[]" class="form-control"
                                                     value="${objData[i][1].field_level}"
                                                     type="text" required
                                                           placeholder="{{trans('Field Name')}}">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Form Type')}}</label>
                                                    <select name="type[]" class="form-control  ">
                                                        <option value="text" ${(objData[i][1].type === 'text' ? 'selected="selected"' : '')}>{{trans('Input Text')}}</option>
                                                        <option value="textarea" ${(objData[i][1].type === 'textarea' ? 'selected="selected"' : '')}>{{trans('Textarea')}}</option>
                                                        <option value="file" ${(objData[i][1].type === 'file' ? 'selected="selected"' : '')}>{{trans('File upload')}}</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Field Length')}}</label>
                                                    <input name="field_length[]" class="form-control " type="number" min="2" required
                                                    value="${objData[i][1].field_length}"
                                                           placeholder="{{trans('Length')}}">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Field Length Type')}}</label>
                                                    <select name="length_type[]" class="form-control">
                                                        <option value="max"  ${(objData[i][1].length_type === 'max' ? 'selected="selected"' : '')}>{{trans('Maximum Length')}}</option>
                                                        <option value="digits"  ${(objData[i][1].length_type === 'digits' ? 'selected="selected"' : '')}>{{trans('Fixed Length')}}</option>
                                                    </select>
                                                </div>



                                                <div class="col-md-4 form-group">
                                                    <label>{{trans('Form Validation')}}</label>
                                                    <select name="validation[]" class="form-control  ">
                                                            <option value="required" ${(objData[i][1].validation === 'required' ? 'selected="selected"' : '')}>{{trans('Required')}}</option>
                                                            <option value="nullable" ${(objData[i][1].validation === 'nullable' ? 'selected="selected"' : '')}>{{trans('Optional')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                            </div> `;
                    }
                    $('.addedField').append(form)

                }

            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.card').parent().remove();
            });


        });

    </script>
@endpush
