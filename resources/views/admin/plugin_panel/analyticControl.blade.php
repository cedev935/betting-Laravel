@extends('admin.layouts.app')
@section('title', __('Google Analytics Control'))
@section('content')

    <div class="container-fluid">
        <div class="row mt-sm-4 justify-content-center">
            <div class="col-12 col-md-4 col-lg-4">
                @include('admin.plugin_panel.components.sidebar', ['settings' => config('generalsettings.plugin'), 'suffix' => ''])
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="container-fluid" id="container-wrapper">
                    <div class="card mb-4 card-primary shadow">
                        <div class="card-header bg-dark py-3 d-flex flex-row align-items-center justify-content-between">
                            <h5 class="m-0 text-white">@lang('Google Analytics Control')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <form action="{{ route('admin.google.analytics.control') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="MEASUREMENT_ID">@lang('MEASUREMENT_ID')</label>
                                                    <input type="text" name="MEASUREMENT_ID" value="{{ old('MEASUREMENT_ID',$basicControl->MEASUREMENT_ID) }}" placeholder="@lang('MEASUREMENT_ID')"
                                                            class="form-control @error('MEASUREMENT_ID') is-invalid @enderror">
                                                    <div class="invalid-feedback">@error('MEASUREMENT_ID') @lang($message) @enderror</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group ">
                                                    <label>@lang('Google Analytics')</label>
                                                    <div class="custom-switch-btn w-md-100">
                                                        <input type='hidden' value="1" name='analytic_status'>
                                                        <input type="checkbox" name="analytic_status" class="custom-switch-checkbox" id="analytic_status"  value = "0" <?php if( $basicControl->analytic_status == 0):echo 'checked'; endif ?> >
                                                        <label class="custom-switch-checkbox-label" for="analytic_status">
                                                            <span class="custom-switch-checkbox-inner"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                    @error('analytic_status')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <button type="submit" name="submit" class="btn btn-primary btn-rounded btn-block">@lang('Save changes')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
