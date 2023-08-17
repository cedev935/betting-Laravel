@extends('admin.layouts.app')
@section('title')
    @lang('SMS Controls')
@endsection

@push('style-lib')
    <link href="{{ asset('assets/admin/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-6">

            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-primary">
                            <tr>
                                <th> @lang('SHORTCODE') </th>
                                <th> @lang('DESCRIPTION') </th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td>
                                    <pre>[[receiver]]</pre>
                                </td>
                                <td> @lang('User Contact Number') </td>
                            </tr>
                            <tr>
                                <td>
                                    <pre>[[message]]</pre>
                                </td>
                                <td> @lang('Receiver Message') </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <h4 class="card-title">@lang('SMS Action')</h4>
                    <form method="post" action="{{route('admin.sms-controls.action')}}" novalidate="novalidate"
                          class="needs-validation base-form ">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-6 col-md-6">
                                <label class="font-weight-bold">@lang('SMS Notification')</label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='sms_notification'>
                                    <input type="checkbox" name="sms_notification" class="custom-switch-checkbox"
                                           id="sms_notification"
                                           value="0" <?php if ($control->sms_notification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="sms_notification">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group col-lg-6 col-md-6">
                                <label class="d-block">@lang('SMS Verification')</label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='sms_verification'>
                                    <input type="checkbox" name="sms_verification" class="custom-switch-checkbox"
                                           id="sms_verification"
                                           value="0" <?php if ($control->sms_verification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="sms_verification">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <button type="submit"
                                class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                            <span>@lang('Save Changes')</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @php
        if (old()){
            $headerData = array_combine(old('headerDataKeys'),old('headerDataValues'));
            $paramData = array_combine(old('paramKeys'),old('paramValues'));
            $formData = array_combine(old('formDataKeys'),old('formDataValues'));
            $headerData = (empty(array_filter($headerData))) ? null : json_encode($headerData);
            $paramData = (empty(array_filter($paramData))) ? null : json_encode($paramData);
            $formData = (empty(array_filter($formData))) ? null : json_encode($formData);
        } else {
            $headerData = $smsControl->headerData;
            $paramData = $smsControl->paramData;
            $formData = $smsControl->formData;
        }

        $headerActive = false;
        $paramActive = false;
        $formActive = false;

        if ($errors->has('headerDataKeys.*') || $errors->has('headerDataValues.*')) {
            $headerActive = true;
        }elseif ($errors->has('paramKeys.*') || $errors->has('paramValues.*')) {
            $paramActive = true;
        } elseif ($errors->has('formDataKeys.*') || $errors->has('formDataValues.*')) {
            $formActive = true;
        } else {
            $headerActive = true;
        }
    @endphp

    <div class="card  card-form m-0 m-md-4 my-4 m-md-0">
        <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-white">@lang('SMS Configuration')</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.sms.config') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="actionMethod">@lang('Method')</label>
                            <select name="actionMethod" id="actionMethod"
                                    class="form-control  @error('actionMethod') is-invalid @enderror">
                                <option
                                    value="GET" {{ (old('actionMethod',$smsControl->actionMethod) == 'GET') ? 'selected' : '' }}>
                                    GET
                                </option>
                                <option
                                    value="POST" {{ (old('actionMethod',$smsControl->actionMethod) == 'POST') ? 'selected' : '' }} >
                                    POST
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                @error('actionMethod') @lang($message) @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="actionUrl">@lang('URL')</label>
                            <input type="text" name="actionUrl" value="{{ old('actionUrl',$smsControl->actionUrl) }}"
                                   placeholder="@lang('Enter request URL')"
                                   class="form-control  @error('actionUrl') is-invalid @enderror">
                            <div class="invalid-feedback">
                                @error('actionUrl') @lang($message) @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ ($headerActive) ? 'active' : '' }}" id="headerData-tab" data-toggle="tab"
                           href="#headerData" role="tab" aria-controls="headerData"
                           aria-selected="{{ ($headerActive) ? 'true' : 'false' }}">@lang('Headers')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($paramActive) ? 'active' : '' }}" id="params-tab" data-toggle="tab"
                           href="#params" role="tab" aria-controls="params"
                           aria-selected="{{ ($paramActive) ? 'true' : 'false' }}">@lang('Params')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($formActive) ? 'active' : '' }}" id="formData-tab" data-toggle="tab"
                           href="#formData" role="tab" aria-controls="contact"
                           aria-selected="{{ ($formActive) ? 'true' : 'false' }}">@lang('Form Data')</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="mt-2 tab-pane fade {{ ($headerActive) ? 'show active' : '' }}" id="headerData"
                         role="tabpanel" aria-labelledby="headerData-tab">
                        <label for="headerData  my-3">@lang('Headers')</label>

                        <div class="headerDataWrapper mt-2">
                            @if(is_null($headerData))
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="headerDataKeys[]" value=""
                                                   placeholder="@lang('Key')" class="form-control  headerDataKeys">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="headerDataValues[]" value=""
                                                   placeholder="@lang('Value')" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a href="javascript:void(0);"
                                               class="btn btn-primary btn-sm addHeaderData"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach(json_decode($headerData) as $key => $value)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="headerDataKeys[]" value="{{$key}}"
                                                       placeholder="@lang('Key')" autocomplete="off"
                                                       class="form-control  headerDataKeys @error("headerDataKeys.$loop->index") is-invalid @enderror">
                                                <div
                                                    class="invalid-feedback">@error("headerDataKeys.$loop->index") @lang($message) @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="headerDataValues[]" value="{{$value}}"
                                                       placeholder="@lang('Value')"
                                                       class="form-control  @error("headerDataValues.$loop->index") is-invalid @enderror">
                                                <div
                                                    class="invalid-feedback">@error("headerDataValues.$loop->index") @lang($message) @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                @if($loop->first)
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-primary btn-sm addHeaderData"><i
                                                            class="fas fa-plus"></i></a>
                                                @else
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-danger btn-sm removeDiv"><i
                                                            class="fas fa-minus"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane fade {{ ($paramActive) ? 'show active' : '' }}" id="params" role="tabpanel"
                         aria-labelledby="params-tab">
                        <label for="params  my-3">@lang('Params')</label>
                        <div class="paramsWrapper mt-2 ">
                            @if(is_null($paramData))
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="paramKeys[]" value="" placeholder="@lang('Key')"
                                                   class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="paramValues[]" value=""
                                                   placeholder="@lang('Value')" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm addParams"><i
                                                    class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach(json_decode($paramData) as $key => $value)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="paramKeys[]" value="{{ $key }}"
                                                       placeholder="@lang('Key')"
                                                       class="form-control  @error("paramKeys.$loop->index") is-invalid @enderror">
                                                <div
                                                    class="invalid-feedback">@error("paramKeys.$loop->index") @lang($message) @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="paramValues[]" value="{{ $value }}"
                                                       placeholder="@lang('Value')"
                                                       class="form-control  @error("paramValues.$loop->index") is-invalid @enderror">
                                                <div
                                                    class="invalid-feedback">@error("paramValues.$loop->index") @lang($message) @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                @if($loop->first)
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-primary btn-sm addParams"><i
                                                            class="fas fa-plus"></i></a>
                                                @else
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-danger btn-sm removeDiv"><i
                                                            class="fas fa-minus"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane fade{{ ($formActive) ? 'show active' : '' }}" id="formData" role="tabpanel"
                         aria-labelledby="formData-tab">
                        <label for="formData my-3">@lang('Form Data')</label>
                        <div class="formDataWrapper mt-2">
                            @if(is_null($formData))
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="formDataKeys[]" value="" placeholder="@lang('Key')"
                                                   class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="formDataValues[]" value=""
                                                   placeholder="@lang('Value')" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm addFormData"><i
                                                    class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach(json_decode($formData) as $key => $value)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="formDataKeys[]" value="{{ $key }}"
                                                       placeholder="@lang('Key')"
                                                       class="form-control  @error("formDataKeys.$loop->index") is-invalid @enderror">
                                                <div
                                                    class="invalid-feedback">@error("formDataKeys.$loop->index") @lang($message) @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="formDataValues[]" value="{{ $value }}"
                                                       placeholder="@lang('Value')"
                                                       class="form-control  @error("formDataValues.$loop->index") is-invalid @enderror">
                                                <div
                                                    class="invalid-feedback">@error("formDataValues.$loop->index") @lang($message) @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                @if($loop->first)
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-primary btn-sm addFormData"><i
                                                            class="fas fa-plus"></i></a>
                                                @else
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-danger btn-sm removeDiv"><i
                                                            class="fas fa-minus"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <button type="submit"
                        class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save Changes')</button>
            </form>
        </div>
    </div>


    <div class="paramHtml d-none">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="paramKeys[]" value="" placeholder="@lang('Key')" class="form-control ">
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <input type="text" name="paramValues[]" value="" placeholder="@lang('Value')" class="form-control ">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <a href="#" class="btn btn-danger btn-sm removeDiv"><i class="fas fa-minus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="formDataHtml d-none">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="formDataKeys[]" value="" placeholder="@lang('Key')" class="form-control ">
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <input type="text" name="formDataValues[]" value="" placeholder="@lang('Value')"
                           class="form-control ">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <a href="#" class="btn btn-danger btn-sm removeDiv"><i class="fas fa-minus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="headerDataHtml d-none">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="headerDataKeys[]" value="" placeholder="@lang('Key')"
                           class="form-control  headerDataKeys">
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <input type="text" name="headerDataValues[]" value="" placeholder="@lang('Value')"
                           class="form-control ">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <a href="#" class="btn btn-danger btn-sm removeDiv"><i class="fas fa-minus"></i></a>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js-lib')
    <script src="{{ asset('assets/admin/js/jquery-ui.min.js') }}"></script>
