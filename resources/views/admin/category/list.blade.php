@extends('admin.layouts.app')
@section('title')
    @lang('Game Category List')
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-header bg-transparent ">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                @if(adminAccessRoute(config('role.manage_game.access.add')))
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mr-2" data-target="#newModal"
                       data-toggle="modal">
                        <span><i class="fa fa-plus-circle"></i> @lang('Add New')</span>
                    </a>
                @endif


                @if(adminAccessRoute(config('role.manage_game.access.edit')))
                    <div class="dropdown mb-2 text-right">
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
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Active Tournament')</th>
                        <th scope="col">@lang('Active Team')</th>
                        <th scope="col">@lang('Active Match')</th>
                        <th scope="col" class="text-center">@lang('Icon')</th>
                        <th scope="col" class="text-center">@lang('Status')</th>

                        @if(adminAccessRoute(config('role.manage_game.access.edit')))
                            <th scope="col" class="text-center">@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as  $item)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" id="chk-{{ $item->id }}"
                                       class="form-check-input row-tic tic-check" name="check" value="{{$item->id}}"
                                       data-id="{{ $item->id }}">
                                <label for="chk-{{ $item->id }}"></label>
                            </td>

                            <td data-label="@lang('SL No.')" class="text-center">{{ $loop->index + 1 }}</td>
                            <td data-label="@lang('Name')">
                                {{ $item->name }}
                            </td>
                            <td data-label="@lang('Active Tournament')">
                                <span class="badge badge-info">{{ $item->active_tournament_count }}</span>
                            </td>
                            <td data-label="@lang('Active Team')">
                                <span class="badge badge-success">{{ $item->active_team_count }}</span>
                            </td>
                            <td data-label="@lang('Active Match')">
                                <span class="badge badge-warning">{{ $item->active_match_count }}</span>
                            </td>
                            <td data-label="@lang('Icon')" class="text-lg-center text-right">
                                {!! $item->icon !!}
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
                                <td data-label="@lang('Action')">

                                    <div class="dropdown show dropup text-lg-center text-right">
                                        <a class="dropdown-toggle p-3" href="#" id="dropdownMenuLink"
                                           data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item editBtn" href="javascript:void(0)"
                                               data-title="{{ $item->name }}" data-icon="{{ $item->icon }}"
                                               data-status="{{ $item->status }}"
                                               data-action="{{ route('admin.updateCategory', $item->id) }}">
                                                <i class="fa fa-edit text-warning pr-2"
                                                   aria-hidden="true"></i> @lang('Edit')
                                            </a>

                                            <a class="dropdown-item notiflix-confirm" href="javascript:void(0)"
                                               data-target="#delete-modal"
                                               data-route="{{route('admin.deleteCategory',$item->id)}}"
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
                    <p>@lang("Are you really want to active the Category")</p>
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
                    <p>@lang("Are you really want to Deactive the Category")</p>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Add New')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.storeCategory')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="text-dark">@lang('Title')</label>
                            <input type="text" class="form-control" name="title">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-dark">@lang('Icon')</label>


                            <select name="icon" id="icon" class="form-control" class="selectpicker"
                                    data-live-search="true">
                                <option value="" selected disabled>@lang('Select Icon')</option>
                                @foreach($games as $key => $value)
                                    <option value="{{$value}}" data-content="{{$value}} {{$key}}">
                                        {{$key}} </i>
                                    </option>
                                @endforeach
                            </select>

                            @error('icon')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="edit-status" class="text-dark"> @lang('Status') </label>
                            <input data-toggle="toggle" id="edit-status" data-onstyle="success" data-offstyle="info"
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title">@lang('Edit Game')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <input type="hidden" name="key" value="social.item">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Title')</label>
                            <input type="text" class="form-control" name="title" value="" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Icon')</label>


                            <select name="icon" id="editIcon" class="form-control selectpicker" data-live-search="true">
                                <option value="" selected disabled>@lang('Select Icon')</option>
                                @foreach($games as $key => $value)
                                    <option value="{{old('icon',$value)}}" data-content="{{$value}} {{$key}}">
                                        {{$key}} </i>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-status" class="text-dark"> @lang('Status') </label>
                            <input data-toggle="toggle" id="status" data-onstyle="success" data-offstyle="info"
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
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-select.min.css') }}">
    <link href="{{asset('assets/admin/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endpush
@push('style')
    <script src="{{ asset('assets/admin/js/fontawesome/fontawesomepro.js') }}"></script>
@endpush

@push('js')
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/datatable-basic.init.js') }}"></script>

    <script>
        $(function () {
            $('select').selectpicker();
        });
    </script>

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
            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });

        $(document).on('click', '#check-all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('change', ".row-tic", function () {
            let length = $(".row-tic").length;
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
                url: "{{ route('admin.category-active') }}",
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
                url: "{{ route('admin.category-deactive') }}",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                }
            });
        });

        $(document).on('click', '.editBtn', function () {

            var modal = $('#editModal');
            modal.find('input[name=title]').val($(this).data('title'));
            modal.find('#editIcon').selectpicker('val', $(this).data('icon'));
            modal.find('form').attr('action', $(this).data('action'));
            if ($(this).data('status') == 1) {
                $('#status').bootstrapToggle('on')
            } else {
                $('#status').bootstrapToggle('off')
            }
            modal.modal('show');
        });

        $(document).on('shown.bs.modal', '#editModal', function (e) {
            $(document).off('focusin.modal');
        });
        $(document).on('shown.bs.modal', '#newModal', function (e) {
            $(document).off('focusin.modal');
        });

    </script>

@endpush
