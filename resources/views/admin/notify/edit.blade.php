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


                    @if($notifyTemplate->short_keys)
                        @foreach($notifyTemplate->short_keys as $key=> $value)
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
                @foreach($templates as $key=>$value)
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
                @foreach($templates as $key=>$value)
                    <div class="tab-pane {{($key == 0) ? 'show active' : ''}}" id="tab-{{$value->id}}">
                        <h3 class="card-title my-3">{{trans('Notification in')}}  {{optional($value->language)->name}}
                            : {{$value->name}}</h3>


                        <form action="{{ route('admin.notify-template.update',$value->id) }}" method="POST" class="mt-4">
                            @csrf

                                <div class="form-group">
                                    <label>@lang('Notification Message')</label>
                                    <textarea name="body" class="form-control"  rows="10">{{ $value->body }}</textarea>
                                    @if($errors->has('body'))
                                        <div class="error text-danger">@lang($errors->first('body')) </div>
                                    @endif
                                </div>


                            <div class="row justify-content-between">
                                <div class="col-md-3 form-group">
                                    <label>@lang('Status')</label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='status'>
                                        <input type="checkbox" name="status" class="custom-switch-checkbox"
                                               id="status-{{$value->id}}"
                                               value="0" <?php if ($value->status == 0):echo 'checked'; endif ?> >
                                        <label class="custom-switch-checkbox-label" for="status-{{$value->id}}">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                                <span>@lang('Update')</span>
                            </button>

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