@endpush

@push('js')

    <script>
        'use strict'
        $(document).ready(function () {
            let headerDataHtml = $('.headerDataHtml').html();
            let addHeaderData = $('.addHeaderData'); //Add button selector
            let headerDataWrapper = $('.headerDataWrapper'); //Input field wrapper
            //Once add button is clicked
            $(addHeaderData).click(function () {
                $(headerDataWrapper).append(headerDataHtml); //Add field html
            });

            let formDataHtml = $('.formDataHtml').html();
            let addFormData = $('.addFormData'); //Add button selector
            let formDataWrapper = $('.formDataWrapper'); //Input field wrapper
            //Once add button is clicked
            $(addFormData).click(function () {
                $(formDataWrapper).append(formDataHtml); //Add field html
            });

            let paramHtml = $('.paramHtml').html();
            let addParams = $('.addParams'); //Add button selector
            let paramsWrapper = $('.paramsWrapper'); //Input field wrapper
            //Once add button is clicked
            $(addParams).click(function () {
                $(paramsWrapper).append(paramHtml); //Add field html
            });

            //Once remove button is clicked
            $(document).on('click', '.removeDiv', function (e) {
                e.preventDefault();
                $(this).closest('.row').remove();
            });

            let availableTags = ["Accept", "Accept-CH", "Accept-CH-Lifetime", "Accept-Charset", "Accept-Encoding", "Accept-Language", "Accept-Patch", "Accept-Post", "Accept-Ranges", "Access-Control-Allow-Credentials", "Access-Control-Allow-Headers", "Access-Control-Allow-Methods", "Access-Control-Allow-Origin", "Access-Control-Expose-Headers", "Access-Control-Max-Age", "Access-Control-Request-Headers", "Access-Control-Request-Method", "Age", "Allow", "Alt-Svc", "Authorization", "Cache-Control", "Clear-Site-Data", "Connection", "Content-Disposition", "Content-Encoding", "Content-Language", "Content-Length", "Content-Location", "Content-Range", "Content-Security-Policy", "Content-Security-Policy-Report-Only", "Content-Type", "Cookie", "Cookie2", "Cross-Origin-Embedder-Policy", "Cross-Origin-Opener-Policy", "Cross-Origin-Resource-Policy", "DNT", "DPR", "Date", "Device-Memory", "Digest", "ETag", "Early-Data", "Expect", "Expect-CT", "Expires", "Feature-Policy", "Forwarded", "From", "Host", "If-Match", "If-Modified-Since", "If-None-Match", "If-Range", "If-Unmodified-Since", "Index", "Keep-Alive", "Large-Allocation", "Last-Modified", "Link", "Location", "NEL", "Origin", "Pragma", "Proxy-Authenticate", "Proxy-Authorization", "Public-Key-Pins", "Public-Key-Pins-Report-Only", "Range", "Referer", "Referrer-Policy", "Retry-After", "Save-Data", "Sec-Fetch-Dest", "Sec-Fetch-Mode", "Sec-Fetch-Site", "Sec-Fetch-User", "Sec-WebSocket-Accept", "Server", "Server-Timing", "Set-Cookie", "Set-Cookie2", "SourceMap", "Strict-Transport-Security", "TE", "Timing-Allow-Origin", "Tk", "Trailer", "Transfer-Encoding", "Upgrade", "Upgrade-Insecure-Requests", "User-Agent", "Vary", "Via", "WWW-Authenticate", "Want-Digest", "Warning", "X-Content-Type-Options", "X-DNS-Prefetch-Control", "X-Forwarded-For", "X-Forwarded-Host", "X-Forwarded-Proto", "X-Frame-Options", "X-XSS-Protection"];

            $(document).on('click', addHeaderData, function () {
                $(".headerDataKeys").autocomplete({
                    // source: availableTags,
                    autoFocus: true,
                    source: function (request, response) {
                        var results = $.ui.autocomplete.filter(availableTags, request.term);
                        response(results.slice(0, 10));
                    }
                });
            })
        });
    </script>

@endpush
