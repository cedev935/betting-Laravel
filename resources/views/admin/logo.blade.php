@extends('admin.layouts.app')

@section('title')
    @lang('Logo & Seo Settings')
@endsection
@section('content')
    <div class="container-fluid">

        <div class="alert alert-warning mb-4" role="alert">
            <i class="fas fa-info-circle mr-2"></i> @lang('After changes images/SEO. Please clear your browser\'s cache to see changes.')
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-primary shadow">
                    <div class="card-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ $errors->has('profile') ? 'active' : ($errors->has('password') ? '' : 'active') }}"
                                   data-toggle="tab" href="#home">@lang('Logo Favicon & Image')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ $errors->has('password') ? 'active' : '' }}" data-toggle="tab"
                                   href="#menu1">@lang('SEO & META Keywords')</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="home"
                                 class="mt-3 container tab-pane {{ $errors->has('profile') ? 'active' : ($errors->has('password') ? '' : 'active') }}">
                                <form action="{{ route('admin.logoUpdate')}}" method="post"
                                      enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <h5 class="text-dark">@lang('Frontend Logo')</h5>
                                                <div class="image-input">
                                                    <label for="image-upload" id="image-label"><i
                                                            class="fas fa-upload"></i></label>
                                                    <input type="file" name="image" placeholder="@lang('Choose image')"
                                                           id="image">
                                                    <img id="image_preview_container" class="preview-image"
                                                         src="{{getFile(config('location.logo.path').'logo.png') ? : 0}}"
                                                         alt="preview image">
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <h5 class="text-dark">@lang('Admin Panel Logo')</h5>
                                                <div class="image-input">
                                                    <label for="image-upload" id="adminLogo-label"><i
                                                            class="fas fa-upload"></i></label>
                                                    <input type="file" name="admin_logo" placeholder="@lang('Choose image')"
                                                           id="adminLogo">
                                                    <img id="adminLogo_preview_container" class="preview-image"
                                                         src="{{getFile(config('location.logo.path').'admin-logo.png') ? : 0}}"
                                                         alt="preview image">
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <h5 class="text-dark">@lang('Favicon')</h5>
                                                <div class="image-input ">
                                                    <label for="image-upload" id="image-label"><i
                                                            class="fas fa-upload"></i></label>
                                                    <input type="file" name="favicon" placeholder="@lang('Choose image')"
                                                           id="favicon">
                                                    <img id="favicon_preview_container" class="preview-image"
                                                         src="{{getFile(config('location.logo.path').'favicon.png') ? : 0}}"
                                                         alt="preview image">
                                                </div>
                                                @error('favicon')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-9">

                                            <div class="submit-btn-wrapper text-center mt-4">
                                                <button type="submit"
                                                        class="btn waves-effect waves-light btn-primary btn-block btn-rounded">
                                                    <span>@lang('Save Changes')</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div id="menu1"
                                 class="mt-3 container tab-pane {{ $errors->has('password') ? 'active' : '' }}">


                                <form method="post" action="{{ route('admin.seoUpdate') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('put')


                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                @csrf
                                                <div class="image-input ">
                                                    <label for="meta_image-upload" id="image-label"><i
                                                            class="fas fa-upload"></i></label>
                                                    <input type="file" name="meta_image" placeholder="@lang('Choose image')"
                                                           id="meta_image">
                                                    <img id="meta_image_preview_container" class="preview-image"
                                                         src="{{getFile(config('location.logo.path').config('seo.meta_image')) ? : 0}}"
                                                         alt="preview image">
                                                </div>
                                                @error('favicon')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>@lang('Meta keywords')</label>
                                                <input type="text" class="form-control" name="meta_keywords"
                                                       autocomplete="off"
                                                       value="{{ old('meta_keywords',@$seo->meta_keywords)  }}">
                                                <span class="text-muted">@lang("Keyword should separated by coma (,)")</span>
                                                @if($errors->has('meta_keywords'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('meta_keywords')) </div>
                                                @endif
                                            </div>


                                            <div class="form-group">
                                                <label>@lang('Meta Description')</label>

                                                <textarea name="meta_description" rows="3" class="form-control"
                                                          placeholder="@lang('Meta description')"
                                                          required>{{ old('meta_description',@$seo->meta_description)}}</textarea>

                                                @if($errors->has('meta_description'))
                                                    <div class="error text-danger">@lang($errors->first('meta_description')) </div>
                                                @endif
                                            </div>


                                            <div class="form-group">
                                                <label>@lang('Social title')</label>
                                                <input type="text" class="form-control" name="social_title"
                                                       value="{{(old('social_title',$seo->social_title))}}"
                                                       autocomplete="off">
                                                @if($errors->has('social_title'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('social_title')) </div>
                                                @endif
                                            </div>


                                            <div class="form-group">
                                                <label
                                                    class="form-control-label  font-weight-bold">@lang('Social Description')</label>
                                                <textarea name="social_description" rows="3" class="form-control"
                                                          placeholder="@lang('Social Share meta description')"
                                                          required>{{old('social_description',@$seo->social_description)   }}</textarea>

                                                @if($errors->has('social_description'))
                                                    <div
                                                        class="error text-danger">@lang($errors->first('social_description')) </div>
                                                @endif

                                            </div>

                                            <div class="form-group">
                                                <div class="submit-btn-wrapper text-center">
                                                    <button type="submit"
                                                            class=" btn waves-effect waves-light btn-primary btn-block btn-rounded">
                                                        <span>@lang('Save Changes')</span></button>
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

            $('#adminLogo').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#adminLogo_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#favicon').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#favicon_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
            $('#meta_image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#meta_image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });


        });
    </script>
@endpush
