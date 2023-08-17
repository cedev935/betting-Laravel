<meta name="description" content="{{ config('seo.meta_description')}}">
<meta name="keywords" content="{{ config('seo.meta_keywords') }}">
<link rel="shortcut icon" href="{{getFile(config('location.logoIcon.path').'favicon.png') }}" type="image/x-icon">
{{--<!-- Apple Stuff -->--}}
<link rel="apple-touch-icon" href="{{getFile(config('location.logoIcon.path').'logo.png') }}">
<title>@lang($basic->site_title) | @yield('title')</title>
<link rel="icon" type="image/png" sizes="16x16" href="{{ getFile(config('location.logoIcon.path').'favicon.png')}}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="@lang($basic->site_title) | @yield('title')">
{{--<!-- Google / Search Engine Tags -->--}}
<meta itemprop="name" content="@lang($basic->site_title) | @yield('title')">
<meta itemprop="description" content="{{ config('seo.meta_description')}}">
<meta itemprop="image" content="{{ getFile(config('location.logoIcon.path'). config('seo.meta_image'),'600x315') }}">
{{--<!-- Facebook Meta Tags -->--}}
<meta property="og:type" content="website">
<meta property="og:title" content="{{ config('seo.social_title') }}">
<meta property="og:description" content="{{  config('seo.social_description') }}">
<meta property="og:image" content="{{ getFile(config('location.logoIcon.path') . config('seo.meta_image')) }}"/>
<meta property="og:image:type" content="image/{{ pathinfo(getFile(config('location.logoIcon.path') . config('seo.meta_image')))['extension'] }}"/>
<meta property="og:url" content="{{ url()->current() }}">
{{--<!-- Twitter Meta Tags -->--}}
<meta name="twitter:card" content="summary_large_image">
