@extends('admin.layouts.app')
@section('title')
    @lang('Plugin Configuration')
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row mt-sm-4">
            <div class="col-12 col-md-4 col-lg-4">
                @include('admin.plugin_panel.components.sidebar', ['settings' => config('generalsettings.plugin'), 'suffix' => ''])
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="container-fluid" id="container-wrapper">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-12">
                            <div class="card mb-4 card-primary shadow">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-dark">
                                    <h5 class="text-white">@lang('Plugin Configuration')</h5>
                                </div>
                                <div class="card-body py-5">
                                    <div class="row justify-content-md-center">
                                        <div class="col-lg-10">
                                            <div class="card mb-4 shadow">
                                                <div class="card-body">
                                                    <div class="row justify-content-between align-items-center">
                                                        <div class="col-md-3"><img src="{{ asset('assets/uploads/plugin/tawk.png') }}" class="w-25"></div>
                                                        <div class="col-md-6">@lang('Message your customers,they\'ll love you for it')</div>
                                                        <div class="col-md-3"><a href="{{ route('admin.tawk.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center d-none">
                                        <div class="col-lg-10">
                                            <div class="card mb-4 shadow">
                                                <div class="card-body">
                                                    <div class="row justify-content-between align-items-center">
                                                        <div class="col-md-3"><img src="{{ asset('assets/uploads/plugin/messenger.png') }}" class="w-25"></div>
                                                        <div class="col-md-6">@lang('Message your customers,they\'ll love you for it')</div>
                                                        <div class="col-md-3"><a href="{{ route('admin.fb.messenger.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-lg-10">
                                            <div class="card mb-4 shadow">
                                                <div class="card-body">
                                                    <div class="row justify-content-between align-items-center">
                                                        <div class="col-md-3"><img src="{{ asset('assets/uploads/plugin/reCaptcha.png') }}" class="w-25"></div>
                                                        <div class="col-md-6">@lang('reCAPTCHA protects your website from fraud and abuse.')</div>
                                                        <div class="col-md-3"><a href="{{ route('admin.google.recaptcha.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-lg-10">
                                            <div class="card mb-4 shadow">
                                                <div class="card-body">
                                                    <div class="row justify-content-between align-items-center">
                                                        <div class="col-md-3"><img src="{{ asset('assets/uploads/plugin/analytics.png') }}" class="w-25"></div>
                                                        <div class="col-md-6">@lang('Google Analytics is a web analytics service offered by Google.')</div>
                                                        <div class="col-md-3"><a href="{{ route('admin.google.analytics.control') }}" class="btn btn-sm btn-primary" target="_blank">@lang('Configuration')</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

