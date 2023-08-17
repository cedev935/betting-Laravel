@extends('admin.layouts.app')
@section('title', __('Tawk Control'))
@section('content')

    <div class="container-fluid">
        <div class="row mt-sm-4 justify-content-center">
            <div class="col-12 col-md-4 col-lg-4">
                @include('admin.plugin_panel.components.sidebar', ['settings' => config('generalsettings.plugin'), 'suffix' => ''])
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="container-fluid" id="container-wrapper">
                    <div class="card mb-4 card-primary shadow">
                        <div class="card-header py-3 d-flex flex-row align-items-center bg-dark justify-content-between">
                            <h5 class="m-0 text-white">@lang('Tawk Control')</h5>

                            <a href="https://youtu.be/d7jFXaMecYQ" target="_blank" class="btn btn-primary btn-sm  text-white ">
                                <span class="btn-label"><i class="fab fa-youtube"></i></span>
                                @lang('How to set up it?')
                            </a>

                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <form action="{{ route('admin.tawk.control') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="tawk_id">@lang('Tawk ID')
                                                        @php
                                                        $htmlContent = "embed.tawk.to/[Your Tawk code and Widget ID]";
                                                        @endphp
                                                        <a href="javascript:void(0)" data-container="body" title="@lang('How to Get it')" data-toggle="popover" data-placement="top" data-content="@lang($htmlContent)">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>

                                                    </label>
                                                    <input type="text" name="tawk_id"
                                                            value="{{ old('tawk_id',$basicControl->tawk_id) }}"
                                                            placeholder="@lang('Tawk ID')"
                                                            class="form-control @error('tawk_id') is-invalid @enderror">
                                                    <div class="invalid-feedback">@error('tawk_id') @lang($message) @enderror</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group ">
                                                    <label>@lang('Tawk Chat')</label>
                                                    <div class="custom-switch-btn w-md-100">
                                                        <input type='hidden' value="1" name='tawk_status'>
                                                        <input type="checkbox" name="tawk_status" class="custom-switch-checkbox" id="tawk_status"  value = "0" <?php if( $basicControl->tawk_status == 0):echo 'checked'; endif ?> >
                                                        <label class="custom-switch-checkbox-label" for="tawk_status">
                                                            <span class="custom-switch-checkbox-inner"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                    @error('tawk_status')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <button type="submit" name="submit"
                                                    class="btn btn-primary btn-rounded btn-block">@lang('Save changes')</button>
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
