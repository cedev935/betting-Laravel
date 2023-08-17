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
                        <h4 class="card-title mb-5"><i class="icon-key"></i> @lang('Password Setting')</h4>
                        <form action="" method="post" class="form-body file-upload">
                            @csrf
                            @method('put')


                            <div class="form-body">

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-2">@lang('Current Password')</label>
                                        <div class="col-lg-6">
                                            <input type="password" class="form-control" name="current_password" placeholder="@lang('Current Password')">

                                            @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-2">@lang('New Password')</label>
                                        <div class="col-lg-6">
                                            <input type="password" name="password" class="form-control" placeholder="@lang('New Password')">
                                            @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-2">@lang('Confirm Password')</label>
                                        <div class="col-lg-6">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')">
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <div class="row ">
                                        <div class="col-md-6 offset-md-2">
                                                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Change Password')</button>
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

@push('js-lib')
@endpush

@push('js')
    <script>
        $(document).ready(function (e) {
            "use strict";

            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
