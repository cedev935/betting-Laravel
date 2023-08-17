@extends('admin.layouts.app')
@section('title')
    @lang("Transaction")
@endsection
@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{route('admin.transaction.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="transaction_id" value="{{@request()->transaction_id}}" class="form-control get-trx-id"
                                       placeholder="@lang('Search for Transaction ID')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="user_name" value="{{@request()->user_name}}" class="form-control get-username"
                                       placeholder="@lang('Username')">
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="remark" value="{{@request()->remark}}" class="form-control get-service"
                                       placeholder="@lang('Remark')">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn waves-effect waves-light btn-primary"><i class="fas fa-search"></i> @lang('Search')</button>
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
                    <th scope="col">@lang('No.')</th>
                    <th scope="col">@lang('TRX')</th>
                    <th scope="col">@lang('User')</th>
                    <th scope="col">@lang('Amount')</th>
                    <th scope="col">@lang('Detail')</th>
                    <th scope="col">@lang('Date - Time')</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transaction as $k => $row)
                    <tr>
                        <td data-label="@lang('No.')">{{loopIndex($transaction) + $k}}</td>
                        <td data-label="@lang('TRX')">@lang($row->trx_id)</td>
                        <td data-label="@lang('User')">
                            <a href="{{route('admin.user-edit',$row->user_id)}}">
                                <div class="d-lg-flex d-block align-items-center ">
                                    <div class="mr-3"><img src="{{getFile(config('location.user.path').optional($row->user)->image) }}" alt="user" class="rounded-circle" width="45" height="45"></div>
                                    <div class="">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($row->user)->username)</h5>
                                        <span class="text-muted font-14">{{optional($row->user)->email}}</span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td data-label="@lang('Amount')"> <span class="text-{{($row->trx_type == "+") ? 'success' :'danger'}}">{{config('basic.currency_symbol')}}{{getAmount($row->amount, config('basic.fraction_number'))}}</span></td>
                        <td data-label="@lang('Detail')">@lang($row->remarks)</td>
                        <td data-label="@lang('Date - Time')">{{dateTime($row->created_at, 'd M, Y h:i A')}}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center text-danger" colspan="8">@lang('No User Data')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $transaction->links('partials.pagination') }}
        </div>
    </div>
@endsection

@push('js')
@endpush
