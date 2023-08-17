@extends('admin.layouts.app')
@section('title')
    @lang('SMS Template')
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
                    @if($smstemplate->short_keys)
                        @foreach($smstemplate->short_keys as $key=> $value)
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
                @foreach($smsTemplates as $key=>$value)
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
                @foreach($smsTemplates as $key=>$value)
                    <div class="tab-pane {{($key == 0) ? 'show active' : ''}}" id="tab-{{$value->id}}">
                        <h3 class="card-title my-3">{{trans('SMS in')}} {{optional($value->language)->name}} : {{$value->name}}</h3>

                        <form action="{{ route('admin.sms-template.update',$value->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label class="font-weight-bold">@lang('Status')</label>
                                    <div class="custom-switch-btn">
                                        <input type='hidden' value='1' name='sms_status'>
                                        <input type="checkbox" name="sms_status" class="custom-switch-checkbox"
                                               id="status-{{$value->id}}"
                                               value="0" <?php if ($value->sms_status == 0):echo 'checked'; endif ?> >
                                        <label class="custom-switch-checkbox-label" for="status-{{$value->id}}">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Message Body')</label>
                                <textarea class="form-control" name="sms_body" rows="10">{{(old('sms_body', $value->sms_body)) }}</textarea>
                                @if($errors->has('sms_body'))
                                    <div class="error text-danger">@lang($errors->first('sms_body')) </div>
                                @endif
                            </div>


                            <button type="submit"
                                    class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                                <span>@lang('Save Change')</span></button>

                        </form>

                    </div>
                @endforeach
            </div>


        </div>
    </div>

@endsection
