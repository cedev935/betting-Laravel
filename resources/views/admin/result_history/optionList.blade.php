@extends('admin.layouts.app')
@section('title')
    @lang($gameQuestion->name)
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4  m-md-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th>@lang('SL No.')</th>
                        <th>@lang('Options')</th>
                        <th>@lang('Ratio')</th>
                        <th>@lang('Total Prediction')</th>
                        <th class="text-center">@lang('Status')</th>
                        @if(adminAccessRoute(config('role.manage_result.access.edit')))
                            <th class="text-center">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($gameQuestion->gameOptions as $key => $item)
                        <tr>
                            <td data-label="@lang('SL No.')">{{++$key}}</td>
                            <td data-label="@lang('Options')">@lang($item->option_name)</td>
                            <td data-label="@lang('Ratio')">@lang($item->ratio)</td>
                            <td data-label="@lang('Total Prediction')">
                                <span class="badge badge-success">{{count($item->betInvestLog)}}</span>
                            </td>
                            <td data-label="@lang('Status')" class="text-lg-center text-right">
                                @if($item->status == 1)
                                    <span class="badge badge-light">
                                         <i class="fa fa-circle text-warning warning font-12"></i> @lang('Pending')</span>
                                @elseif($item->status == 2)
                                    <span class="badge badge-light">
                                        <i class="fa fa-circle text-success success font-12"></i> @lang('Win')</span>
                                @elseif($item->status == 0)
                                    <span class="badge badge-light">
                                        <i class="fa fa-circle text-danger danger font-12"></i> @lang('DeActive')</span>
                                @elseif($item->status == -2)
                                    <span class="badge badge-light">
                                        <i class="fa fa-circle text-danger danger font-12"></i> @lang('Lost')</span>
                                @elseif($item->status == 3)
                                    <span class="badge badge-light">
                                        <i class="fa fa-circle text-danger danger font-12"></i> @lang('Refunded')</span>
                                @endif
                            </td>
                            @if(adminAccessRoute(config('role.manage_result.access.edit')))
                                <td data-label="@lang('Action')" class="text-center">
                                    <button type="button" data-id="{{$item->id}}"
                                            data-route="{{route('admin.makeWinner')}}" data-target="#makeWinner"
                                            data-toggle="modal"
                                            class="btn btn-sm btn-outline-primary makeWinner" {{($gameQuestion->result == 1)?'disabled':''}}>
                                        <i class="fa fa-paper-plane"></i></button>
                                </td>
                            @endif
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Make Winner MODAL --}}
    <div id="makeWinner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Make Winner')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you want to make winner this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="winnerRoute">
                        @csrf
                        @method('post')
                        <input type="hidden" name="optionId" value="" class="optionId">
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
@endpush
@push('js')
    <script>
        'use script'
        $(document).ready(function () {

            $('.makeWinner').on('click', function () {
                var route = $(this).data('route');
                $('.optionId').val($(this).data('id'));
                $('.winnerRoute').attr('action', route)
            });
        })
    </script>
@endpush
