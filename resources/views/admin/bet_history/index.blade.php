@extends('admin.layouts.app')
@section('title')
    @lang('Bet History')
@endsection

@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{ route('admin.searchBet') }}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="search" value="{{@request()->search}}" class="form-control"
                                       placeholder="@lang('Trx. or User email or username')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date_time" id="datepicker"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn w-100  btn-primary"><i
                                        class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card card-primary m-0 m-md-4  m-md-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th>@lang('SL No.')</th>
                        <th>@lang('Trx.')</th>
                        <th>@lang('User')</th>
                        <th>@lang('Prediction Amount')</th>
                        <th>@lang('Return Amount')</th>
                        <th>@lang('Charge')</th>
                        <th>@lang('Ratio')</th>
                        <th>@lang('Time')</th>
                        <th class="text-center">@lang('Status')</th>
                        <th class="text-center">@lang('More')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($betInvests as $key => $item)
                        <tr>
                            <td data-label="@lang('SL No.')">{{++$key}}</td>
                            <td data-label="@lang('Trx.')">{{$item->transaction_id}}</td>
                            <td data-label="@lang('User')">
                                <a href="{{route('admin.user-edit',$item->user_id)}}">
                                    <div class="d-lg-flex d-block align-items-center ">
                                        <div class="mr-3"><img
                                                src="{{getFile(config('location.user.path').optional($item->user)->image) }}"
                                                alt="user" class="rounded-circle" width="45" height="45"></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($item->user)->username)</h5>
                                            <span class="text-muted font-14">{{optional($item->user)->email}}</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td data-label="@lang('Prediction Amount')">{{config('basic.currency_symbol')}}@lang($item->invest_amount)</td>
                            <td data-label="@lang('Return Amount')">{{config('basic.currency_symbol')}}@lang($item->return_amount)</td>
                            <td data-label="@lang('Charge')">{{config('basic.currency_symbol')}}@lang($item->charge)</td>
                            <td data-label="@lang('Ratio')"> @lang($item->ratio)</td>
                            <td data-label="@lang('Time')">
                                {{ dateTime($item->created_at, 'd/m/Y H:i') }}
                            </td>
                            <td data-label="@lang('Status')" class="text-lg-center text-right">
                                @if($item->status == 0)
                                    <span class="badge badge-light"><i
                                            class="fa fa-circle text-warning warning font-12"></i>
                                        @lang('Processing')</span>
                                @elseif($item->status == 1)
                                    <span class="badge badge-light"><i
                                            class="fa fa-circle text-success success font-12"></i>
                                        @lang('Win')</span>
                                @elseif($item->status == -1)
                                    <span class="badge badge-light"><i class="fa fa-circle text-danger danger font-12"></i>
                                        @lang('Loss')</span>
                                @elseif($item->status == 2)
                                    <span class="badge badge-light"><i
                                            class="fa fa-circle text-danger danger font-12"></i>
                                        @lang('Refund')</span>
                                @endif

                            </td>
                            <td data-label="@lang('More')" class="text-center">
                                <button type="button" data-resource="{{$item->betInvestLog}}"
                                        data-target="#investLogList" data-toggle="modal"
                                        class="btn btn-sm btn-outline-success investLogList">
                                    <i class="fa fa-info-circle"></i></button>
                                <button type="button" data-id="{{$item->id}}" data-route="{{route('admin.refundBet')}}"
                                        data-target="#refund" data-toggle="modal"
                                        class="btn btn-sm btn-outline-primary refundBet" {{($item->status == 2 )?'disabled':''}} >
                                    <i class="fa fa-paper-plane"></i></button>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                {{$betInvests->appends(@$search)->links('partials.pagination')}}
            </div>
        </div>
    </div>

    {{-- Invest Log MODAL --}}
    <div class="modal fade" id="investLogList" role="dialog">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title service-title">Information</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">×
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('Match Name')</th>
                            <th scope="col">@lang('Category Name')</th>
                            <th scope="col">@lang('Tournament Name ')</th>
                            <th scope="col">@lang('Question Name')</th>
                            <th scope="col">@lang('Option Name')</th>
                            <th scope="col">@lang('Ratio')</th>
                            <th scope="col">@lang('Result')</th>
                        </tr>
                        </thead>
                        <tbody class="result-body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal"><span>@lang('Close')</span></button>
                </div>
            </div>
        </div>
    </div>

    {{-- Refund MODAL --}}
    <div id="refund" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Refund Amount')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you want to this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="refundRoute">
                        @csrf
                        @method('post')
                        <input type="hidden" name="betInvestId" value="" class="betInvestId">
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <script src="{{ asset('assets/admin/js/fontawesome/fontawesomepro.js') }}"></script>
@endpush
@push('js')
    <script>
        'use strict'
        $(document).on('click', '.refundBet', function () {
            $('.betInvestId').val($(this).data('id'));
            var route = $(this).data('route');
            $('.refundRoute').attr('action', route)
        });

        $(document).on('click', '.investLogList', function () {
            var obj = $(this).data('resource');
            var output = [];
            if (0 < obj.length) {
                obj.map(function (obj, i) {
                    var tr =
                        `<tr>
                        <td>${++i}</td>
                        <td>${(obj).match_name}</td>
                        <td>${obj.category_icon} ${obj.category_name}</td>
                        <td>${obj.tournament_name}</td>
                        <td>${obj.question_name}</td>
                        <td>${obj.option_name}</td>
                        <td>${obj.ratio}</td>
                        <td>
                            ${(obj.status == '0') ? ` <span class='badge badge-light'><i class="fa fa-circle text-warning warning font-12"></i> @lang('Processing')</span>` : ''}
                            ${(obj.status == '2') ? ` <span class='badge badge-light'><i class="fa fa-circle text-success success font-12"></i> @lang('Win')</span>` : ''}
                            ${(obj.status == '-2') ? ` <span class='badge badge-light'><i class="fa fa-circle text-danger danger font-12"></i> @lang('Lose')</span>` : ''}
                            ${(obj.status == '3') ? ` <span class='badge badge-light'><i class="fa fa-circle text-secondary secondary font-12"></i> @lang('Refunded')</span>` : ''}

                        </td>

                    </tr>`;

                    output[i] = tr;
                });

            } else {
                output[0] = `
                        <tr>
                            <td colspan="100%" class=""text-center>@lang('No Data Found')</td>
                        </tr>`;
            }

            $('.result-body').html(output);
        });
    </script>
@endpush
