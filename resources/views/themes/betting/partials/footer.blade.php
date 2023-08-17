<!-- FOOTER SECTION -->
@if(!in_array(Request::route()->getName(),['home','category','tournament','match','login','register','register.sponsor','user.check','password.request']))

    <!-- FOOTER SECTION -->
    <footer class="footer-section" id="subscribe">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-box">
                            <a class="navbar-brand" href="javascript:void(0)">
                                <img class="img-fluid"
                                     src="{{ getFile(config('location.logoIcon.path') . 'logo1.png') }}"
                                     alt="..."/> </a>
                            <p>
                                @if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0])
                                    @lang(strip_tags(@$contact->description->footer_short_details))
                                @endif
                            </p>
                            @if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0])
                                <ul>
                                    <li>
                                        <i class="fas fa-phone-alt"></i>
                                        <span>@lang(@$contact->description->phone)</span>
                                    </li>
                                    <li>
                                        <i class="far fa-envelope"></i>
                                        <span>@lang(@$contact->description->email)</span>
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>@lang(@$contact->description->email)</span>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 ps-lg-5">
                        <div class="footer-box">
                            <h5>@lang('Quick Links')</h5>
                            <ul>
                                <li>
                                    <a href="{{route('home')}}">@lang('Home')</a>
                                </li>
                                <li>
                                    <a href="{{route('about')}}">@lang('About')</a>
                                </li>
                                <li>
                                    <a href="{{route('blog')}}">@lang('Blog')</a>
                                </li>
                                <li>
                                    <a href="{{route('contact')}}">@lang('Contact')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @isset($contentDetails['support'])
                        <div class="col-md-6 col-lg-3 ps-lg-5">
                            <div class="footer-box">
                                <h5>{{trans('OUR Services')}}</h5>
                                <ul>
                                    @foreach($contentDetails['support'] as $data)
                                        <li>
                                            <a href="{{route('getLink', [slug($data->description->title), $data->content_id])}}"> @lang($data->description->title)</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endisset
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-box">
                            <h5>@lang('subscribe newsletter')</h5>
                            <form action="{{ route('subscribe') }}" method="post" class="mb-3">
                                @csrf
                                <div class="input-group mb-3">
                                    <input
                                        type="email"
                                        name="email"
                                        autocomplete="off"
                                        class="form-control"
                                        placeholder="{{trans('Enter Email')}}"
                                        aria-label="Subscribe Newsletter"
                                        aria-describedby="basic-addon"/>
                                    <button type="submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </form>
                            @if(isset($contentDetails['social']))
                                <div class="social-links">
                                    @foreach($contentDetails['social'] as $data)
                                        <a href="{{@$data->content->contentMedia->description->link}}">
                                            <i class="{{@$data->content->contentMedia->description->icon}}"></i>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="copyright">
                                @lang('Copyright') &copy; {{date('Y')}} @lang($basic->site_title) @lang('All Rights Reserved')
                            </p>
                        </div>
                        <div class="col-md-6 language">
                            @forelse($languages as $lang)
                                <a href="{{route('language',$lang->short_name)}}">{{trans($lang->name)}}</a>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <style>
        .footer-section {
            background: url({{getFile(config('location.logo.path').'footer.jpg')}});
            background-size: cover;
            background-position: center top;
        }
    </style>

@endif


