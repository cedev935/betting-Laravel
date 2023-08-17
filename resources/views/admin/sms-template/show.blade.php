@extends('admin.layouts.app')
@section('title')
    @lang('SMS Default Template')
@endsection
@section('content')


    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table id="zero_config" class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('No.')</th>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($smstemplate as $template)
                    <tr>
                        <td>@lang($loop->iteration)</td>
                        <td>{{ $template->name }}</td>
                        <td>
                            <span class="badge badge-pill badge-{{($template->sms_status == 1) ?'success' : 'danger'}}">{{($template->sms_status == 1) ?trans('Active') : trans('Deactive')}}</span>
                        </td>
                        <td>
                            <a  href="{{ route('admin.sms-template.edit',$template->id) }}" class="btn btn-sm btn-primary " title="@lang('Edit')"><i class="fas fa-edit" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('style-lib')
    <link href="{{asset('assets/admin/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/datatable-basic.init.js') }}"></script>
@endpush

