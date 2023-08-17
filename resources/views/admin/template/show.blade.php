@extends('admin.layouts.app')

@section('title',__(kebab2Title($section)))


@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">


        <div class="row justify-content-md-center">
            <div class="col-lg-12">
                <!-- Currency Create Form  -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="media align-items-center justify-content-between mb-3">
                            <h4 class="card-title">@lang(ucfirst(kebab2Title($section)))</h4>
                            <a href="{{  url()->previous()}}" class="btn btn-sm btn-primary">@lang('Back')</a>
                        </div>

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
                                    <form method="post" action="{{ route('admin.template.update', [$section,$language->id]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row">
                                            @foreach(config("templates.$section.field_name") as $name => $type)
                                                @if($type == 'text')
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="{{ @$name }}"> @lang(ucwords(str_replace('_',' ',@$name))) </label>
                                                            <input type="{{ @$type }}" name="{{ @$name }}[{{ $language->id }}]"
                                                                   class="form-control  @error($name.'.'.$language->id) is-invalid @enderror"
                                                                   value="{{ old(@$name.'.'.$language->id, isset($templates[$language->id]) ? @$templates[$language->id][0]->description->{@$name} : '') }}">
                                                            <div class="invalid-feedback">
                                                                @error(@$name.'.'.$language->id) @lang($message) @enderror
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
                                                                <input type="file"  placeholder="@lang('Choose image')" class="image-preview"  id="{{ $name }}" name="{{ $name }}[{{ $language->id }}]">
                                                                <img id="image_preview_container" class="preview-image" src="{{getFile(config('location.template.path').(isset($templateMedia->description->{$name}) ? $templateMedia->description->{$name} : ''))}}"
                                                                     alt="preview image">
                                                            </div>
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
                                                                      rows="5">{{ old($name.'.'.$language->id, isset($templates[$language->id]) ? @$templates[$language->id][0]->description->{$name} : '') }}</textarea>
                                                            <div class="invalid-feedback">
                                                                @error($name.'.'.$language->id) @lang($message) @enderror
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---Container Fluid-->


@endsection


@push('style-lib')
    <link href="{{ asset('assets/admin/css/summernote.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote.min.js') }}"></script>
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
                height: 200,
                minHeight: null,
                maxHeight: null,
                callbacks: {
                            onBlurCodeview: function() {
                                let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                                $(this).val(codeviewHtml);
                            }
                        }
                // focus: true
            });
        });
    </script>
@endpush
