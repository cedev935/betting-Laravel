@extends($theme.'layouts.user')
@section('title',trans($title))
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card secbg form-block p-0 br-4">
                <div class="card-body">
                    <form action="{{ route('user.payout.history.search') }}" method="get">
                        <div class="row justify-content-between">
                            <div class="col-md-4">
                                <div class="form-group input-box mb-2">
                                    <input type="text" name="name" value="{{@request()->name}}"
                                           class="form-control"
                                           placeholder="@lang('Type Here')">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group input-box mb-2">
                                    <select name="status" class="form-control">
                                        <option value="">@lang('All Payment')</option>
                                        <option value="1"
                                                @if(@request()->status == '1') selected @endif>@lang('Pending Payment')</option>
                                        <option value="2"
                                                @if(@request()->status == '2') selected @endif>@lang('Complete Payment')</option>
                                        <option value="3"
                                                @if(@request()->status == '3') selected @endif>@lang('Rejected Payment')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group input-box mb-2">
                                    <input type="date" class="form-control" name="date_time"
                                           id="datepicker"/>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group mb-2 h-fill">
                                    <button type="submit" class="btn-custom w-100">
                                        <i
                                            class="fas fa-search"></i> @lang('Search')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card secbg ">
                <div class="card-body ">

                    <div class="table-parent table-responsive m-0">
                        <table class="table table-striped " id="service-table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">@lang('Trx ID')</th>
                                <th scope="col">@lang('Gateway')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Charge')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Time')</th>
                                <th scope="col">@lang('Detail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($payoutLog as $item)
                                <tr>
                                    <td data-label="#@lang('Trx ID')">{{$item->trx_id}}</td>
                                    <td data-label="@lang('Gateway')" class="d-initial">
                                        <strong>@lang(optional($item->method)->name)</strong>
                                    </td>
                                    <td data-label="@lang('Amount')">
                                        <strong>{{getAmount($item->amount)}} @lang($basic->currency)</strong>
                                    </td>
                                    <td data-label="@lang('Charge')">
                                        <strong>{{getAmount($item->charge)}} @lang($basic->currency)</strong>
                                    </td>

                                    <td data-label="@lang('Status')">
                                        @if($item->status == 1)
                                            <span class="badge bg-warning">@lang('Pending')</span>
                                        @elseif($item->status == 2)
                                            <span class="badge bg-success">@lang('Complete')</span>
                                        @elseif($item->status == 3)
                                            <span class="badge bg-danger">@lang('Cancel')</span>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Time')">
                                        {{ dateTime($item->created_at, 'd M Y h:i A') }}
                                    </td>
                                    <td data-label="@lang('Detail')">
                                        <button type="button" class="action-btn infoButton "
                                                data-information="{{json_encode($item->information)}}"
                                                data-feedback="{{$item->feedback}}"
                                                data-trx_id="{{ $item->trx_id }}"
                                                data-amount="{{ $item->amount }}"
                                                data-charge="{{ $item->charge }}"
                                                data-payable_amount="{{ $item->net_amount }}"><i
                                                class="fa fa-info-circle"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="100%">{{trans('No Data Found!')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                    {{ $payoutLog->appends($_GET)->links($theme.'partials.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <div id="infoModal" class="modal fade" tabindex="-1" data-backdrop="static" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-block">

                <div class="modal-header">
                    <h4 class="modal-title">@lang('Details')</h4>
                    <button type="button" class="btn-close closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="payment-info">
                        <ul class="list-group ">
                            <li class="list-group-item bg-transparent">@lang('Transactions') : <span class="trx"></span>
                            </li>
                            <li class="list-group-item bg-transparent">@lang('Admin Feedback') : <span
                                    class="feedback"></span></li>
                        </ul>
                    </div>
                    <div class="payment-info">
                        <div class="payout-detail">

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class=" btn-custom mb-2 me-3 closeModal"
                            data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script>
        "use strict";

        $(document).ready(function () {
            $('.infoButton').on('click', function () {
                var infoModal = $('#infoModal');
                infoModal.find('.trx').text($(this).data('trx_id'));
                infoModal.find('.feedback').text($(this).data('feedback'));
                var list = [];
                var information = Object.entries($(this).data('information'));

                var ImgPath = "{{asset(config('location.withdrawLog.path'))}}/";
                var result = ``;
                for (var i = 0; i < information.length; i++) {
                    // if (information[i][1].type == 'file') {
                    //     result += `<li class="list-group-item bg-transparent">
                    //                         <span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> : <img class="w-100"src="${ImgPath}/${information[i][1].fieldValue}" alt="..." class="w-100">
                    //                     </li>`;
                    // } else {
                    //     result += `<li class="list-group-item bg-transparent">
                    //                         <span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${information[i][1].fieldValue}</span>
                    //                     </li>`;
                    // }

                    if (information[i][1].type == 'file') {
                        result += `<li class="list-group-item bg-transparent">
                                            <span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> : <img class="w-100"src="${ImgPath}/${information[i][1].fieldValue??information[i][1].field_name}" alt="..." class="w-100">
                                        </li>`;
                    } else {
                        result += `<li class="list-group-item bg-transparent">
                                            <span class="font-weight-bold "> ${information[i][0].replaceAll('_', " ")} </span> : <span class="font-weight-bold ml-3">${information[i][1].fieldValue ?? information[i][1].field_name}</span>
                                        </li>`;
                    }
                }

                if (result) {
                    infoModal.find('.payout-detail').html(`<br><strong class="my-3">@lang('Payment Information')</strong>  ${result}`);
                } else {
                    infoModal.find('.payout-detail').html(`${result}`);
                }
                infoModal.modal('show');
            });


            $('.closeModal').on('click', function (e) {
                $("#infoModal").modal("hide");
            });
        });

    </script>
@endpush
