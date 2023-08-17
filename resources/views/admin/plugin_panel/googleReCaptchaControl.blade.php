@extends('admin.layouts.app')
@section('title', __('Google reCaptcha Control'))
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
                            <h5 class="m-0 text-white">@lang('Google reCaptcha Control')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <form action="{{ route('admin.google.recaptcha.control') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="NOCAPTCHA_SECRET">@lang('NOCAPTCHA SECRET')</label>
                                                    <input type="text" name="NOCAPTCHA_SECRET" value="{{ old('NOCAPTCHA_SECRET',env('NOCAPTCHA_SECRET')) }}" placeholder="@lang('NOCAPTCHA_SECRET')"
                                                            class="form-control @error('NOCAPTCHA_SECRET') is-invalid @enderror">
                                                    <div class="invalid-feedback">@error('NOCAPTCHA_SECRET') @lang($message) @enderror</div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="NOCAPTCHA_SITEKEY">@lang('NOCAPTCHA SITEKEY')</label>
                                                    <input type="text" name="NOCAPTCHA_SITEKEY" value="{{ old('NOCAPTCHA_SITEKEY',env('NOCAPTCHA_SITEKEY')) }}" placeholder="@lang('NOCAPTCHA SITEKEY')"
                                                            class="form-control @error('NOCAPTCHA_SITEKEY') is-invalid @enderror">
                                                    <div class="invalid-feedback">@error('NOCAPTCHA_SITEKEY') @lang($message) @enderror</div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <div class="form-group ">
                                                    <label>@lang('Login Status')</label>
                                                    <div class="custom-switch-btn w-md-100">
                                                        <input type='hidden' value="1" name='reCaptcha_status_login'>
                                                        <input type="checkbox" name="reCaptcha_status_login" class="custom-switch-checkbox" id="reCaptcha_status_login"  value = "0" <?php if( $basicControl->reCaptcha_status_login == 0):echo 'checked'; endif ?> >
                                                        <label class="custom-switch-checkbox-label" for="reCaptcha_status_login">
                                                            <span class="custom-switch-checkbox-inner"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                    @error('reCaptcha_status_login')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group ">
                                                    <label>@lang('Registration Status')</label>
                                                    <div class="custom-switch-btn w-md-100">
                                                        <input type='hidden' value="1" name='reCaptcha_status_registration'>
                                                        <input type="checkbox" name="reCaptcha_status_registration" class="custom-switch-checkbox" id="reCaptcha_status_registration"  value = "0" <?php if( $basicControl->reCaptcha_status_registration == 0):echo 'checked'; endif ?> >
                                                        <label class="custom-switch-checkbox-label" for="reCaptcha_status_registration">
                                                            <span class="custom-switch-checkbox-inner"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                    @error('reCaptcha_status_registration')
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
