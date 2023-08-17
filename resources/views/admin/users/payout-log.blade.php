@extends('admin.layouts.app')
@section('title')
    @lang($user->username)
@endsection
@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <form action="{{ route('admin.payout-log.search') }}" method="get">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="name" value="{{@request()->name}}" class="form-control"
                               placeholder="@lang('Email/ Username/ Trx')">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="">@lang('All Payment')</option>
                            <option value="1"
                                    @if(@request()->status == '1') selected @endif>@lang('Pending Payment')</option>
                            <option value="2"
                                    @if(@request()->status == '2') selected @endif>@lang('Complete Payment')</option>
                            <option value="3"
                                    @if(@request()->status == '3') selected @endif>@lang('Cancel Payment')</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input type="date" class="form-control" name="date_time" id="datepicker"/>
                    </div>
                </div>


                <div class="col-md-2">
                    <div class="form-group">
                        <button type="submit" class="btn waves-effect waves-light btn-primary"><i
                                class="fas fa-search"></i> @lang('Search')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>


    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('Date')</th>
                        <th scope="col">@lang('Trx Number')</th>
                        <th scope="col">@lang('Username')</th>
                        <th scope="col">@lang('Method')</th>
                        <th scope="col">@lang('Amount')</th>
                        <th scope="col">@lang('Charge')</th>
                        <th scope="col">@lang('Net Amount')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Detail')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($records as $key => $item)
                        <tr>
                            <td data-label="@lang('Date')"> {{ dateTime($item->created_at,'d M,Y H:i') }}</td>
                            <td data-label="@lang('Trx Number')"
                                class="font-weight-bold text-uppercase">{{ $item->trx_id }}</td>
                            <td data-label="@lang('Username')"><a
                                    href="{{route('admin.user-edit', $item->user_id)}}"
                                    target="_blank">{{ optional($item->user)->username }}</a>
                            </td>
                            <td data-label="@lang('Method')">{{ optional($item->method)->name }}</td>
                            <td data-label="@lang('Amount')"
                                class="font-weight-bold">{{ getAmount($item->amount ) }} {{ $basic->currency }}</td>
                            <td data-label="@lang('Charge')"
                                class="text-success">{{ getAmount($item->charge)}} {{ $basic->currency }}</td>
                            <td data-label="@lang('Net Amount')"
                                class="font-weight-bold">{{ getAmount($item->net_amount) }} {{$basic->currency}}</td>

                            <td data-label="@lang('Status')">
                                @if($item->status == 2)
                                    <span class="badge badge-success">@lang('Approved')</span>
                                @elseif($item->status == 1)
                                    <span class="badge badge-warning">@lang('Pending')</span>
                                @elseif($item->status == 3)
                                    <span class="badge badge-danger">@lang('Rejected')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Detail')">
                                @php
                                    $details = ($item->information != null) ? json_encode($item->information) : null;
                                @endphp
                                <button type="button" class="btn btn-primary btn-icon edit_button"
                                        data-toggle="modal" data-target="#myModal"
                                        data-route="{{route('admin.payout-action',$item->id)}}"
                                        data-feedback="{{$item->feedback}}"
                                        data-info="{{$details}}"
                                        data-id="{{$item->id}}"
                                        data-status="{{$item->status}}">
                                    @if(Request::routeIs('admin.payout-request'))
                                        <i class="fa fa-pencil-alt"></i>
                                    @else
                                        <i class="fa fa-eye"></i>
                                    @endif
                                </button>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">
                                <p class="text-dark">@lang('No Data Found')</p>
                            </td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>
                {{ $records->appends($_GET)->links('partials.pagination') }}
            </div>
        </div>
    </div>




    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="myModalLabel">@lang('Payout Information')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <form role="form" method="POST" class="actionRoute" action="" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <ul class="list-group withdraw-detail">
                        </ul>

                        @if(Request::routeIs('admin.payout-request'))
                            <div class="form-group addForm">

                            </div>
                        @endif

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')
                        </button>
                        @if(Request::routeIs('admin.payout-request'))
                            <input type="hidden" class="action_id" name="id">
                            <button type="submit" class="btn btn-primary" name="status"
                                    value="2">@lang('Approve')</button>
                            <button type="submit" class="btn btn-danger" name="status"
                                    value="3">@lang('Reject')</button>
                        @endif
                    </div>

                </form>


            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                $(document).on("click", '.edit_button', function (e) {
                    var id = $(this).data('id');
                    $(".action_id").val(id);
                    $(".actionRoute").attr('action', $(this).data('route'));
                    var details = Object.entries($(this).data('info'));
                    var list = [];
                    var ImgPath = "{{asset(config('location.withdrawLog.path'))}}";
                    details.map(function (item, i) {
                        if (item[1].type == 'file') {
                            var singleInfo = `<br><img src="${ImgPath}/${item[1].field_name}" alt="..." class="w-100">`;
                        } else {
                            var singleInfo = `<span class="font-weight-bold ml-3">${item[1].field_name}</span>  `;
                        }
                        list[i] = ` <li class="list-group-item"><span class="font-weight-bold "> ${item[0].replace('_', " ")} </span> : ${singleInfo}</li>`
                    });



                    if ($(this).data('status') != '1') {
                        list[details.length + 1] = `<li class="list-group-item"><span class="font-weight-bold">@lang('Admin Feedback')</span> : <span">${$(this).data('feedback')}</span></li>`;
                        $('.addForm').html(``)
                    } else {
                        list[details.length + 1] = ``;
                        $('.addForm').html(`
                                <div class="form-group">
                                <label for="feedback">@lang('feedback')</label>
                                <textarea class="form-control" name="feedback"></textarea>
                                </div>
                        `);
                    }

                    $('.withdraw-detail').html(list);
                });
            });
        })(jQuery);


        $(document).ready(function () {
            $('select').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush
