@extends('admin.layouts.app')
@section('title')
    @lang('Default Template')
@endsection
@section('content')
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


                    @if($emailTemplate->short_keys)
                        @foreach($emailTemplate->short_keys as $key=> $value)
                            <tr>
                                <td>
                                    <pre>[[@lang($key)]]</pre>
                                </td>
                                <td> @lang($value) </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">


            <ul class="nav nav-tabs mb-3">
                @foreach($mailTemplates as $key=>$value)
                    <li class="nav-item">
                        <a href="#tab-{{$value->id}}" data-toggle="tab" aria-expanded="{{($key == 0) ? 'true':'false'}}"
                           class="nav-link {{($key == 0) ? 'active':''}}">
                            <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">{{optional($value->language)->name}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($mailTemplates as $key=>$value)
                    <div class="tab-pane {{($key == 0) ? 'show active' : ''}}" id="tab-{{$value->id}}">
                        <h3 class="card-title my-3">{{trans('Mail in')}}  {{optional($value->language)->name}}
                            : {{$value->name}}</h3>


                        <form action="{{ route('admin.email-template.update',$value->id) }}" method="POST"
                              class="mt-4">
                            @csrf

                            <div class="row justify-content-between">
                                <div class="col-md-4 form-group">
                                    <label>@lang('Subject')</label>
                                    <input class="form-control" type="text" name="subject"
                                           value="{{ $value->subject }}">
                                    @if($errors->has('subject'))
                                        <div class="error text-danger">@lang($errors->first('subject')) </div>
                                    @endif
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>@lang('Mail from')</label>
                                    <input class="form-control" type="email" name="email_from"
                                           value="{{ $value->email_from }}">
                                    @if($errors->has('email_from'))
                                        <div class="error text-danger">@lang($errors->first('email_from')) </div>
                                    @endif
                                </div>


                                <div class="col-md-3 form-group">
                                    <label>@lang('Status')</label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='mail_status'>
                                        <input type="checkbox" name="mail_status" class="custom-switch-checkbox"
                                               id="status-{{$value->id}}"
                                               value="0" <?php if ($value->mail_status == 0):echo 'checked'; endif ?> >
                                        <label class="custom-switch-checkbox-label" for="status-{{$value->id}}">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label>@lang('Email Body')</label>
                                    <textarea class="form-control summernote" name="template" id="summernote"
                                              rows="20">{{ $value->template }}</textarea>
                                    @if($errors->has('template'))
                                        <div class="error text-danger">@lang($errors->first('template')) </div>
                                    @endif
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                                <span>@lang('Update')</span></button>

                        </form>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css')}}">
@endpush
@push('js')
    <script src="{{ asset('assets/admin/js/summernote.min.js')}}"></script>
    <script>
        "use strict";
        $(document).ready(function () {
           $('.summernote').summernote({
                minHeight: 200,
                callbacks: {
                    onBlurCodeview: function() {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
        });
    </script>
@endpush
