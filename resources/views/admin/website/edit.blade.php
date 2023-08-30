@extends('admin.layouts.app')
@section('title')
    @lang('Edit Language')
@endsection
@section('content')


    <div class="card card-primary card-form m-0 m-md-4 my-4 m-md-0">
        <div class="card-body">

            <a href="{{route('admin.language.index') }}" class="btn btn-sm btn-primary float-right mb-3"><i class="fas fa-arrow-left"></i> @lang('Back')</a>




            <form method="post" action="{{ route('admin.language.update',$language) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mt-5 justify-content-center">

                    <div class="col-md-3 d-none">
                        <div class="image-input ">
                            <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                            <input type="file" name="flag" placeholder="Choose image" id="image">
                            <img id="image_preview_container" class="preview-image" src="{{ getFile(config('location.language.path').$language->flag) }}"
                                 alt="preview image">
                        </div>
                        @error('flag')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">@lang('Name')</label>
                            <input type="text" name="name" value="{{old('name',$language->name)}}" placeholder="@lang('Enter name of country')" class="form-control  @error('name') is-invalid @enderror">
                            <div class="invalid-feedback">@error('name') @lang($message) @enderror</div>
                        </div>


                        <div class="form-group">
                            <label for="short_name">@lang('Short Name')</label>
                            <select name="short_name" class="select2-single form-control @error('short_name') is-invalid @enderror" id="short_name">
                                @foreach(config('languages.langCode') as $key => $value)
                                    <option value="{{$key}}" {{  (old('short_name',$language->short_name) == $key ? ' selected' : '')  }}>{{ $key.' - '.$value }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">@error('short_name') @lang($message) @enderror</div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="d-block">@lang('Status')</label>
                                    <div class="custom-switch-btn w-md-75">
                                        <input type='hidden' value="1" name='is_active'>
                                        <input type="checkbox" name="is_active" class="custom-switch-checkbox" id="is_active"  value = "0" <?php if( $language->is_active == 0):echo 'checked'; endif ?> >
                                        <label class="custom-switch-checkbox-label" for="is_active">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"></span>
                                        </label>
                                    </div>
                                    @error('is_active')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-md-6 d-none">
                                <div class="form-group ">
                                    <label class="d-block">@lang('RTL')</label>
                                    <div class="custom-switch-btn w-md-75">
                                        <input type='hidden' value="1" name='rtl'>
                                        <input type="checkbox" name="rtl" class="custom-switch-checkbox"

                                               id="rtl"  value = "0" <?php if( $language->rtl == 0):echo 'checked'; endif ?> >
                                        <label class="custom-switch-checkbox-label" for="rtl">
                                            <span class="custom-switch-checkbox-inner"></span>
                                            <span class="custom-switch-checkbox-switch"> </span>
                                        </label>
                                    </div>
                                    @error('rtl')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <button class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                            @lang('Save Changes')
                        </button>
                    </div>



                </div>

            </form>

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

            $('select[name=short_name]').select2({
                selectOnClose: true
            });
        });
    </script>
@endpush
