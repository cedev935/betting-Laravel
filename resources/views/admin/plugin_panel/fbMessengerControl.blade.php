@extends('admin.layouts.app')
@section('title', __('FB Messenger Control'))
@section('content')

    <div class="container-fluid">
        <div class="row mt-sm-4 justify-content-center">
            <div class="col-12 col-md-4 col-lg-4">
                @include('admin.plugin_panel.components.sidebar', ['settings' => config('generalsettings.plugin'), 'suffix' => ''])
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="container-fluid" id="container-wrapper">
                    <div class="card mb-4 card-primary shadow">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                            <h5 class="m-0 text-white">@lang('FB Messenger Control')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <form action="{{ route('admin.fb.messenger.control') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="fb_app_id">@lang('App ID')</label>
                                                    <input type="text" name="fb_app_id" value="{{ old('fb_app_id',$basicControl->fb_app_id) }}" placeholder="@lang('App ID')"
                                                            class="form-control @error('fb_app_id') is-invalid @enderror">
                                                    <div class="invalid-feedback">@error('fb_app_id') @lang($message) @enderror</div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="fb_page_id">@lang('Page ID')</label>
                                                    <input type="text" name="fb_page_id" value="{{ old('fb_page_id',$basicControl->fb_page_id) }}" placeholder="@lang('Page ID')"
                                                            class="form-control @error('fb_page_id') is-invalid @enderror">
                                                    <div class="invalid-feedback">@error('fb_page_id') @lang($message) @enderror</div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group ">
                                                    <label>@lang('FB Chat')</label>
                                                    <div class="custom-switch-btn w-md-100">
                                                        <input type='hidden' value="1" name='fb_messenger_status'>
                                                        <input type="checkbox" name="fb_messenger_status" class="custom-switch-checkbox" id="fb_messenger_status"  value = "0" <?php if( $basicControl->fb_messenger_status == 0):echo 'checked'; endif ?> >
                                                        <label class="custom-switch-checkbox-label" for="fb_messenger_status">
                                                            <span class="custom-switch-checkbox-inner"></span>
                                                            <span class="custom-switch-checkbox-switch"></span>
                                                        </label>
                                                    </div>
                                                    @error('fb_messenger_status')
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

</div>
@endsection

