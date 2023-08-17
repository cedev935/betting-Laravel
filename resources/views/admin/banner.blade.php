@extends('admin.layouts.app')

@section('title')
    @lang('Banner Settings')
@endsection


@section('content')
    <div class="container-fluid">
        <div class="alert alert-warning mb-4" role="alert">
            <i class="fas fa-info-circle mr-2"></i> @lang('After changes image. Please clear your browser\'s cache to see changes.')
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">


                        <form action="{{ route('admin.breadcrumbUpdate')}}" method="post"
                              enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row justify-content-center">


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5 class="text-dark">@lang('Login/Register Image')</h5>
                                        <div class="image-input ">
                                            <label for="image-upload" id="image-label"><i
                                                    class="fas fa-upload"></i></label>
                                            <input type="file" name="loginImage" placeholder="@lang('Choose image')"
                                                   id="loginImage">
                                            <img id="loginImage_preview_container" class="preview-image"
                                                 src="{{getFile(config('location.logo.path').'loginImage.png') ? : 0}}"
                                                 alt="preview image">
                                        </div>
                                        @error('loginImage')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5 class="text-dark">@lang('Banner Image')</h5>
                                        <div class="image-input">
                                            <label for="image-upload" id="image-label"><i
                                                    class="fas fa-upload"></i></label>
                                            <input type="file" name="banner" placeholder="@lang('Choose image')"
                                                   id="image">
                                            <img id="image_preview_container" class="preview-image"
                                                 src="{{getFile(config('location.logo.path').'banner.jpg') ? : 0}}"
                                                 alt="preview image">
                                        </div>
                                        @error('banner')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5 class="text-dark">@lang('Footer Background')</h5>

                                        <div class="image-input">
                                            <label for="image-upload" id="image-label"><i
                                                    class="fas fa-upload"></i></label>
                                            <input type="file" name="footer" placeholder="@lang('Choose image')"
                                                   id="footerImage">
                                            <img id="footerImage_preview_container" class="preview-image"
                                                 src="{{getFile(config('location.logo.path').'footer.jpg') ? : 0}}"
                                                 alt="preview image">
                                        </div>
                                        @error('footer')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">


                                <div class="col-md-12">
                                    <div class="submit-btn-wrapper text-center mt-4">
                                        <button type="submit"
                                                class="btn waves-effect waves-light btn-primary btn-block btn-rounded">
                                            <span>@lang('Save Changes')</span></button>
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

            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });


            $('#footerImage').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#footerImage_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });


            $('#loginImage').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#loginImage_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });
    </script>
@endpush
