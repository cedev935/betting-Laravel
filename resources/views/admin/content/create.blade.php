@extends('admin.layouts.app')

@section('title',trans(snake2Title($content)))


@section('content')


    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">


        <div class="row justify-content-md-center">
            <div class="col-lg-12">
                <!-- Currency Create Form  -->
                <div class="card mb-4 shadow">
                    <div class="card-body">

                        <div class="media align-items-center justify-content-between mb-3">
                            <h4 class="card-title ">@lang(snake2Title($content))</h4>
                            <a href="{{route('admin.content.index',$content)}}" class="btn btn-sm btn-primary"> <i class="fas fa-arrow-left"></i> @lang('Back')</a>
                        </div>

                        @if(array_key_exists('language',config("contents.$content")) && config("contents.$content.language") == 0)
                            <form method="post" action="{{ route('admin.content.store', [$content,0]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    @foreach(config("contents.$content.field_name") as $name => $type)
                                        @if($type == 'file')

                                            <div class="col-md-4 source-parent">
                                                <div class="form-group">
                                                    <label for="{{ @$name }}">  @lang(ucwords(str_replace('_',' ',$name))) </label>
                                                    <div class="image-input ">
                                                        <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                                        <input type="file"  placeholder="Choose image" class="image-preview" id="{{ $name }}" name="{{ $name }}[0]">
                                                        <img id="image_preview_container" class="preview-image" src="{{getFile(config('location.content.path').(isset($templateMedia->description->{$name}) ? $templateMedia->description->{$name} : ''))}}"
                                                             alt="preview image">
                                                    </div>
                                                    @error($name.'.0') <span class="text-danger"> @lang($message)</span> @enderror
                                                </div>
                                            </div>



                                        @elseif($type == 'url')
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="{{ $name }}"> @lang(ucwords(str_replace('_',' ',$name))) </label>
                                                    <input type="{{ $type }}" name="{{ $name }}[{{ 0 }}]"
                                                           class="form-control  @error($name.'.0') is-invalid @enderror"
                                                           value="{{ old($name.'.0', isset($templateMedia->description->{$name}) ? $templateMedia->description->{$name} : '') }}">
                                                    <div class="invalid-feedback">
                                                        @error($name.'.0') @lang($message) @enderror
                                                    </div>
                                                    <div class="valid-feedback"></div>
                                                </div>
                                            </div>
                                        @elseif($type == 'icon')
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="{{ $name }}"> @lang(ucwords(str_replace('_',' ',$name))) </label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" name="{{ $name }}[{{ 0 }}]"
                                                               class="form-control icon @error($name.'.0') is-invalid @enderror"
                                                               value="{{ old($name.'.0', isset($templates[0]) ? $templates[0][0]->description->{$name} : '') }}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-primary iconPicker" data-icon="fas fa-home" role="iconpicker"></button>
                                                        </div>
                                                        <div class="invalid-feedback">@error($name.'.0') @lang($message) @enderror</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm btn-block">@lang('Save Change')</button>
                            </form>

                        @else
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach($languages as $key => $language)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#lang-tab-{{ $key }}" role="tab" aria-controls="lang-tab-{{ $key }}"
                                           aria-selected="{{ $loop->first ? 'true' : 'false' }}">@lang($language->name)</a>
                                    </li>
                                @endforeach
                            </ul>


                            <div class="tab-content mt-2" id="myTabContent">
                                @foreach($languages as $key => $language)

                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-tab-{{ $key }}" role="tabpanel">
                                        <form method="post" action="{{ route('admin.content.store', [$content,$language->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                @foreach(config("contents.$content.field_name") as $name => $type)
                                                    @if($type == 'text' )
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="{{ $name }}"> @lang(ucwords(str_replace('_',' ',$name))) </label>
                                                                <input type="{{ $type }}" name="{{ $name }}[{{ $language->id }}]"
                                                                       class="form-control  @error($name.'.'.$language->id) is-invalid @enderror"
                                                                       value="{{ old($name.'.'.$language->id, isset($templates[$language->id]) ? $templates[$language->id][0]->description->{$name} : '') }}">
                                                                <div class="invalid-feedback">
                                                                    @error($name.'.'.$language->id) @lang($message) @enderror
                                                                </div>
                                                                <div class="valid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    @elseif($type == 'file' && $key == 0)


                                                        <div class="col-md-4 source-parent">
                                                            <div class="form-group">
                                                                <label for="{{ @$name }}"> @lang(ucwords(str_replace('_',' ',@$name))) </label>
                                                                <div class="image-input ">
                                                                    <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                                                                    <input type="file"  placeholder="Choose image" class="image-preview"  id="{{$name}}" name="{{ $name }}[{{ $language->id }}]">
                                                                    <img id="image_preview_container" class="preview-image" src="{{getFile(config('location.default'))}}"
                                                                         alt="preview image">
                                                                </div>


                                                                @if(config("contents.$content.size.image"))
                                                                    <span class="text-muted mb-2">{{trans('Image size should be')}} {{config("contents.$content.size.image")}} {{trans('px')}}</span>
                                                                @endif

                                                                @error($name.'.'.$language->id)
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror

                                                            </div>
                                                        </div>


                                                    @elseif($type == 'url' && $key == 0)
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="{{ $name }}"> @lang(ucwords(str_replace('_',' ',$name))) </label>
                                                                <input type="{{ $type }}" name="{{ $name }}[{{ $language->id }}]"
                                                                       class="form-control  @error($name.'.'.$language->id) is-invalid @enderror"
                                                                       value="{{ old($name.'.'.$language->id, isset($templateMedia->description->{$name}) ? $templateMedia->description->{$name} : '') }}">
                                                                <div class="invalid-feedback">
                                                                    @error($name.'.'.$language->id) @lang($message) @enderror
                                                                </div>
                                                                <div class="valid-feedback"></div>
                                                            </div>
                                                        </div>
                                                    @elseif($type == 'textarea')
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="{{ $name }}">@lang(ucwords(str_replace('_',' ',$name)))</label>
                                                                <textarea class="form-control  summernote @error($name.'.'.$language->id) is-invalid @enderror"
                                                                          name="{{ $name }}[{{ $language->id }}]"
                                                                          rows="5">{{ old($name.'.'.$language->id, isset($templates[$language->id]) ? $templates[$language->id][0]->description->{$name} : '') }}</textarea>
                                                                <div class="invalid-feedback">
                                                                    @error($name.'.'.$language->id) @lang($message) @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($type == 'icon' && $key == 0)
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="{{ $name }}"> @lang(ucwords(str_replace('_',' ',$name))) </label>
                                                                <div class="input-group">
                                                                    <input type="text" name="{{ $name }}[{{ $language->id }}]"
                                                                           class="form-control icon @error($name.'.'.$language->id) is-invalid @enderror"
                                                                           value="{{ old($name.'.'.$language->id, isset($templates[$language->id]) ? $templates[$language->id][0]->description->{$name} : '') }}">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-primary iconPicker" data-icon="fas fa-home" role="iconpicker"></button>
                                                                    </div>
                                                                    <div class="invalid-feedback">@error($name.'.'.$language->id) @lang($message) @enderror</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save Change')</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---Container Fluid-->




@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
    <link href="{{ asset('assets/admin/css/bootstrap-iconpicker.min.css') }}" rel="stylesheet" type="text/css">
@endpush


@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
@endpush

@push('js')
    <script>
        'use strict'
        $(document).ready(function () {


            $('.image-preview').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('.summernote').summernote({
                minHeight: 200,
                callbacks: {
                    onBlurCodeview: function() {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });

            $('.iconPicker').iconpicker({
                align: 'center', // Only in div tag
                arrowClass: 'btn-danger',
                arrowPrevIconClass: 'fas fa-angle-left',
                arrowNextIconClass: 'fas fa-angle-right',
                cols: 10,
                footer: true,
                header: true,
                icon: 'fas fa-bomb',
                iconset: 'fontawesome5',
                labelHeader: '{0} of {1} pages',
                labelFooter: '{0} - {1} of {2} icons',
                placement: 'bottom', // Only in button tag
                rows: 5,
                search: true,
                searchText: 'Search icon',
                selectedClass: 'btn-success',
                unselectedClass: ''
            }).on('change', function (e) {
                $(this).parent().siblings('.icon').val(`${e.icon}`);
            });
        });


    </script>
@endpush
