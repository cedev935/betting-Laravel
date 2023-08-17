@extends('admin.layouts.app')
@section('title','Payout Details')

@section('content')
    <div class="container-fluid">
        @if($payout->last_error)
            <div class="bd-callout bd-callout-warning mb-3">
                <i class="fas fa-info-circle mr-2"></i> @lang('Last API Error:') {{$payout->last_error}}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">@lang("Payout Details")</h4>

                            <div>
                                @if($payout->status == 1)
                                    <a href="{{route('admin.payout-confirm',$payout->id)}}"
                                       data-target="#confirmModal" data-toggle="modal"
                                       class="btn btn-success btn-sm confirmButton"><i class="far fa-check-circle"></i> @lang('Confirm')</a>
                                    <a href="{{route('admin.payout-cancel',$payout->id)}}"
                                       data-toggle="modal"
                                       data-target="#confirmModal"
                                       class="btn btn-danger btn-sm confirmButton"><i class="far fa-times-circle"></i> @lang('Reject')</a>
                                @endif

                                <a href="{{route('admin.payout-log')}}" class="btn btn-sm btn-primary ml-2">
                                    <span><i class="fas fa-arrow-left"></i> @lang('Back')</span>
                                </a>

                            </div>

                        </div>

                        <hr>

                        <div class="p-4 border shadow-sm rounded">
                            <div class="row">
                                <div class="col-md-6 border-right">
                                    <ul class="list-style-none">
                                        <li class="my-2 border-bottom pb-3">
                                            <span class="font-weight-medium text-dark"><i
                                                    class="icon-info mr-2 text-primary"></i> @lang("Transaction"): <small
                                                    class="float-right">{{dateTime($payout->created_at)}} </small></span>
                                        </li>

                                        <li class="my-3 d-flex align-items-center">
                                            <span><i class="icon-check mr-2 text-primary"></i> @lang('Sender name :')</span>

                                            <a class="ml-3" href="{{route('admin.user-edit',$payout->user_id)}}">
                                                <div class="d-lg-flex d-block align-items-center ">
                                                    <div class="mr-1"><img
                                                            src="{{getFile(config('location.user.path').optional($payout->user)->image) }}"
                                                            alt="user" class="rounded-circle" width="45"
                                                            height="45"></div>
                                                    <div class="">
                                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($payout->user)->username)</h5>
                                                        <p class="text-muted mb-0 font-12 font-weight-medium">@lang(optional($payout->user)->email)</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="my-3">
                                            <span class="font-weight-bold text-dark"><i
                                                    class="icon-check mr-2 text-primary"></i> @lang("Payment method") : <span
                                                    class="font-weight-medium text-info">{{ __(optional($payout->method)->name) }}</span></span>
                                        </li>


                                        <li class="my-3">
                                            <span class="font-weight-medium text-dark"><i
                                                    class="icon-check mr-2 text-primary"></i> @lang('Transaction Id') : <span
                                                    class="font-weight-medium text-success">{{ __($payout->trx_id) }}</span></span>
                                        </li>

                                        <li class="my-3">
                                            <span><i class="icon-check mr-2 text-primary"></i> @lang('Status') :
                                                @if($payout->status == 1)
                                                    <span class="badge badge-pill badge-warning">@lang('Pending')</span>
                                                @elseif($payout->status == 2)
                                                    <span
                                                        class="badge badge-pill badge-success">@lang('Completed')</span>
                                                @elseif($payout->status == 3)
                                                    <span class="badge badge-pill badge-danger">@lang('Rejected')</span>
                                                @elseif($payout->status == 4)
                                                    <span class="badge badge-pill badge-danger">@lang('Failed')</span>
                                                @endif

                                            </span>
                                        </li>


                                        <li class="my-3">
                                            <span><i class="icon-check mr-2 text-primary"></i> @lang('Amount') : <span
                                                    class="font-weight-bold text-dark">{{ (getAmount($payout->amount,2)).' '.config('basic.currency') }}
                                                </span>
                                            </span>
                                        </li>

                                        <li class="my-3">
                                            <span><i class="icon-check mr-2 text-primary"></i> @lang('Charge') : <span
                                                    class="font-weight-bold text-danger">{{ (getAmount($payout->charge,2)).' '.config('basic.currency') }}
                                                </span>
                                            </span>
                                        </li>

                                        @if($payout->other_charge)
                                            <li class="my-3">
                                            <span><i class="icon-check mr-2 text-primary"></i> @lang('Charge') : <span
                                                    class="font-weight-bold text-danger">
                                                    {{ (getAmount($payout->other_charge,2)).' '.config('basic.currency') }}
                                                </span>
                                            </span>
                                            </li>
                                        @endif

                                        <li class="my-3">
                                            <span><i
                                                    class="icon-check mr-2 text-primary"></i> @lang('Total Amount') : <span
                                                    class="font-weight-bold text-dark">
                                                    {{ (getAmount($payout->net_amount,2)).' '.config('basic.currency') }}
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>


                                <div class="col-md-6 ">
                                    @if(isset($payout->information))
                                        <ul class="list-style-none border-bottom">
                                            <li class="my-2 border-bottom pb-3">
                                            <span class="font-weight-medium text-dark"><i
                                                    class="icon-user mr-2 text-primary"></i> @lang('Withdraw Information')</span>
                                            </li>


                                            <li class="my-3">
                                            <span><i class="icon-check mr-2 text-primary"></i> @lang('Bank Currency') : <span
                                                    class="font-weight-bold text-danger">{{ __($payout->currency_code) }}
                                                </span>
                                            </span>
                                            </li>

                                            @foreach($payout->information as $key => $value)
                                                <li class="my-3">
                                            <span><i class="icon-check mr-2 text-primary"></i> {{ __(snake2Title($key)) }} :

                                                <span>
														@if($value->type == 'file')

                                                        <img class="img-profile rounded-circle w-50"
                                                             src="{{getFile(config('location.withdrawLog.path').@$value->fieldValue??$value->field_name) }}">
                                                    @else
                                                        @if($key == 'amount')
                                                            <span class="font-weight-bold text-dark">
                                                                        {{getAmount(@$value->fieldValue??$value->field_name,8)}}
                                                            </span>
                                                        @else
                                                            <span class="font-weight-bold text-dark">
                                                                    {{ __(@$value->fieldValue??$value->field_name) }}
                                                            </span>
                                                        @endif
                                                    @endif
													</span>
                                            </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($payout->meta_field)
                                        <ul class="list-style-none mt-4">
                                            <li class="my-2 border-bottom pb-3">
                                            <span class="font-weight-medium text-dark"><i
                                                    class="icon-user mr-2 text-success"></i> @lang('Additional Information')</span>
                                            </li>

                                            @foreach($payout->meta_field as $key => $value)
                                                <li class="my-3">
                                            <span><i class="icon-check mr-2 text-success"></i> {{ __(snake2Title($key)) }} :
                                                <span class="font-weight-bold">{{ __($value->fieldValue) }}</span>
                                            </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if($payout->meta_field)
                                        <ul class="list-style-none mt-4">
                                            <li class="my-2 border-bottom pb-3">
                                            <span class="font-weight-medium text-dark"><i
                                                    class="icon-user mr-2 text-success"></i> @lang('Additional Information')</span>
                                            </li>

                                            @foreach($payout->meta_field as $key => $value)
                                                <li class="my-3">
                                            <span><i class="icon-check mr-2 text-success"></i> {{ __(snake2Title($key)) }} :
                                                <span class="font-weight-bold">{{ __($value->fieldValue) }}</span>
                                            </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif


                                    @if($payout->feedback)
                                        <ul class="list-style-none mt-4">
                                            <li class="my-2 border-bottom pb-3">
                                            <span class="font-weight-medium text-dark"><i
                                                    class="icon-user mr-2 text-success"></i> @lang('Feedback')</span>
                                            </li>

                                            <li class="my-3 text-dark">
                                                {{$payout->feedback}}
                                            </li>
                                        </ul>
                                    @endif

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-white bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel"><i
                            class="fas fa-info-circle"></i> @lang('Confirmation !')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="confirmForm">
                    <div class="modal-body text-center">
                        <p>@lang('Are you sure you want to confirm this action?')</p>
                        @csrf
                        <div class="form-group">
                            <label for="note" class="text-dark">@lang('Note') :</label>
                            <textarea name="feedback" rows="5" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark"
                                data-dismiss="modal">@lang('Close')</button>
                        <input type="submit" class="btn btn-primary" value="@lang('Confirm')">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
    <script>
        'use strict'
        $(document).on('click', '.confirmButton', function (e) {
            e.preventDefault();
            let submitUrl = $(this).attr('href');
            $('#confirmForm').attr('action', submitUrl)
        })
    </script>
@endpush
