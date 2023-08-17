@extends('admin.layouts.app')
@section('title')
    @lang('Manage Match')
@endsection

@section('content')
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="{{ route('admin.searchMatch') }}" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="search" value="{{@request()->search}}" class="form-control"
                                       placeholder="@lang('Team name')">
                            </div>
                        </div>

                        <div class="col-md-2 mb-2">
                            <div class="form-group">
                                <select class="form-control" name="searchCategory">
                                    <option value="" disabled selected>@lang('Select Category')</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}"
                                                @if($item->id ==@request()->searchCategory) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <select class="form-control" name="searchTournament">
                                    <option value="" disabled selected>@lang('Select Tournament')</option>
                                    @foreach($tournaments as $tournament)
                                        <option value="{{$tournament->id}}"
                                                @if($tournament->id == @request()->searchTournament) selected @endif>
                                            {{$tournament->name}}
                                            <span>[{{optional($tournament->gameCategory)->name}}]</span>
                                        </option>
                                    @endforeach
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

        <div class="card-header bg-transparent">
            <div class="d-flex flex-wrap align-items-center justify-content-between">

                @if(adminAccessRoute(config('role.manage_game.access.add')))
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mr-2" data-target="#newModal"
                       data-toggle="modal">
                        <span><i class="fa fa-plus-circle"></i> @lang('Add New')</span>
                    </a>
                @endif

                @if(adminAccessRoute(config('role.manage_game.access.edit')))
                    <div class="dropdown text-right">
                        <button class="btn btn-sm  btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="fas fa-bars pr-2"></i> @lang('Action')</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_active">@lang('Active')</button>
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_inactive">@lang('DeActive')</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">
                            <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                   id="check-all">
                            <label for="check-all"></label>
                        </th>

                        <th scope="col" class="text-center">@lang('SL No.')</th>
                        <th scope="col" class="text-center">@lang('Match')</th>
                        <th scope="col">@lang('Active Question')</th>
                        <th scope="col">@lang('Tournament')</th>
                        <th scope="col">@lang('Category')</th>
                        <th scope="col">@lang('Start Date')</th>
                        <th scope="col" class="text-center">@lang('Status')</th>

                        @if(adminAccessRoute(config('role.manage_game.access.edit')))
                        <th scope="col" class="text-center">@lang('Locker')</th>
                            <th scope="col" class="text-center">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($matches as  $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" id="chk-{{ $item->id }}"
                                       class="form-check-input row-tic tic-check" name="check" value="{{$item->id}}"
                                       data-id="{{ $item->id }}">
                                <label for="chk-{{ $item->id }}"></label>
                            </td>

                            <td data-label="@lang('SL No.')" class="text-center">{{ $loop->index + 1 }}</td>
                            <td data-label="@lang('Match')">

                                <div class="d-lg-flex d-block align-items-center ">
                                    <div class="mr-3 cursor-pointer" title="{{optional($item->gameTeam1)->name}}">
                                        <small
                                            class="text-dark font-weight-bold">{{shortName(optional($item->gameTeam1)->name)}}</small>
                                    </div>
                                    <div class="mr-2 cursor-pointer" title="{{optional($item->gameTeam1)->name}}">
                                        <img
                                            src="{{ getFile(config('location.team.path') . optional($item->gameTeam1)->image) }}"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <small class="font-italic mb-0 font-16 ">@lang('vs')</small>

                                    <div class="mr-3 ml-2 cursor-pointer" title="{{optional($item->gameTeam2)->name}}">
                                        <img
                                            src="{{ getFile(config('location.team.path') . optional($item->gameTeam2)->image) }}"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <div class="cursor-pointer" title="{{optional($item->gameTeam2)->name}}">
                                        <small
                                            class="text-dark font-weight-bold">{{shortName(optional($item->gameTeam2)->name)}}</small>
                                    </div>
                                </div>
                            </td>
                            <td data-label="@lang('Active Question')">
                                <span class="badge badge-pill badge-success">{{$item->active_questions_count}}</span>
                            </td>
                            <td data-label="@lang('Tournament')" class="text-dark">
                                {{ optional($item->gameTournament)->name }}
                            </td>
                            <td data-label="@lang('Category')" class="text-dark">
                                {!! optional($item->gameCategory)->icon !!}
                                {{ optional($item->gameCategory)->name }}
                            </td>
                            <td data-label="@lang('Start Date')">
                                {{ dateTime($item->start_date, 'd M, Y') }}
                            </td>
                            <td data-label="@lang('Status')" class="text-lg-center text-right">
                                @if ($item->status == 0)
                                    <span class="badge badge-light">
                               <i class="fa fa-circle text-danger danger font-12"></i> @lang('Deactive') </span>
                                @else
                                    <span class="badge badge-light">
                               <i class="fa fa-circle text-success success font-12"></i> @lang('Active')</span>
                                @endif
                            </td>

                            @if(adminAccessRoute(config('role.manage_game.access.edit')))
                            <td data-label="@lang('Locker')" class="text-lg-center text-right">

                                <a class="btn btn-sm  btn-outline-{{($item->is_unlock == 1) ? 'primary':'dark'}}"
                                   href="{{ route('admin.match.locker') }}"
                                   onclick="event.preventDefault();
                                       document.getElementById('locker{{$item->id}}').submit();">
                                    @if($item->is_unlock == 1)
                                        <i class="fa fa-unlock"></i>  {{ __('Unlock Now') }}
                                    @else
                                        <i class="fa fa-lock"></i> {{ __('Lock Now') }}
                                    @endif

                                </a>
                                <form id="locker{{$item->id}}" action="{{ route('admin.match.locker') }}"
                                      method="POST" class="d-none">
                                    @csrf
                                    <input type="text" name="match_id" value="{{$item->id}}">
                                </form>

                            </td>
                                <td data-label="@lang('Action')">

                                    <div class="dropdown show dropup text-lg-center text-right">
                                        <a class="dropdown-toggle  p-3" href="#" id="dropdownMenuLink"
                                           data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item editBtn" href="javascript:void(0)"
                                               data-match="{{ $item }}"
                                               data-action="{{ route('admin.updateMatch', $item->id) }}">
                                                <i class="fa fa-edit text-warning pr-2"
                                                   aria-hidden="true"></i> @lang('Edit')
                                            </a>


                                            <a class="dropdown-item notiflix-confirm"
                                               href="{{route('admin.addQuestion',$item->id)}}">
                                                <i class="fa fa-plus-circle text-success pr-2"
                                                   aria-hidden="true"></i> @lang('Make Question')
                                            </a>
                                            <a class="dropdown-item notiflix-confirm"
                                               href="{{route('admin.infoMatch',$item->id)}}">
                                                <i class="fa fa-list-alt text-primary pr-2"
                                                   aria-hidden="true"></i> @lang('Question List')
                                            </a>

                                            <a class="dropdown-item notiflix-confirm" href="javascript:void(0)"
                                               data-target="#delete-modal"
                                               data-route="{{route('admin.deleteMatch',$item->id)}}"
                                               data-toggle="modal">
                                                <i class="fa fa-trash-alt text-danger pr-2"
                                                   aria-hidden="true"></i> @lang('Delete')
                                            </a>
                                        </div>
                                    </div>

                                </td>
                            @endif
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                {{$matches->appends(@$search)->links('partials.pagination')}}
            </div>
        </div>
    </div>

    <!-- All Active Modal -->
    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Active Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang("Are you really want to active the Match")</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary active-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- All Inactive Modal -->
    <div class="modal fade" id="all_inactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('DeActive Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p>@lang("Are you really want to Deactive the Match")</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('No')</span></button>
                    <form action="" method="post">
                        @csrf
                        <a href="" class="btn btn-primary inactive-yes"><span>@lang('Yes')</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- New MODAL --}}
    <div id="newModal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Add Match')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.storeMatch')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Game Category') <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control js-example-basic-single" name="category" id="category">
                                        <option value="" selected disabled>@lang('Select Game Category')</option>
                                        @foreach ($categories as $item)
                                            <option value="{{old('category', $item->id)}}">
                                                {{$item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="mt-3">
                                        @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Game Tournament') <span class="text-danger">*</span></label>
                                    <select class="form-control " name="tournament">

                                    </select>
                                    <div class="mt-3">
                                        @error('tournament')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Match Name') <span class="text-muted font-italic">(@lang('optional'))</span></label>
                                    <input type="text" class="form-control" name="name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Team 01') <span class="text-danger">*</span></label>
                                    <select class="form-control team1" data-live-search="true" name="team1">

                                    </select>
                                    <div class="mt-3">
                                        @error('team1')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Team 02') <span class="text-danger">*</span></label>
                                    <select class="form-control" name="team2">
                                    </select>
                                    <div class="mt-3">
                                        @error('team2')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row  mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Start Date') <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="datepicker"/>
                                    @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">@lang('End Date') <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="datepicker"/>
                                    @error('end_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="text-dark"> @lang('Status') </label>
                            <input data-toggle="toggle" id="status" data-onstyle="success" data-offstyle="info"
                                   data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" name="status">
                            @error('status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">@lang('Save')</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit MODAL --}}
    <div id="editModal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Edit Match')</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Game Category') <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control js-example-basic-single editCategory" name="category"
                                            id="editCategory">
                                        <option value="" selected disabled>@lang('Select Game Category')</option>
                                        @foreach ($categories as $item)
                                            <option value="{{old('category', $item->id)}}">
                                                {{$item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="mt-3">
                                        @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Game Tournament') <span class="text-danger">*</span></label>
                                    <select class="form-control js-example-basic-single" name="tournament"
                                            id="editTournament">
                                    </select>
                                    <div class="mt-3">
                                        @error('tournament')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Match Name') <span class="text-muted font-italic">(@lang('optional'))</span></label>
                                    <input type="text" class="form-control" name="name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Team 01') <span class="text-danger">*</span></label>
                                    <select class="form-control team1" data-live-search="true" name="team1"
                                            id="editTeam1">

                                    </select>
                                    <div class="mt-3">
                                        @error('team1')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Team 02') <span class="text-danger">*</span></label>
                                    <select class="form-control" name="team2" id="editTeam2">
                                    </select>
                                    <div class="mt-3">
                                        @error('team2')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row  mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">@lang('Start Date') <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="editStartDate"/>
                                    @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">@lang('End Date') <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control end_date" name="end_date" id="editEndDate"/>
                                    @error('end_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="text-dark"> @lang('Status') </label>
                            <input data-toggle="toggle" id="edit-status" data-onstyle="success" data-offstyle="info"
                                   data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" name="status">
                            @error('status')
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

    {{-- Remove MODAL --}}
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/select2.min.css') }}">
@endpush
@push('style')
    <script src="{{ asset('assets/admin/js/fontawesome/fontawesomepro.js') }}"></script>
@endpush
@push('js')

    <script src="{{ asset('assets/admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.js') }}"></script>


    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp

        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.Failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif

    <script>
        'use strict'
        $(document).ready(function () {
            $('select').select2();
        });


        $('select[name=team1]').append(` <option value="" selected disabled>@lang('Select Team')</option>`);
        $('select[name=team2]').append(` <option value="" selected disabled>@lang('Select Team')</option>`);
        $('select[name=tournament]').append(` <option value="" selected disabled>@lang('Select a tournament')</option>`);


        var categoryId = null, tournament_id = null, match_team1_id = null, match_team2_id = null;
        $(document).on('change', "#category", function () {
            categoryId = $(this).val();
            getTeamByCategory(categoryId);
        });

        $(document).on('change', ".editCategory", function () {
            categoryId = $(this).val();
            getTeamByCategory(categoryId);
        });

        $(document).on('click', '.editBtn', function () {
            var modal = $('#editModal');

            var match = $(this).data('match');

            $('.id-get').text(match.id)

            modal.find('input[name=name]').val(match.name);


            match_team1_id = match.team1_id
            match_team2_id = match.team2_id
            tournament_id = match.tournament_id
            $('#editStartDate').val(match.start_date);
            $('#editEndDate').val(match.end_date);
            getTeamByCategory(match.category_id, match_team1_id, match_team2_id)
            $('#editCategory').val("" + match.category_id).select2();

            modal.find('form').attr('action', $(this).data('action'));
            if (match.status == 1) {
                $('#edit-status').bootstrapToggle('on')
            } else {
                $('#edit-status').bootstrapToggle('off')
            }
            modal.modal('show');
        });


        function getTeamByCategory(categoryId = 0, match_team1_id = null, match_team2_id = null) {


            if (categoryId == 0) {
                return 0;
            }
            $('select[name=team1]').empty();
            $('select[name=team2]').empty();
            $('select[name=tournament]').empty();
            $.ajax({
                url: "{{route('admin.ajax.listMatch')}}",
                type: 'POST',
                data: {
                    categoryId
                },
                success(data) {

                    $.each(data.team, function (key, item) {
                        $('select[name=team1]').append(`<option value="${item.id}" ${(item.status == '0') ? 'disabled' : ''}  ${(match_team1_id == item.id) ? 'selected' : ''}>${item.name}</option`);
                        $('select[name=team2]').append(`<option value="${item.id}" ${(item.status == '0') ? 'disabled' : ''} ${(match_team2_id == item.id) ? 'selected' : ''}>${item.name}</option`);
                    });

                    $.each(data.tournament, function (key, item) {
                        $('select[name=tournament]').append(`<option value="${item.id}" ${(tournament_id == item.id) ? 'selected' : ''}>${item.name}</option`);
                    });
                },
                complete: function () {
                },
                error(err) {
                    var errors = err.responseJSON;
                    for (var obj in errors) {
                        $('.errors').text(`${errors[obj]}`)
                    }

                }
            });

        }


        $(document).on('shown.bs.modal', '#editModal', function (e) {
            $(document).off('focusin.modal');
        });
        $(document).on('shown.bs.modal', '#newModal', function (e) {
            $(document).off('focusin.modal');
        });

        $(document).on('click', '.notiflix-confirm', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })

        $(document).on('click', '#check-all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('change', ".row-tic", function () {
            let length = $(this).length;
            let checkedLength = $(".row-tic:checked").length;
            if (length == checkedLength) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });

        //multiple active
        $(document).on('click', '.active-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            var strIds = allVals;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "{{ route('admin.match-active') }}",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                },
            });
        });

        //multiple deactive
        $(document).on('click', '.inactive-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            var strIds = allVals;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "{{ route('admin.match-deactive') }}",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                }
            });
        });

    </script>

@endpush
