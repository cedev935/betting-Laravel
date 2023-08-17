<!-- navbar -->
<nav class="navbar navbar-expand-md fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{getFile(config('location.logoIcon.path').'logo.png')}}" alt="homepage">
        </a>
        <button
            class="navbar-toggler p-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{menuActive('home')}}" href="{{route('home')}}">@lang('Home') </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{menuActive('about')}}" href="{{route('about')}}">@lang('About')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{menuActive('faq')}}" href="{{route('faq')}}">@lang('FAQ')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{menuActive('blog')}}" href="{{route('blog')}}">@lang('Blog')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{menuActive('contact')}}" href="{{route('contact')}}">@lang('Contact')</a>
                </li>
            </ul>
        </div>
        <div class="navbar-text">
            <button onclick="darkMode()" class="btn-custom light night-mode">
                <i class="fal fa-moon"></i>
            </button>


            @auth
                <div class="dropdown user-dropdown d-inline-block">
                    <button class="dropdown-toggle">
                        <i class="fal fa-user"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{menuActive('user.home')}}" href="{{route('user.home')}}">
                                <i class="fa fa-home"></i>
                                @lang('Dashboard')
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{menuActive('user.addFund')}}" href="{{route('user.addFund')}}">
                                <i class="fal fa-money-bill"></i>
                                @lang('Make a deposit')
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item {{menuActive('user.payout.money')}}"
                               href="{{route('user.payout.money')}}">
                                <i class="fas fa-envelope-open-dollar"></i>
                                @lang('withdraw funds')
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{menuActive('user.referral')}}" href="{{route('user.referral')}}">
                                <i class="fal fa-user-friends"></i>
                                @lang('invite friends')
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{menuActive('user.profile')}}" href="{{route('user.profile')}}">
                                <i class="fal fa-user"></i>
                                @lang('personal profile')
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{menuActive('user.betHistory')}}"
                               href="{{route('user.betHistory')}}">
                                <i class="fal fa-history"></i>
                                @lang('bet history')
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                @lang('Sign Out')
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

        <!-- notification panel -->
            <div class="notification-panel" id="pushNotificationArea">
                @auth
                    @if(config('basic.push_notification') == 1)
                    <button class="dropdown-toggle" v-cloak>
                        <i class="fal fa-bell"></i>
                        <span v-if="items.length > 0" class="count">@{{ items.length }}</span>
                    </button>
                    <ul class="notification-dropdown">
                        <div class="dropdown-box">
                            <li>
                                <a v-for="(item, index) in items"
                                   @click.prevent="readAt(item.id, item.description.link)"
                                   class="dropdown-item" href="javascript:void(0)">
                                    <i class="fal fa-bell"></i>
                                    <div class="text">
                                        <p v-cloak>@{{ item.formatted_date }}</p>
                                        <span v-cloak v-html="item.description.text"></span>
                                    </div>
                                </a>
                            </li>
                        </div>
                        <div class="clear-all fixed-bottom">
                            <a v-if="items.length > 0" @click.prevent="readAll"
                               href="javascript:void(0)">@lang('Clear all')</a>
                            <a v-if="items.length == 0" href="javascript:void(0)">@lang('You have no notifications')</a>
                        </div>
                    </ul>
                    @endif
                @endauth

                @guest
                <!-- login register button -->
                    <button
                        class="btn-custom"
                        data-bs-toggle="modal"
                        data-bs-target="#registerModal">
                        @lang('Join')
                    </button>
                    <button
                        class="btn-custom"
                        data-bs-toggle="modal"
                        data-bs-target="#loginModal">
                        @lang('Login')
                    </button>
                @endguest
            </div>
        </div>
    </div>
</nav>

@if(in_array(Request::route()->getName(),['home','category','tournament','match']))

    <div class="bottom-bar fixed-bottom text-center">
        <a href="{{route('home')}}" class="text-dark">
            <i class="fa fa-home"></i>
            @lang('Home')
        </a>
        <a href="javascript:void(0)" class="text-dark" onclick="toggleSidebar('leftbar')">
            <i class="far fa-globe-americas"></i>
            @lang('Sports')
        </a>

        <a href="javascript:void(0)" class="text-dark" onclick="toggleSidebar('rightbar')">
            <i class="fal fa-ticket-alt"></i>
            @lang('Bet Slip')
        </a>

        @guest
            <a href="{{route('login')}}" class="text-dark">
                <i class="fa fa-sign-in"></i>
                @lang('Login')
            </a>
        @endguest

        @auth
            <a href="{{route('user.home')}}" class="text-dark">
                <i class="fal fa-user"></i>
                @lang('Dashboard')
            </a>
        @endauth

    </div>
@endif
