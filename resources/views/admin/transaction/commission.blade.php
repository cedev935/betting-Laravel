@extends('admin.layouts.app')
@section('title')
    @lang("Commissions")
@endsection
@section('content')

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{route('admin.commissions.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="user_name" value="{{@request()->user_name}}" class="form-control get-username"
                                       placeholder="@lang('Username')">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th>@lang('SL No.')</th>
                    <th>@lang('Username')</th>
                    <th>@lang('Bonus From')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Remarks')</th>
                    <th>@lang('Time')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $k => $transaction)
                    <tr>
                        <td data-label="@lang('No.')">{{loopIndex($transactions) + $k}}</td>
                        <td data-label="@lang('Username')">
                            <a href="{{route('admin.user-edit',$transaction->from_user_id)}}" target="_blank">
                                @lang($transaction->user->username)
                            </a>
                        </td>
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
                    <tr>
                        <td class="text-center text-danger" colspan="6">@lang('No User Data')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $transactions->links('partials.pagination') }}
        </div>
    </div>
@endsection

@push('js')
@endpush
