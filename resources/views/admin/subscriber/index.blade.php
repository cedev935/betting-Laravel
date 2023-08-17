@extends('admin.layouts.app')
@section('title', $page_title)



@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(adminAccessRoute(config('role.subscriber.access.view')))
            <a href="{{route('admin.subscriber.sendEmail')}}"
               class="btn btn-primary mb-3 float-right" >
               @lang('Send Email')
            </a>
            @endif


            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('SL')</th>
                        <th scope="col">@lang('Email')</th>
                        <th scope="col">@lang('Joined')</th>
                        @if(adminAccessRoute(config('role.subscriber.access.delete')))
                        <th scope="col">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($subscribers as $subscriber)
                        <tr>
                            <td data-label="@lang('SL.')">{{loopIndex($subscribers) + $loop->index	 }}</td>
                            <td data-label="@lang('Email')">{{ $subscriber->email }}</td>
                            <td data-label="@lang('Joined')">{{ dateTime($subscriber->created_at) }}</td>

                            @if(adminAccessRoute(config('role.subscriber.access.delete')))
                            <td data-label="@lang('Action')">
                                <a href="javascript:void(0)"
                                   data-id="{{ $subscriber->id }}"
                                   data-email="{{ $subscriber->email }}"
                                   class="btn btn-danger removeModalBtn" data-toggle="tooltip" title=""
                                   data-original-title="@lang('Remove')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="9">@lang('No Subscriber Found!')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$subscribers->links('partials.pagination')}}


            </div>
        </div>
    </div>




    <div class="modal fade" id="removeModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Are you sure want to remove?')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.subscriber.remove') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="subscriber">
                        <p><span class="font-weight-bold subscriber-email"></span> @lang('will be removed.')</p>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-danger">@lang('Remove')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


@push('js')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.removeModalBtn').on('click', function () {
                $('#removeModal').find('input[name=subscriber]').val($(this).data('id'));
                $('#removeModal').find('.subscriber-email').text($(this).data('email'));
                $('#removeModal').modal('show');
            });
        });
    </script>
@endpush
