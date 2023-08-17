@extends($theme.'layouts.user')
@section('title',trans($title))
@section('content')

    <div class="row justify-content-between">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('user.referral.bonus.search')}}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-box mb-2">
                                    <input type="text" name="search_user"
                                           value="{{@request()->search_user}}"
                                           class="form-control"
                                           placeholder="@lang('Search User')">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-box mb-2">
                                    <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="input-box mb-2 h-fill">
                                    <button type="submit" class="btn-custom w-100">
                                        <i class="fas fa-search"></i> @lang('Search')</button>
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
            <div class="card">
                <div class="card-body ">

                    <div class="table-parent table-responsive m-0">
                        <table class="table table-striped" id="service-table">
                            <thead>
                            <tr>
                                <th>@lang('SL No.')</th>
                                <th>@lang('Bonus From')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Remarks')</th>
                                <th>@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td data-label="@lang('SL No.')">
                                        {{loopIndex($transactions) + $loop->index}}</td>
                                    <td data-label="@lang('Bonus From')">@lang(optional($transaction->bonusBy)->fullname)</td>
                                    <td data-label="@lang('Amount')">
                                                    <span
                                                        class="font-weight-bold text-success">{{getAmount($transaction->amount, config('basic.fraction_number')). ' ' . trans(config('basic.currency'))}}</span>
                                    </td>

                                    <td data-label="@lang('Remarks')"> @lang($transaction->remarks)</td>
                                    <td data-label="@lang('Time')">
                                        {{ dateTime($transaction->created_at, 'd M Y h:i A') }}
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
                    {{ $transactions->appends($_GET)->links($theme.'partials.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
