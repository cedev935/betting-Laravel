@extends($theme.'layouts.app')
@section('title', trans('Frequently Ask Question'))

@section('content')
    @if(isset($contentDetails['faq']))
        <!-- faq section -->
        <section class="faq-section faq-page">
            <div class="container">
                <div class="row g-4 gy-5 justify-content-center align-items-center">
                    <div class="col-lg-12">
                        <div class="accordion" id="accordionExample">
                            @forelse ( $contentDetails['faq'] as $key => $item )
                                <div class="accordion-item">
                                    <h5 class="accordion-header" id="heading{{$key}}">
                                        <button
                                            class="accordion-button @if($key != 0)collapsed" @endif
                                        type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$key}}"
                                            aria-expanded="true"
                                            aria-controls="collapse{{$key}}">
                                            @lang(@$item->description->title)
                                        </button>
                                    </h5>
                                    <div
                                        id="collapse{{$key}}"
                                        class="accordion-collapse collapse @if ($key==0)
                                        show"
                                        @endif
                                        aria-labelledby="heading{{$key}}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @lang(optional($item->description)->description)
                                        </div>
                                    </div>
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
