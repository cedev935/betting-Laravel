@extends('admin.layouts.app')
@section('title',trans(ucfirst(kebab2Title($content))))

@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">


        <div class="card card-primary  my-4 ">
            <div class="card-body">
                <div class="media align-items-center justify-content-between mb-3">
                    <h4 class="card-title">@lang(ucfirst(kebab2Title(@$content)))</h4>
                    @if(adminAccessRoute(config('role.theme_settings.access.add')))
                        <a href="{{ route('admin.content.create',@$content) }}"
                           class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> @lang('Add New')</a>
                    @endif

                </div>


                <div class="table-responsive">
                    <table class="categories-show-table table table-hover table-striped table-bordered">
                        <thead class="thead-primary">
                        <tr>
                            <th>@lang('SL')</th>
                            <th>@lang(ucfirst(array_key_first(config('contents.'.@$content)['field_name'])))</th>
                            @if(adminAccessRoute(config('role.theme_settings.access.edit')))
                                <th>@lang('Action')</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(@$contents as $key => $value)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>
                                    <?php echo optional(optional(@$value->contentDetails[0])->description)->{array_key_first(config('contents.' . $content)['field_name'])} ?? 'N/A';?>
                                </td>
                                <td>

                                    @if(adminAccessRoute(config('role.theme_settings.access.edit')))
                                        <a href="{{ route('admin.content.show',[$value,$value->name])}}"
                                           class="btn btn-primary btn-sm"><i
                                                class="fas fa-edit"></i> @lang('Edit')</a>
                                    @endif
                                    @if(adminAccessRoute(config('role.theme_settings.access.delete')))
                                        <a href="javascript:void(0)"
                                           data-route="{{route('admin.content.delete',$value->id)}}"
                                           data-toggle="modal"
                                           data-target="#delete-modal"
                                           class="btn btn-danger btn-sm notiflix-confirm"><i
                                                class="fas fa-trash"></i> @lang('Delete')</a>

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!---Container Fluid-->


    <!-- Primary Header Modal -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel">@lang('Delete Confirmation')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">@lang('Close')</button>
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@push('js')
    <script>
        'use strict'
        $(document).ready(function () {
            $('.notiflix-confirm').on('click', function () {
                var route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });
    </script>
@endpush
