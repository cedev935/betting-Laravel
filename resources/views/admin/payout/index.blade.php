@extends('admin.layouts.app')
@section('title', trans($page_title))
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            @if(adminAccessRoute(config('role.payout_manage.access.add')))
                <div class="media mb-4 justify-content-end">
                    <a href="{{route('admin.payout-method.create')}}" class="btn btn-sm  btn-primary mr-2">
                        <span><i class="fas fa-plus"></i> @lang('Add New')</span>
                    </a>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered no-wrap" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">@lang('Name')</th>
                        <th scope="col">@lang('Status')</th>
                        <th scope="col">@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($methods as $method)
                        <tr>
                            <td data-label="@lang('Name')">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3">
                                        <img src="{{ getFile(config('location.withdraw.path').$method->image)}}"
                                             alt="{{$method->name}}" class="rounded-circle" width="45" height="45">
                                    </div>
                                    <div class="mr-3">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $method->name }}</h5>
                                    </div>
                                    @if($method->is_automatic == 1)
                                        <div class="">
                                            <span class="badge badge-pill  badge-success">@lang('Automated')</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td data-label="@lang('Status')" class="text-sm">
                                <span class="badge badge-light">
                                    <i class="fa fa-circle {{ $method->status == 0 ? 'text-danger danger font-12' : 'text-success success font-12' }}"></i> {{ $method->status == 0 ? 'Inactive' : 'Active' }}</span>
                            </td>
                            @if(adminAccessRoute(config('role.payout_manage.access.edit')))
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.payout-method.edit', $method->id) }}"
                                       class="btn btn-sm btn-primary"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-original-title="@lang('Edit Payment Methods Info')">
                                        <i class="fa fa-edit"></i></a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="8">
                                @lang('No Data Found')
                            </td>
                        </tr>
                    @endforelse
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
