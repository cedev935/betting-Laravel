<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                @if(adminAccessRoute(config('role.dashboard.access.view')))
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.dashboard')}}" aria-expanded="false">
                            <i data-feather="home" class="feather-icon text-primary"></i>
                            <span class="hide-menu">@lang('Dashboard')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.manage_staff.access.view')))
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.staff')}}" aria-expanded="false">
                            <i data-feather="users" class="feather-icon text-success"></i>
                            <span class="hide-menu">@lang('Role Permission')</span>
                        </a>
                    </li>
                @endif


                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('admin.identify-form')}}" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon text-warning"></i>
                        <span class="hide-menu">@lang('KYC / Identity Form')</span>
                    </a>
                </li>


                @if(adminAccessRoute(config('role.manage_game.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Module')</span></li>

                    <li class="sidebar-item {{menuActive(['admin.listCategory*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.listCategory') }}" aria-expanded="false">
                            <i class="fas fa-tag text-success"></i>
                            <span class="hide-menu">@lang('Game Category')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['admin.listTournament*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.listTournament') }}" aria-expanded="false">
                            <i class="fas fa-gamepad text-primary"></i>
                            <span class="hide-menu">@lang('Tournament')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['admin.listTeam*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.listTeam') }}" aria-expanded="false">
                            <i class="fa fa-users text-dark"></i>
                            <span class="hide-menu">@lang('Team')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['admin.*Match*','admin.addQuestion'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.listMatch') }}" aria-expanded="false">
                            <i class="fa fa-flag text-info"></i>
                            <span class="hide-menu">@lang('Match')</span>
                        </a>
                    </li>

                @endif
                @if(adminAccessRoute(config('role.manage_result.access.view')))

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage Result')</span></li>
                    <li class="sidebar-item {{menuActive(['admin.resultList.pending'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.resultList.pending') }}" aria-expanded="false">
                            <i class="fa fa-spinner text-warning"></i>
                            <span class="hide-menu">@lang('Pending Result')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['admin.resultList.complete'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.resultList.complete') }}" aria-expanded="false">
                            <i class="fas fa-check-circle text-danger"></i>
                            <span class="hide-menu">@lang('Close Result')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.commission_setting.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Referral')</span></li>
                    <li class="sidebar-item {{menuActive(['admin.referral-commission'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.referral-commission') }}" aria-expanded="false">
                            <i class="fas fa-users text-success"></i>
                            <span class="hide-menu">@lang('Referral Commission')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.all_transaction.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('All Transaction ')</span></li>

                    <li class="sidebar-item {{menuActive(['admin.transaction*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.transaction') }}" aria-expanded="false">
                            <i class="fas fa-exchange-alt text-primary"></i>
                            <span class="hide-menu">@lang('Transaction')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['admin.commissions*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.commissions') }}" aria-expanded="false">
                            <i class="fas fa-money-bill-alt text-danger"></i>
                            <span class="hide-menu">@lang('Commission')</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{menuActive(['admin.historyBet*','admin.searchBet'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.historyBet') }}" aria-expanded="false">
                            <i class="fas fa-tag text-warning"></i>
                            <span class="hide-menu">@lang('Bet History')</span>
                        </a>
                    </li>
                @endif



                @if(adminAccessRoute(config('role.user_management.access.view')))
                    {{--Manage User--}}
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Manage User')</span></li>

                    <li class="sidebar-item {{menuActive(['admin.users','admin.users.search','admin.user-edit*','admin.send-email*','admin.user*'],3)}}">
                        <a class="sidebar-link" href="{{ route('admin.users') }}" aria-expanded="false">
                            <i class="fas fa-users text-success"></i>
                            <span class="hide-menu">@lang('All User')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.kyc.users.pending') }}"
                           aria-expanded="false">
                            <i class="fas fa-spinner text-danger"></i>
                            <span class="hide-menu">@lang('Pending KYC')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.kyc.users') }}"
                           aria-expanded="false">
                            <i class="fas fa-file-invoice text-info"></i>
                            <span class="hide-menu">@lang('KYC Log')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.email-send') }}"
                           aria-expanded="false">
                            <i class="fas fa-envelope-open text-dark"></i>
                            <span class="hide-menu">@lang('Send Email')</span>
                        </a>
                    </li>

                @endif


                @if(adminAccessRoute(config('role.payment_gateway.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Payment Settings')</span></li>
                    <li class="sidebar-item {{menuActive(['admin.payment.methods','admin.edit.payment.methods'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payment.methods')}}"
                           aria-expanded="false">
                            <i class="fas fa-credit-card text-success"></i>
                            <span class="hide-menu">@lang('Payment Methods')</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{menuActive(['admin.deposit.manual.index','admin.deposit.manual.create','admin.deposit.manual.edit'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.deposit.manual.index')}}"
                           aria-expanded="false">
                            <i class="fa fa-university text-info"></i>
                            <span class="hide-menu">@lang('Manual Gateway')</span>
                        </a>
                    </li>
                @endif
                @if(adminAccessRoute(config('role.payment_log.access.view')))
                    <li class="sidebar-item {{menuActive(['admin.payment.pending'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payment.pending')}}" aria-expanded="false">
                            <i class="fas fa-spinner text-warning"></i>
                            <span class="hide-menu">@lang('Deposit Request')</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{menuActive(['admin.payment.log','admin.payment.search'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payment.log')}}" aria-expanded="false">
                            <i class="fas fa-history text-primary"></i>
                            <span class="hide-menu">@lang('Payment Log')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.payout_manage.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Payout Settings')</span></li>
                    <li class="sidebar-item {{menuActive(['admin.payout-method*'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payout-method')}}"
                           aria-expanded="false">
                            <i class="fas fa-credit-card text-success"></i>
                            <span class="hide-menu">@lang('Payout Methods')</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{menuActive(['admin.payout-request'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payout-request')}}" aria-expanded="false">
                            <i class="fas fa-hand-holding-usd text-warning"></i>
                            <span class="hide-menu">@lang('Payout Request')</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{menuActive(['admin.payout-log*'],3)}}">
                        <a class="sidebar-link" href="{{route('admin.payout-log')}}" aria-expanded="false">
                            <i class="fas fa-history text-primary"></i>
                            <span class="hide-menu">@lang('Payout Log')</span>
                        </a>
                    </li>
                @endif

                @if(adminAccessRoute(config('role.support_ticket.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Support Tickets')</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.ticket')}}" aria-expanded="false">
                            <i class="fas fa-ticket-alt text-primary"></i>
                            <span class="hide-menu">@lang('All Tickets')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.ticket',['open']) }}"
                           aria-expanded="false">
                            <i class="fas fa-spinner text-success"></i>
                            <span class="hide-menu">@lang('Open Ticket')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.ticket',['closed']) }}"
                           aria-expanded="false">
                            <i class="fas fa-times-circle text-danger"></i>
                            <span class="hide-menu">@lang('Closed Ticket')</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.ticket',['answered']) }}"
                           aria-expanded="false">
                            <i class="fas fa-reply text-dark"></i>
                            <span class="hide-menu">@lang('Answered Ticket')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(config('role.subscriber.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Subscriber')</span></li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.subscriber.index')}}" aria-expanded="false">
                            <i class="fas fa-envelope-open text-success"></i>
                            <span class="hide-menu">@lang('Subscriber List')</span>
                        </a>
                    </li>
                @endif


                @if(adminAccessRoute(array_merge(config('role.website_controls.access.view'), config('role.language_settings.access.view'))))

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Controls')</span></li>
                    @if(adminAccessRoute(config('role.website_controls.access.view')))
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.basic-controls')}}" aria-expanded="false">
                                <i class="fas fa-cogs text-primary"></i>
                                <span class="hide-menu">@lang('Basic Controls')</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.currency.exchange.api.config')}}" aria-expanded="false">
                                <i class="fas fa-exchange-alt text-dark"></i>
                                <span class="hide-menu">@lang('Exchange Api')</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{route('admin.plugin.config')}}" aria-expanded="false">
                                <i class="fas fa-cog text-warning"></i>
                                <span class="hide-menu">@lang('Plugin Controls')</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-envelope text-success"></i>
                                <span class="hide-menu">@lang('Email Settings')</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{route('admin.email-controls')}}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Email Controls')</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('admin.email-template.show')}}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Email Template') </span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-mobile-alt text-dark"></i>
                                <span class="hide-menu">@lang('SMS Settings')</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.sms.config') }}" class="sidebar-link">
                                        <span class="hide-menu">@lang('SMS Controls')</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="{{ route('admin.sms-template') }}" class="sidebar-link">
                                        <span class="hide-menu">@lang('SMS Template')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-bell text-danger"></i>
                                <span class="hide-menu">@lang('Push Notification')</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level base-level-line">
                                <li class="sidebar-item">
                                    <a href="{{route('admin.notify-config')}}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Configuration')</span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="{{ route('admin.notify-template.show') }}" class="sidebar-link">
                                        <span class="hide-menu">@lang('Template')</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(adminAccessRoute(config('role.language_settings.access.view')))
                        <li class="sidebar-item {{menuActive(['admin.language.create','admin.language.edit*','admin.language.keywordEdit*'],3)}}">
                            <a class="sidebar-link" href="{{  route('admin.language.index') }}"
                               aria-expanded="false">
                                <i class="fas fa-language text-primary"></i>
                                <span class="hide-menu">@lang('Manage Language')</span>
                            </a>
                        </li>
                    @endif

                @endif


                @if(adminAccessRoute(config('role.theme_settings.access.view')))
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">@lang('Theme Settings')</span></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.logo-seo')}}" aria-expanded="false">
                            <i class="fas fa-image text-success"></i><span
                                class="hide-menu">@lang('Manage Logo & SEO')</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.breadcrumb')}}" aria-expanded="false">
                            <i class="fas fa-file-image text-primary"></i><span
                                class="hide-menu">@lang('Manage Breadcrumb')</span>
                        </a>
                    </li>


                    <li class="sidebar-item {{menuActive(['admin.template.show*'],3)}}">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-clipboard-list text-danger"></i>
                            <span class="hide-menu">@lang('Manage Content')</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line {{menuActive(['admin.template.show*'],1)}}">

                            @foreach(array_diff(array_keys(config('templates')),['message','template_media']) as $name)
                                <li class="sidebar-item {{ menuActive(['admin.template.show'.$name]) }}">
                                    <a class="sidebar-link {{ menuActive(['admin.template.show'.$name]) }}"
                                       href="{{ route('admin.template.show',$name) }}">
                                        <span class="hide-menu">@lang(ucfirst(kebab2Title($name)))</span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    </li>


                    @php
                        $segments = request()->segments();
                        $last  = end($segments);
                    @endphp
                    <li class="sidebar-item {{menuActive(['admin.content.create','admin.content.show*'],3)}}">
                        <a class="sidebar-link has-arrow {{Request::routeIs('admin.content.show',$last) ? 'active' : '' }}"
                           href="javascript:void(0)" aria-expanded="false">
                            <i class="fas fa-clipboard-list text-warning"></i>
                            <span class="hide-menu">@lang('Content Settings')</span>
                        </a>
                        <ul aria-expanded="false"
                            class="collapse first-level base-level-line {{menuActive(['admin.content.create','admin.content.show*'],1)}}">
                            @foreach(array_diff(array_keys(config('contents')),['message','content_media']) as $name)
                                <li class="sidebar-item {{($last == $name) ? 'active' : '' }} ">
                                    <a class="sidebar-link {{($last == $name) ? 'active' : '' }}"
                                       href="{{ route('admin.content.index',$name) }}">
                                        <span class="hide-menu">@lang(ucfirst(kebab2Title($name)))</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

                <li class="list-divider"></li>

                    <li class="nav-small-cap"><span class="hide-menu">@lang('Version 5.1')</span></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
