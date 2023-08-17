@extends($theme.'layouts.app')
@section('title',trans('About Us'))
@section('content')

    @if(isset($templates['about-us'][0]) && $about_us = $templates['about-us'][0])
        <!-- about section -->
        <section class="about-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="img-box">
                            <img src="{{getFile(config('location.content.path').@$about_us->templateMedia()->image)}}"
                                 alt="..." class="img-fluid"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="header-text">
                            <h5>@lang(optional($about_us->description)->title)</h5>
                            <h2>@lang(optional($about_us->description)->sub_title)</h2>
                        </div>
                        <p>
                            @lang(optional($about_us->description)->description)
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if (isset($contentDetails['testimonial']))
        <!-- testimonial section -->
        <section class="testimonial-section">
            <div class="container">
                <div class="row">
                    @if (isset($templates['testimonial'][0]) && ($testimonial = $templates['testimonial'][0]))
                        <div class="col">
                            <div class="header-text mb-5 text-center">
                                <h5>@lang(optional($testimonial->description)->title)</h5>
                                <h3>@lang(optional($testimonial->description)->sub_title)</h3>
                                <p>
                                    @lang(optional($testimonial->description)->short_description)
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="testimonials owl-carousel">
                            @forelse ($contentDetails['testimonial'] as $item )
                                <div class="review-box">
                                    <div class="upper">
                                        <div class="img-box">
                                            <img
                                                src="{{ getFile(config('location.content.path') . @$item->content->contentMedia->description->image) }}"
                                                alt="..."/>
                                        </div>
                                        <div class="client-info">
                                            <h5>@lang(@$item->description->name)</h5>
                                            <span> @lang(@$item->description->designation)</span>
                                        </div>
                                    </div>
                                    <p class="mb-0">
                                        @lang(@$item->description->description)
                                    </p>
                                    <i class="fad fa-quote-right quote"></i>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
