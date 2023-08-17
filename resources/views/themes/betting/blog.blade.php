@extends($theme.'layouts.app')
@section('title', trans($title))

@section('content')
    @if(isset($contentDetails['blog']))
        <!-- blog details -->
        <section class="blog-details blog-list">
            <div class="container">
                <div class="row justify-content-center gy-5 g-lg-5">
                    <div class="col-lg-10">
                        @forelse ( $contentDetails['blog'] as $key => $item )
                            <div class="blog-box row">
                                <div class="col-md-6 img-box">
                                    <img
                                        src="{{ getFile(config('location.content.path') . optional($item->content)->contentMedia->description->image) }}"
                                        class="img-fluid"
                                        alt="..."/>
                                </div>
                                <div class="col-md-6 text-box">
                                    <a href="{{ route('blogDetails', [slug(optional($item->description)->title), $item->content_id]) }}"
                                       class="title">
                                        @lang(optional($item->description)->title)
                                    </a>
                                    <div class="date-author">
                           <span class="author">
                              <i class="fas fa-dot-circle"></i>@lang('Admin')
                           </span>
                                        <span class="float-end">{{dateTime($item->created_at, 'd M, Y')}}</span>
                                    </div>
                                    <p>
                                        @lang(Str::limit(optional($item->description)->description,200))
                                    </p>
                                    <a href="{{ route('blogDetails', [slug(optional($item->description)->title), $item->content_id]) }}" class="read-more">@lang('Read more')</a>
                                </div>
                            </div>
                        @empty
                        @endforelse

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
