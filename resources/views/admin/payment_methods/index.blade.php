@extends('admin.layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <table class="table table-light-border table-md">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Status')</th>
                                @if(adminAccessRoute(config('role.payment_gateway.access.edit')))
                                    <th scope="col">@lang('Action')</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            @if(count($methods) > 0)
                                @foreach($methods as $method)
                                    <tr data-code="{{ $method->code }}">
                                        <td data-label="@lang('Name')">{{ $method->name }} </td>

                                        <td data-label="@lang('Status')" class="text-lg-center text-right">

                                            {!!  $method->status == 1 ? '<span class="badge badge-light"><i class="fa fa-circle text-success success font-12"></i>'.trans(' Active').'</span>' : '<span class="badge badge-light"><i class="fa fa-circle text-danger danger font-12"></i>'.trans(' Inactive').'</span>' !!}
                                        </td>


                                        @if(adminAccessRoute(config('role.payment_gateway.access.edit')))
                                            <td data-label="@lang('Action')">
                                                <a href="{{ route('admin.edit.payment.methods', $method->id) }}"
                                                   class="btn btn-primary btn-circle"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   data-original-title="@lang('Edit this Payment Methods info')">
                                                    <i class="fa fa-edit"></i></a>

                                                <button type="button"
                                                        data-code="{{$method->code}}"
                                                        data-status="{{$method->status}}"
                                                        data-message="{{($method->status == 0)?'Enable':'Disable'}}"
                                                        class="btn btn-sm btn-{{($method->status == 0)?'success':'danger'}}   btn-circle disableBtn"
                                                        data-toggle="modal" data-target="#disableModal"><i
                                                        class="fa fa-{{($method->status == 0)?'check':'ban'}}"></i>
                                                </button>

                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center text-danger" colspan="8">
                                        @lang('No Data Found')
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <h5>
                            <span class="text-primary">@lang('N.B:')</span>
                            @lang('Pull up or down the rows to sort the payment gateways order that how do you want to display the payment gateways in admin and user panel.')
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="disableModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><span class="messageShow"></span> @lang('Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.payment.methods.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p class="font-weight-bold">@lang('Are you sure to') <span
                                class="messageShow"></span> {{trans('this?')}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn waves-effect waves-light btn-dark"
                                data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn waves-effect waves-light btn-primary messageShow"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/jquery-ui.min.css') }}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/global/js/jquery-ui.min.js') }}"></script>
@endpush

@push('js')
    <script>
        "use strict";
        $(document).ready(function () {
            $("#sortable").sortable({
                update: function (event, ui) {
                    var methods = [];
                    $('#sortable tr').each(function (key, val) {
                        let methodCode = $(val).data('code');
                        methods.push(methodCode);
                    });

                    $.ajax({
                        'url': "{{ route('admin.sort.payment.methods') }}",
                        'method': "POST",
                        'data': {sort: methods}
                    })
                }
            });
            $("#sortable").disableSelection();
        });


        $('.disableBtn').on('click', function () {
            var status = $(this).data('status');
            $('.messageShow').text($(this).data('message'));
            var modal = $('#disableModal');
            modal.find('input[name=code]').val($(this).data('code'));
        });
    </script>
@endpush
