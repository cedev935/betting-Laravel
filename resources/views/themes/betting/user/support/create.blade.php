@extends($theme.'layouts.user')
@section('title',__($page_title))

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <div class="card secbg form-block br-4">
                <div class="card-body">
                    <div class="card-body-inner">
                        <form class="form-row" action="{{route('user.ticket.store')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label>@lang('Subject')</label>
                                <div class="form-group input-box mb-3">
                                    <input class="form-control" type="text" name="subject"
                                           value="{{old('subject')}}" placeholder="@lang('Enter Subject')">
                                    @error('subject')
                                    <div class="error text-danger">@lang($message) </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>@lang('Message')</label>
                                <div class="form-group input-box mb-3">
                                    <textarea class="form-control ticket-box" name="message" rows="5"
                                              id="textarea1"
                                              placeholder="@lang('Enter Message')">{{old('message')}}</textarea>
                                    @error('message')
                                    <div class="error text-danger">@lang($message) </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group input-box">
                                    <input type="file" name="attachments[]"
                                           class="form-control "
                                           multiple
                                           placeholder="@lang('Upload File')">

                                    @error('attachments')
                                    <span class="text-danger">{{trans($message)}}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group mt-3">
                                    <button type="submit"
                                            class="btn-custom w-100">
                                        <span>@lang('Submit')</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
