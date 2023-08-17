@extends($theme.'layouts.user')
@section('title')
    @lang('Bet History')
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body ">
                    <div class="table-parent table-responsive m-0">
                        <table class="table  table-striped" id="service-table">
                            <thead>
                            <tr>
                                <th>@lang('SL No.')</th>
                                <th>@lang('Invest Amount')</th>
                                <th>@lang('Return Amount')</th>
                                <th>@lang('Charge')</th>
                                <th>@lang('Ratio')</th>
                                <th class="text-center">@lang('Status')</th>
                                <th class="text-center">@lang('Information')</th>
                                <th>@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($betInvests as $key => $item)
                                <tr>
                                    <td data-label="@lang('SL No.')">{{++$key}}</td>
                                    <td data-label="@lang('Invest Amount')">{{config('basic.currency_symbol')}}@lang($item->invest_amount)</td>
                                    <td data-label="@lang('Return Amount')">{{config('basic.currency_symbol')}}@lang($item->return_amount)</td>
                                    <td data-label="@lang('Charge')">{{config('basic.currency_symbol')}}@lang($item->charge)</td>
                                    <td data-label="@lang('Ratio')"> @lang($item->ratio)</td>
                                    <td data-label="@lang('Status')" class="text-center">
                                        @if($item->status == 0)
                                            <span class="badge bg-warning">@lang('Processing')</span>
                                        @elseif($item->status == 1)
                                            <span class="badge bg-success">@lang('Win')</span>
                                        @elseif($item->status == -1)
                                            <span class="badge bg-danger">@lang('Loss')</span>
                                        @elseif($item->status == 2)
                                            <span class="badge bg-primary">@lang('Refund')</span>
                                        @endif

                                    </td>
                                    <td data-label="@lang('Information')" class="text-center">
                                        <button type="button" data-resource="{{$item->betInvestLog}}" data-bs-target="#investLogList" data-bs-toggle="modal" class="action-btn investLogList">
                                            <i class="fa fa-info-circle"></i></button>
                                    </td>
                                    <td data-label="@lang('Time')">
                                        {{ dateTime($item->created_at, 'd M Y h:i A') }}
                                    </td>
                                </tr>
                            @empty

                                <tr class="text-center">
                                    <td colspan="100%">{{__('No Data Found!')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $betInvests->appends($_GET)->links($theme.'partials.pagination') }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="investLogList" role="dialog">
        <div class="modal-dialog  modal-xl">
            <div class="modal-custom-content">
                <div class="modal-header modal-colored-header">
                    <h5 class="modal-title service-title">@lang('Information')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="service-table">
                        <thead class="thead-dark">
                        <tr>
                            <th>@lang('#')</th>
                            <th>@lang('Match Name')</th>
                            <th>@lang('Category Name')</th>
                            <th>@lang('Tournament Name')</th>
                            <th>@lang('Question Name')</th>
                            <th>@lang('Option Name')</th>
                            <th>@lang('Ratio')</th>
                            <th>@lang('Result')</th>
                        </tr>
                        </thead>
                        <tbody class="result-body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom me-2 mb-2"
                            data-bs-dismiss="modal"><span>@lang('Close')</span></button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <script src="{{ asset('assets/admin/js/fontawesome/fontawesomepro.js') }}"></script>
@endpush
@push('script')
    <script>
        'use strict'
        $(document).on('click', '.investLogList', function() {
           var obj = $(this).data('resource');
            var output = [];
            if (0 < obj.length) {
                obj.map(function(obj, i) {
                    var tr =
                    `<tr>
                        <td data-label="@lang('#')">${++i}</td>
                        <td data-label="@lang('Match Name')">${obj.match_name}</td>
                        <td data-label="@lang('Category Name')">${obj.category_icon} ${obj.category_name}</td>
                        <td data-label="@lang('Tournament Name')">${obj.tournament_name}</td>
                        <td data-label="@lang('Question Name')">${obj.question_name}</td>
                        <td data-label="@lang('Option Name')">${obj.option_name}</td>
                        <td data-label="@lang('Ratio')">${obj.ratio}</td>
                        <td data-label="@lang('Result')">
                            ${ (obj.status == '0') ?` <span class='badge bg-warning'>@lang('Processing')</span>` :''}
                            ${ (obj.status == '2') ?` <span class='badge bg-success'>@lang('Win')</span>` :''}
                            ${ (obj.status == '-2') ?` <span class='badge bg-danger'>@lang('Lose')</span>` :''}
                            ${ (obj.status == '3') ?` <span class='badge bg-secondary'>@lang('Refunded')</span>` :''}

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
