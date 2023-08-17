@extends('admin.layouts.app')
@section('title',trans($title))
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">

            @if(adminAccessRoute(config('role.manage_staff.access.add')))
                <div class="d-flex justify-content-end mb-2 text-right">
                    <button data-target="#addModal" data-toggle="modal" class="btn btn-primary btn-sm"><i
                            class="fa fa-user-plus"></i> {{trans('Add New')}} </button>
                </div>
            @endif

            @include('errors.error')

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Username')</th>
                        <th scope="col">@lang('Email')</th>
                        <th scope="col">@lang('Phone')</th>
                        <th scope="col">@lang('Status')</th>
                        @if(adminAccessRoute(config('role.manage_staff.access.edit')))
                            <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $k => $data)
                        <tr>
                            <td data-label="SL">{{++$k}}</td>
                            <td data-label="Username"><strong>{{$data->username}}</strong></td>
                            <td data-label="Email">{{$data->email}}</td>
                            <td data-label="Phone">{{$data->phone}}</td>

                            <td>
                                <span
                                    class="badge  badge-pill  badge-{{ $data->status ==0 ? 'danger' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</span>
                            </td>
                            @if(adminAccessRoute(config('role.manage_staff.access.edit')))
                                <td data-label="@lang('Action')">
                                    <button
                                        class="edit_button   btn btn-primary  text-white  btn-sm "
                                        data-target="#myModal{{$data->id}}"
                                        data-id="{{$data->id }}"
                                        data-toggle="modal">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <!-- Modal for Edit button -->
                                    <div class="modal fade" id="myModal{{$data->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel"
                                         aria-hidden="true" data-backdrop="static">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content ">
                                                <div class="modal-header modal-colored-header bg-primary">
                                                    <h4 class="modal-title"
                                                        id="myModalLabel">@lang('Manage Admin Role')</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true">&times;
                                                    </button>
                                                </div>

                                                <form role="form" method="POST" class="actionRoute"
                                                      action="{{route('admin.updateStaff',$data)}}"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> {{trans('Name')}} :</label>
                                                                <input class="form-control " name="name"
                                                                       placeholder="{{trans('Name')}}"
                                                                       value="{{$data->name}}" required
                                                                       autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> {{trans('Username')}}
                                                                    :</label>
                                                                <input class="form-control " name="username"
                                                                       placeholder="{{trans('Username')}}"
                                                                       value="{{$data->username}}" autocomplete="off"
                                                                       required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> {{trans('E-Mail')}} :</label>
                                                                <input class="form-control " name="email"
                                                                       placeholder="Email Address"
                                                                       value="{{$data->email}}"
                                                                       autocomplete="off"
                                                                       required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> {{trans('Phone')}} :</label>
                                                                <input class="form-control " name="phone"
                                                                       placeholder="{{trans('Mobile Number')}}"
                                                                       value="{{$data->phone}}" autocomplete="off"
                                                                       required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> {{trans('Password')}}
                                                                    :</label>
                                                                <input type="password" name="password"
                                                                       placeholder="Password" autocomplete="off"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> {{trans('Select Status')}}
                                                                    :</label>
                                                                <select name="status" id="event-status"
                                                                        class="form-control " required>
                                                                    <option value="1"
                                                                            @if($data->status == '1') selected @endif>
                                                                        {{trans('Active')}}
                                                                    </option>
                                                                    <option value="0"
                                                                            @if($data->status == '0') selected @endif>
                                                                        {{trans('DeActive')}}
                                                                    </option>
                                                                </select>
                                                                <br>
                                                            </div>


                                                            <div class="form-group col-md-12">
                                                                <div class="card">
                                                                    <div
                                                                        class="card-header d-flex justify-content-between text-center">
                                                                        <h5 class="card-title text-center">{{trans('Accessibility')}}</h5>
                                                                    </div>

                                                                    <div class="card-body select-all-access">
                                                                        <div class="form-group">
                                                                            <label><input type="checkbox"
                                                                                          class="selectAll"
                                                                                          name="accessAll"> {{trans('Select All')}}
                                                                            </label>
                                                                        </div>

                                                                        <table
                                                                            class=" table table-hover table-striped table-bordered text-center">
                                                                            <thead class="thead-dark">
                                                                            <tr>
                                                                                <th class="text-left">@lang('Permissions')</th>
                                                                                <th>@lang('View')</th>
                                                                                <th>@lang('Add')</th>
                                                                                <th>@lang('Edit')</th>
                                                                                <th>@lang('Delete')</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach(config('role') as $key => $value)
                                                                                <tr>
                                                                                    <td data-label="Permissions"
                                                                                        class="text-left">{{$value['label']}}</td>
                                                                                    <td data-label="View">
                                                                                        @if(!empty($value['access']['view']))
                                                                                            <input type="checkbox"
                                                                                                   value="{{join(',',$value['access']['view'])}}"
                                                                                                   name="access[]"
                                                                                                   @if(in_array_any( $value['access']['view'], $data->admin_access??[] ))
                                                                                                   checked
                                                                                                @endif
                                                                                            />
                                                                                        @endif
                                                                                    </td>
                                                                                    <td data-label="Add">
                                                                                        @if(!empty($value['access']['add']))
                                                                                            <input type="checkbox"
                                                                                                   value="{{join(',',$value['access']['add'])}}"
                                                                                                   name="access[]"

                                                                                                   @if(in_array_any($value['access']['add'], $data->admin_access??[] ))
                                                                                                   checked
                                                                                                @endif
                                                                                            />
                                                                                        @endif
                                                                                    </td>
                                                                                    <td data-label="Edit">
                                                                                        @if(!empty($value['access']['edit']))
                                                                                            <input type="checkbox"
                                                                                                   value="{{join(',',$value['access']['edit'])}}"
                                                                                                   name="access[]"
                                                                                                   @if(in_array_any($value['access']['edit'], $data->admin_access??[]))
                                                                                                   checked
                                                                                                @endif/>
                                                                                        @endif
                                                                                    </td>

                                                                                    <td data-label="Delete">
                                                                                        @if(!empty($value['access']['delete']))
                                                                                            <input type="checkbox"
                                                                                                   value="{{join(',',$value['access']['delete'])}}"
                                                                                                   name="access[]"
                                                                                                   @if(in_array_any( $value['access']['delete'], $data->admin_access??[]))
                                                                                                   checked
                                                                                                @endif
                                                                                            />
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>


                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">@lang('Close')</button>
                                                        <button type="submit"
                                                                class="btn btn-success">@lang('Update')</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <!-- Modal for Add button -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="myModalLabel">@lang('Manage Admin Role')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <form role="form" method="POST" class="actionRoute" action="{{route('admin.storeStaff')}}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-dark"> {{trans('Name')}} :</label>
                                <input class="form-control " name="name"
                                       placeholder="{{trans('Name')}}" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> {{trans('Username')}} :</label>
                                <input class="form-control " name="username"
                                       placeholder="{{trans('Username')}}" value="{{old('username')}}"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> {{trans('E-Mail')}} :</label>
                                <input class="form-control " name="email"
                                       placeholder="Email Address" value="{{old('email')}}"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> {{trans('Phone')}} :</label>
                                <input class="form-control " name="phone"
                                       placeholder="{{trans('Mobile Number')}}" value="{{old('phone')}}"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> {{trans('Password')}} :</label>
                                <input type="password" name="password" placeholder="Password"
                                       class="form-control " value="{{old('password')}}" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> {{trans('Select Status')}} :</label>
                                <select name="status" id="event-status"
                                        class="form-control " required>
                                    <option value="1" @if(old('status') == '1') selected @endif>
                                        {{trans('Active')}}
                                    </option>
                                    <option value="0" @if(old('status') == '0') selected @endif>
                                        {{trans('DeActive')}}
                                    </option>
                                </select>
                                <br>
                            </div>


                            <div class="form-group col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between text-center">
                                        <h5 class="card-title text-center">{{trans('Accessibility')}}</h5>
                                    </div>

                                    <div class="card-body select-all-access">
                                        <div class="form-group">
                                            <label><input type="checkbox" class="selectAll"
                                                          name="accessAll"> {{trans('Select All')}}</label>
                                        </div>

                                        <table class=" table table-hover table-striped table-bordered text-center">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="text-left">@lang('Permissions')</th>
                                                <th>@lang('View')</th>
                                                <th>@lang('Add')</th>
                                                <th>@lang('Edit')</th>
                                                <th>@lang('Delete')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(config('role') as $key => $value)
                                                <tr>
                                                    <td data-label="Permissions"
                                                        class="text-left">{{$value['label']}}</td>
                                                    <td data-label="View">
                                                        @if(!empty($value['access']['view']))
                                                            <input type="checkbox"
                                                                   value="{{join(",",$value['access']['view'])}}"
                                                                   name="access[]"/>
                                                        @endif
                                                    </td>
                                                    <td data-label="Add">
                                                        @if(!empty($value['access']['add']))
                                                            <input type="checkbox"
                                                                   value="{{join(",",$value['access']['add'])}}"
                                                                   name="access[]"/>
                                                        @endif
                                                    </td>
                                                    <td data-label="Edit">
                                                        @if(!empty($value['access']['edit']))
                                                            <input type="checkbox"
                                                                   value="{{join(",",$value['access']['edit'])}}"
                                                                   name="access[]"/>
                                                        @endif
                                                    </td>
                                                    <td data-label="Delete">
                                                        @if(!empty($value['access']['delete']))
                                                            <input type="checkbox"
                                                                   value="{{join(",",$value['access']['delete'])}}"
                                                                   name="access[]"/>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-success">@lang('Save')</button>
                    </div>

                </form>


            </div>
        </div>
    </div>


@endsection

@push('js')

    <script>
        $(document).ready(function () {
            "use strict";
            $('.selectAll').on('click', function () {
                if ($(this).is(':checked')) {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').attr('checked', 'checked')
                } else {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').removeAttr('checked')
                }
            })
        })

    </script>
@endpush
