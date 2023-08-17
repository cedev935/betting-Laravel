@extends('admin.layouts.app')
@section('title')
    @lang('Email')
@endsection
@section('content')

    <div class="m-0 m-md-4 my-4 m-md-0 shadow">
        <form method="post" action="{{route('admin.email-send.store')}}">
            @csrf
            <div class="col-sm-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <h3>@lang("Send Email To All User's")</h3>
                        <div class="form-group ">
                            <label>@lang('Subject')</label>
                            <input type="text" name="subject" value="{{old('subject')}}"
                                   placeholder="@lang('Write Subject')" class="form-control">
                            @error('subject')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label>@lang('Message')</label>
                            <textarea class="form-control" name="message" id="summernote"
                                      rows="15">{{old('message')}}</textarea>
                            @error('message')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="submit-btn-wrapper mt-md-3 text-center text-md-left">
                            <button type="submit"
                                    class=" btn waves-effect waves-light btn-rounded btn-primary btn-block">
                                <span>@lang('Send Email')</span></button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

@endsection


@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css')}}">
@endpush
@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js')}}"></script>
@endpush
@push('js')
    <script type="text/javascript">
        "use strict";
        $(document).ready(function () {
            $('#summernote').summernote({
                height: 200,
                dialogsInBody: true,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }

            });
        });
    </script>
@endpush
