@extends($theme.'layouts.app')
@section('title',trans('Blog Details'))

@section('content')
    <!-- blog details -->
    <section class="blog-details blog-list">
        <div class="container">
            <div class="row gy-5 g-lg-5">
                <div class="col-lg-8">
                    <div class="blog-box row">
                        <div class="col-md-12 img-box">
                            <img
                                src="{{ $singleItem['image'] }}"
                                class="img-fluid"
                                alt="{{ $singleItem['title'] }}"/>
                        </div>
                        <div class="col-md-12 text-box">
                            <a href="javascript:void(0)" class="title">
                                @lang($singleItem['title'])
                            </a>
                            <div class="date-author">
                           <span class="author">
                              <i class="fas fa-dot-circle"></i>@lang('Admin')
                           </span>
                                <span class="float-end">@lang($singleItem['date'])</span>
                            </div>
                            <p>
                                @lang($singleItem['description'])
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4>@lang('Related Posts')</h4>
                    @if (isset($popularContentDetails['blog']))
                        @foreach ($popularContentDetails['blog']->sortDesc() as $data)
                            <div class="related-post">
                                <div class="img-box">
                                    <img
                                        class="img-fluid"
                                        src="{{ getFile(config('location.content.path') . @$data->content->contentMedia->description->image) }}"
                                        alt="..."/>
                                </div>
                                <div class="text-box">
                                    <a href="{{ route('blogDetails', [slug(optional($data->description)->title), $data->content_id]) }}" class="title">
                                        @lang(@$data->description->title)
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
