@extends('admin.layouts.app')
@section('title',__($title))
@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <form action="{{ route('admin.ticket') }}" method="get">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" name="ticket" value="{{@request()->ticket}}" class="form-control"
                               placeholder="@lang('Ticket No')">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="email" value="{{@request()->email}}"
                               class="form-control"
                               placeholder="@lang('Email')">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="">@lang('All Ticket')</option>
                            <option value="0"
                                    @if(@request()->status == '0') selected @endif>@lang('Open Ticket')</option>
                            <option value="1"
                                    @if(@request()->status == '1') selected @endif>@lang('Answered Ticket')</option>
                            <option value="2"
                                    @if(@request()->status == '2') selected @endif>@lang('Replied Ticket')</option>
                            <option value="3"
                                    @if(@request()->status == '3') selected @endif>@lang('Closed Ticket')</option>
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
                        <th scope="col">@lang('Subject')</th>
                        <th scope="col">@lang('User')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Last Reply')</th>
                        @if(adminAccessRoute(config('role.support_ticket.access.view')))
                        <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tickets as $key => $ticket)
                        <tr>
                            <td data-label="Subject">
                                <a href="{{ route('admin.ticket.view', $ticket->id) }}" class="font-weight-bold"
                                   target="_blank">
                                    [{{ trans('Ticket#').$ticket->ticket }}] {{ $ticket->subject }} </a>
                            </td>

                            <td data-label="Submitted By">
                                @if($ticket->user_id)
                                    <a href="{{ route('admin.user-edit', $ticket->user_id)}}"
                                       target="_blank"> {{$ticket->user->fullname}}</a>
                                @else
                                    <p class="font-weight-bold"> {{$ticket->name}}</p>
                                @endif
                            </td>
                            <td data-label="@lang('Status')">
                                @if($ticket->status == 0)
                                    <span class="badge badge-pill badge-success">@lang('Open')</span>
                                @elseif($ticket->status == 1)
                                    <span class="badge badge-pill badge-primary">@lang('Answered')</span>
                                @elseif($ticket->status == 2)
                                    <span
                                        class="badge badge-pill badge-warning">@lang('Customer Reply')</span>
                                @elseif($ticket->status == 3)
                                    <span class="badge badge-pill badge-dark">@lang('Closed')</span>
                                @endif
                            </td>

                            <td data-label="@lang('Last Reply')">
                                {{diffForHumans($ticket->last_reply) }}
                            </td>

                            @if(adminAccessRoute(config('role.support_ticket.access.view')))
                            <td data-label="Action">
                                <a href="{{ route('admin.ticket.view', $ticket->id) }}"
                                   class="btn btn-sm btn-outline-info"
                                   data-toggle="tooltip" title="" data-original-title="Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">
                                <p class="text-dark">@lang($empty_message)</p>
                            </td>
                        </tr>

                    @endforelse
                    </tbody>
                </table>
                {{ $tickets->appends($_GET)->links('partials.pagination') }}
            </div>
        </div>
    </div>

@endsection


@push('js')
    <script>
        $(document).ready(function () {
            $('select[name=status]').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush
