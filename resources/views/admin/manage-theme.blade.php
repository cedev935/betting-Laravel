@extends('admin.layouts.app')
@section('title')
    @lang('Manage Theme')
@endsection
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="row">

                @foreach ($theme as $key => $data)

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-dark p-3 text-white my-1 font-weight-bold">
                              {{$data['title']}}
                            </div>
                            <div class="card-body m-0 p-0">
                                <img class="w-100" src="{{asset($data['path'])}}" alt="@lang('theme-image')" >
                            </div>
                            <div class="card-footer">
                                @if ($configure->theme == $key)
                                <button
                                    type="button"
                                    disabled
                                    class="btn waves-effect waves-light btn-rounded btn-dark btn-block mt-3">
                                    <span><i class="fas fa-check-circle pr-2"></i> @lang('Selected')</span>
                                </button>
                                @else
                                    <button
                                        type="button"
                                        class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3 activateBtn"
                                        data-toggle="modal" data-target="#activateModal"
                                        data-route="{{route('admin.activate.themeUpdate', $key)}}">
                                        <span><i class="fas fa-save pr-2"></i> @lang('Select As Active')</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>


    <!-- Primary Header Modal -->
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Theme Activate Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to activate this theme?')</p>
                </div>

                <form action="" method="post" class="actionForm">
                    @csrf
                    @method('put')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                                data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Activate')</button>
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

            $('.activateBtn').on('click', function () {
                $('.actionForm').attr('action', $(this).data('route'));
            })

            $('select').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush
