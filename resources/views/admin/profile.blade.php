@extends('admin.layouts.app')

@section('title')
    @lang('profile')
@endsection


@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3"><i class="icon-user"></i> @lang('Profile Setting')</h4>
                    <form action="" method="post" class="form-body file-upload" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-row justify-content-between">
                            <div class="col-sm-6 col-md-3">
                                <div class="image-input ">
                                    <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                    <input type="file" name="image" placeholder="" id="image">
                                    <img id="image_preview_container" class="preview-image" src="{{ getFile(config('location.admin.path').$admin->image) }}"
                                         alt="preview image">
                                </div>
                                @error('image')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-sm-6 col-md-8">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Name') <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control form-control-lg" value="{{$admin->name}}" placeholder="@lang('Enter Name')">

                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Username') <span class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control" value="{{$admin->username}}" placeholder="@lang('Enter Username')">

                                            @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Email Address') <span class="text-danger">*</span></label>
                                            <input type="text" name="email" class="form-control" value="{{$admin->email}}" placeholder="@lang('Enter Email Address')">


                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Phone Number') <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control" value="{{$admin->phone}}" placeholder="@lang('Enter Phone Number')">

                                            @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('Address') <span class="text-muted text-sm">{{trans('(optional)')}}</span></label>
                                            <textarea name="address" class="form-control" rows="3" placeholder="@lang('Your Address')">{{$admin->address}}</textarea>

                                            @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">{{trans('Submit')}}</button>
                                        </div>
                                    </div>
                                </div>


                            </div>



                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>







@endsection

@push('js')
    <script>
        $(document).ready(function (e) {
            "use strict";

            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
