@extends('admin.layouts.app')
@section('title')
    @lang('Email Controls')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <button class="btn btn-primary btn-sm mb-2" type="button" data-toggle="modal"
                            data-target="#testEmail">
                        <span class="btn-label"><i class="fas fa-envelope"></i></span>
                        @lang('Test Email')
                    </button>
                    <a href="https://www.youtube.com/watch?v=dv3UxhWg" target="_blank"
                       class="btn btn-primary btn-sm mb-2 text-white float-right" type="button">
                        <span class="btn-label"><i class="fab fa-youtube"></i></span>
                        @lang('How to set up it?')
                    </a>
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
                                    <pre>@lang(' [[name]] ')</pre>
                                </td>
                                <td> @lang("User's Name will replace here.") </td>
                            </tr>
                            <tr>
                                <td>
                                    <pre>@lang(' [[message]] ')</pre>
                                </td>
                                <td>@lang("Application notification message will replace here.")</td>
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
                    <h4 class="card-title">@lang('Email Action')</h4>
                    <form method="post" action="{{route('admin.email-controls.action')}}" novalidate="novalidate"
                          class="needs-validation base-form ">
                        @csrf
                        <div class="row">

                            <div class="form-group col-lg-6 col-md-6">
                                <label class="d-block">@lang('Email Notification')</label>

                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='email_notification'>
                                    <input type="checkbox" name="email_notification" class="custom-switch-checkbox"
                                           id="email_notification"
                                           value="0" <?php if ($control->email_notification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="email_notification">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group col-lg-6 col-md-6">
                                <label class="d-block">@lang('Email Verification')</label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='email_verification'>
                                    <input type="checkbox" name="email_verification" class="custom-switch-checkbox"
                                           id="email_verification"
                                           value="0" <?php if ($control->email_verification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="email_verification">
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
        <div class="col-md-6">

        </div>

    </div>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>@lang('From Email')</label>
                            <input type="text" name="sender_email" class="form-control"
                                   placeholder="@lang('Email Address')" value="{{$control->sender_email}}">
                            @error('sender_email')
                            <span class="text-danger">{{ trans($message) }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>@lang('From Email Name')</label>
                            <input type="text" name="sender_email_name" class="form-control"
                                   placeholder="@lang('Email Address')" value="{{$control->sender_email_name}}">
                            @error('sender_email_name')
                            <span class="text-danger">{{ trans($message) }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label>{{trans('Send Email Method')}}</label>
                            <select name="email_method" class="form-control">
                                <option value="sendmail"
                                        @if(old('email_method', @$control->email_configuration->name) == "sendmail")  selected @endif>@lang('PHP Mail')</option>
                                <option value="smtp"
                                        @if( old('email_method', @$control->email_configuration->name) == "smtp") selected @endif>@lang('SMTP')</option>
                            </select>

                            @error('email_method')
                            <span class="text-danger">{{ trans($message) }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row mt-4 d-none configForm" id="smtp">
                    <div class="col-md-12">
                        <h6 class="mb-2">{{trans('SMTP Configuration')}}</h6>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">{{trans('Host')}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="@lang('Host or Email Address')"
                               name="smtp_host"
                               value="{{ old('smtp_host', $control->email_configuration->smtp_host ?? '') }}"/>
                        @error('smtp_host')
                        <span class="text-danger">{{ trans($message) }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">{{trans('Port')}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="@lang('Available port')" name="smtp_port"
                               value="{{ old('smtp_port', $control->email_configuration->smtp_port ?? '') }}"/>
                        @error('smtp_port')
                        <span class="text-danger">{{ trans($message) }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold">{{trans('Encryption')}}</label>

                        <select name="smtp_encryption" class="form-control">
                            <option value="tls"
                                    @if( old('smtp_encryption', @$control->email_configuration->smtp_encryption) == "tls") selected @endif>@lang('tls')</option>
                            <option value="ssl"
                                    @if( old('smtp_encryption', @$control->email_configuration->smtp_encryption) == "ssl") selected @endif>@lang('ssl')</option>
                        </select>

                        @error('smtp_encryption')
                        <span class="text-danger">{{ trans($message) }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">{{trans('Username')}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="@lang('username or Email')"
                               name="smtp_username"
                               value="{{ old('smtp_username', $control->email_configuration->smtp_username ?? '') }}"/>
                        @error('smtp_username')
                        <span class="text-danger">{{ trans($message) }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold">{{trans('Password')}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="@lang('Password')" name="smtp_password"
                               value="{{ old('smtp_password', $control->email_configuration->smtp_password ?? '') }}"/>
                        @error('smtp_password')
                        <span class="text-danger">{{ trans($message) }}</span>
                        @enderror
                    </div>
                </div>


                <div class="form-group ">
                    <label>@lang('Email Description')</label>
                    <textarea class="form-control summernote" name="email_description" id="summernote"
                              placeholder="@lang('Email Description')"
                              rows="20"><?php echo $email_description ?></textarea>
                </div>
                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                    <span>@lang('Save Changes')</span></button>
            </form>
        </div>
    </div>
    <!-- testEmail Modal -->
    <div class="modal fade" id="testEmail">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('admin.testEmail')}}" class="" enctype="multipart/form-data">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title">@lang('Test Email')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label for="email">@lang('Enter Your Email')</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="@lang('Enter Your Email')" >
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span>@lang('Close')</span>
                        </button>
                        <button type="submit" class=" btn btn-primary "><span>@lang('Yes')</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css')}}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js')}}"></script>
@endpush
@push('js')
    <script>
        "use strict";
        $(document).ready(function () {


            $('#summernote').summernote({
                minHeight: 200,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
        });
        $('select[name=email_method]').on('change', function () {
            var method = $(this).val();

            $('.configForm').addClass('d-none');
            if (method != 'sendmail') {
                $(`#${method}`).removeClass('d-none');
            }
        }).change();


    </script>
@endpush
