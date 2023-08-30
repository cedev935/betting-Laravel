@extends('admin.layouts.app')
@section('title',$page_title)

@section('content')

    <div class="card card-primary card-form m-0 m-md-4 my-4 m-md-0">
        <div class="card-body">

            <div class="row justify-content-between mb-3">

                <div class="col-md-4">
                    <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-sm btn-primary"><i
                            class="fa fa-plus-circle"></i> @lang('Add New Key') </button>
                </div>


                <div class="col-md-5">
                    <div class="input-group has_append">
                        <select class="form-control select-language" required>
                            <option value="">@lang('Import Keywords')</option>
                            @foreach($list_lang as $data)
                                <option value="{{$data->id}}"
                                        @if($data->id == $lang->id) style="display: none" @endif>{{$data->name}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary import-language">@lang('Import Now')</button>
                        </div>
                    </div>

                    <small
                        class="text-danger">@lang("If you import keywords from another language, Your present `$lang->name` all keywords will remove.")
                    </small>
                </div>

            </div>


            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered no-wrap">
                    <thead class="thead-primary">
                    <tr>
                        <th scope="col">@lang('Key')
                        </th>
                        <th scope="col" class="text-left">
                            {{$lang->name}}
                        </th>
                        <th scope="col" class="w-85">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($json as $k => $langValue)
                        <tr>
                            <td data-label="@lang('key')">{{$k}}</td>
                            <td data-label="@lang('Value')" class="text-left ">{{$langValue}}</td>


                            <td data-label="@lang('Action')">
                                <a href="javascript:void(0)"
                                   data-target="#editModal"
                                   data-toggle="modal"
                                   data-title="{{$k}}"
                                   data-key="{{$k}}"
                                   data-value="{{$langValue}}"
                                   class="editModal btn btn-primary btn-sm "
                                   data-original-title="@lang('Edit')">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>

                                <a href="javascript:void(0)"
                                   data-key="{{$k}}"
                                   data-value="{{$langValue}}"
                                   data-toggle="modal" data-target="#deleteModal"
                                   class="btn btn-danger btn-sm deleteKey"
                                   data-original-title="@lang('Remove')">
                                    <i class="fa fa-times-circle"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


        </div>
    </div>



    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="myModalLabel">@lang('Edit')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>

                <form action="{{route('admin.language.updateKey',$lang->id)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group ">
                            <label for="inputName" class="control-label font-weight-bold form-title"></label>

                            <input type="text" class="form-control form-control-lg" name="value"
                                   placeholder="Vale" value="">

                        </div>
                        <input type="hidden" name="key">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Modal for DELETE -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="myModalLabel"><i class='fa fa-trash'></i> @lang('Delete !')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class="modal-body">
                    <strong>@lang('Are you sure you want to Delete ?')</strong>
                </div>
                <form action="{{route('admin.language.deleteKey',$lang->id)}}" method="post">
                    @csrf
                    @method('delete')

                    <input type="hidden" name="key">
                    <input type="hidden" name="value">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-danger ">@lang('Delete')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="myModalLabel"> @lang('Add New')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>

                <form action="{{route('admin.language.storeKey',$lang->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="key" class="control-label font-weight-bold">@lang('Key')</label>

                            <input type="text" class="form-control form-control-lg " id="key" name="key"
                                   placeholder="" value="{{old('key')}}">

                        </div>
                        <div class="form-group">
                            <label for="value" class="control-label font-weight-bold">@lang('Value')</label>
                            <input type="text" class="form-control form-control-lg " id="value" name="value"
                                   placeholder="" value="{{old('value')}}">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary"> @lang('Save')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection

@push('style-lib')
    <link href="{{asset('assets/admin/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script>
        "use strict";
        $(document).ready(function (e) {
            $('#zero_config').DataTable();
        });

        $(document).on('click', '.deleteKey', function () {
            var modal = $('#deleteModal');
            modal.find('input[name=key]').val($(this).data('key'));
            modal.find('input[name=value]').val($(this).data('value'));
        });

        $(document).on('click', '.editModal', function () {
            var modal = $('#editModal');
            modal.find('.form-title').text($(this).data('title'));
            modal.find('input[name=key]').val($(this).data('key'));
            modal.find('input[name=value]').val($(this).data('value'));
        });


        $(document).on('click', '.import-language', function () {
            var id = $('.select-language').val();

            if (id == '') {
                Notiflix.Notify.Failure("{{trans('Please Select a language to Import')}}");
                return 0;
            } else {
                $.ajax({
                    type: "post",
                    url: "{{route('admin.language.importJson')}}",
                    data: {
                        id: id,
                        myLangid: "{{$lang->id}}",
                        _token: "{{csrf_token()}}"
                    },
                    success: function (data) {

                        if (data == 'success') {
                            Notiflix.Notify.Success("{{trans('Import Data Successfully')}}");

                            window.location.href = "{{url()->current()}}"
                        }
                    }
                    ,
                    error: function (res) {

                    }
                });
            }
        });


        $(document).ready(function () {
            $('select').select2({
                selectOnClose: true
            });
        });
    </script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{trans($error)}}");
            @endforeach
        </script>
    @endif


@endpush
