@if(0 < count($pending))
<div class="col-lg-3 col-xl-2 border-right">
    <div class="scrollable position-relative scroll-height">
        <ul class="mailbox list-style-none">
            <li>
                <div class="message-center">
                    @foreach($pending as $item)
                        <a href="{{ route('admin.ticket.view', $item->id) }}"
                           class="message-item d-flex align-items-center border-bottom px-3 py-2 {{($ticket->ticket == $item->ticket) ? 'sideNavTicket' : ''}}">
                            <div class="user-img">
                                <img src="{{getFile(config('location.user.path').optional($item->user)->image) }}"
                                     alt="user" class="img-fluid rounded-circle width-40p"> <span
                                    class="profile-status online float-right"></span>
                            </div>
                            <div class="w-75 d-inline-block v-middle pl-2">
                                <h6 class="message-title mb-0 mt-1">{{trans($item->name)}}</h6>
                                <span class="font-12 text-nowrap d-block text-muted text-truncate">
                                    @lang(@$item->lastMessage)
                                </span>
                                <span class="font-12 text-nowrap d-block text-muted">{{dateTime($item->last_reply)}}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</div>
@endif
