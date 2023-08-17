@extends('admin.layouts.app')
@section('title')
    @lang('Result History')
@endsection

@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{ route('admin.searchResult') }}" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="search" value="{{@request()->search}}" class="form-control"
                                       placeholder="@lang('Questions or teams name')">
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
                        <th>@lang('Question')</th>
                        <th class="text-center">@lang('Match')</th>
                        <th>@lang('End Time')</th>
                        <th>@lang('Predictions')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($gameQuestions as $key => $item)
                        <tr>
                            <td data-label="@lang('SL No.')">{{++$key}}</td>
                            <td data-label="@lang('Question')">@lang($item->name)</td>
                            <td data-label="@lang('Match')">
                                <div class="d-lg-flex d-block align-items-center ">
                                    <div class="mr-3 cursor-pointer"
                                         title="{{optional($item->gameMatch)->gameTeam1->name}}">
                                        <small
                                            class="text-dark font-weight-bold">{{shortName(optional($item->gameMatch)->gameTeam1->name)}}</small>
                                    </div>
                                    <div class="mr-2 cursor-pointer"
                                         title="{{optional($item->gameMatch)->gameTeam1->name}}">
                                        <img
                                            src="{{ getFile(config('location.team.path') . optional($item->gameMatch)->gameTeam1->image) }}"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <small class="font-italic mb-0 font-16 ">@lang('vs')</small>

                                    <div class="mr-3 ml-2 cursor-pointer"
                                         title="{{optional($item->gameMatch)->gameTeam2->name}}">
                                        <img
                                            src="{{ getFile(config('location.team.path') . optional($item->gameMatch)->gameTeam2->image) }}"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <div class="cursor-pointer" title="{{optional($item->gameMatch)->gameTeam2->name}}">
                                        <small
                                            class="text-dark font-weight-bold">{{shortName(optional($item->gameMatch)->gameTeam2->name)}}</small>
                                    </div>
                                </div>
                            </td>
                            <td data-label="@lang('End Time')">
                                {{ dateTime($item->end_time, 'd M Y h:i A') }}
                            </td>
                            <td data-label="@lang('Predictions')"><span
                                    class="badge badge-success">{{$item->bet_invest_log_count}}</span></td>
                            <td data-label="@lang('Action')">

                                <a href="{{route('admin.resultWinner',$item->id)}}">
                                    <button type="button"
                                            class="btn btn-outline-dark btn-sm optionInfo"
                                            title="@lang('Select Winner')">
                                        <i class="fa fa-eye"
                                           aria-hidden="true"></i>
                                    </button>
                                </a>


                                <button type="button" class="btn btn-sm btn-outline-primary editBtn"
                                        data-resource="{{$item}}"
                                        data-action="{{ route('admin.updateQuestion', $item->id) }}"
                                        data-target="#edit-modal"
                                        data-toggle="modal" data-backdrop="static"
                                        title="@lang('Edit Question')" {{($item->result == 1)?'disabled':''}}>
                                    <i class="fa fa-edit"
                                       aria-hidden="true"></i>
                                </button>


                                @if($item->result == 0)
                                    <button type="button" class="btn btn-sm btn-outline-danger refundQuestion"
                                            data-action="{{ route('admin.refundQuestion', $item->id) }}"
                                            data-target="#refundQuestion-Modal"
                                            data-toggle="modal" data-backdrop="static"
                                            title="@lang('Refund Bet')">
                                        <i class="fa fa-paper-plane"
                                           aria-hidden="true"></i>
                                    </button>
                                @endif



                                <a href="{{route('admin.betUser',$item->id)}}">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-success investLogList">
                                        <i class="fa fa-info-circle"></i></button>
                                </a>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                {{$gameQuestions->appends(@$search)->links('partials.pagination')}}
            </div>
        </div>
    </div>
    {{-- Edit MODAL --}}
    <div id="editModal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Edit Question')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="questionId" name="questionId" value="">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input type="text" class="form-control editName" name="name" value="" required>
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-dark">@lang('Status') </label>
                            <select id="editStatus" class="form-control editStatus"
                                    name="status" required>
                                <option value="">@lang('Select Status')</option>
                                <option value="1">@lang('Active')</option>
                                <option value="0">@lang('Pending')</option>
                                <option value="2">@lang('Closed')</option>
                            </select>
                            @error('status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>@lang('End Date')</label>
                            <input type="datetime-local" class="form-control editTime" name="end_time"
                                   id="editEndDate" required>
                            @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Refund MODAL --}}
    <div id="refundQuestion-Modal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Refund Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure to refund this?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('No')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('style')
    <script src="{{ asset('assets/admin/js/fontawesome/fontawesomepro.js') }}"></script>
@endpush
@push('js')
    <script>
        'use script'
        $(document).on('click', '.editBtn', function () {
            var modal = $('#editModal');
            var obj = $(this).data('resource');
            modal.find('input[name=name]').val(obj.name);
            $('.questionId').val(obj.id);
            $('#editStatus').val(obj.status);
            $('#editEndDate').val(obj.end_time);
            modal.find('form').attr('action', $(this).data('action'));
            modal.modal('show');
        });

        $(document).on('click', '.refundQuestion', function () {
            var modal = $('#refundQuestion-Modal');
            modal.find('form').attr('action', $(this).data('action'));
            modal.modal('show');
        });
    </script>
@endpush
