@php
    $segments = request()->segments();
    $last  = end($segments);
@endphp

<ul class="main">
    <li>
        <a  @if(Request::routeIs('home')) class="active" @endif
            href="{{route('home')}}">
            <i class="far fa-globe-americas"></i> <span>{{trans('All Sports')}}</span>
        </a>
    </li>
    @forelse($gameCategories as $gameCategory)
        <li>
            <a
                class="dropdown-toggle "
                data-bs-toggle="collapse"
                href="#collapse{{$gameCategory->id}}"
                role="button"
                aria-expanded="true"
                aria-controls="collapseExample">
                {!! $gameCategory->icon!!}{{$gameCategory->name}}
                <span class="count"><span class="font-italic">({{$gameCategory->game_active_match_count}})</span></span>
            </a>
            <!-- dropdown item -->

            <div class="collapse {{($loop->index == 0) ? 'show' :''}}" id="collapse{{$gameCategory->id}}">
                <ul class="">
                    @forelse($gameCategory->activeTournament as $tItem)
                        <li>
                            <a href="{{route('tournament',[slug($tItem->name) , $tItem->id ])}}" class="sidebar-link {{( Request::routeIs('tournament') && $last == $tItem->id) ? 'active' : '' }}">
                                <i class="far fa-hand-point-right"></i> {{$tItem->name}}</a>
                        </li>
                    @empty
                    @endforelse
                </ul>
            </div>
        </li>
    @empty
    @endforelse
</ul>
