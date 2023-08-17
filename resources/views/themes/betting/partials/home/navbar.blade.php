<!-- categories -->
<div class="categories" id="categories">
    <a href="{{route('home')}}" @if(Request::routeIs('home')) class="active" @endif>
        <i class="far fa-globe-americas"></i> <span>{{trans('All Sports')}}</span>
    </a>

    @php
        $segments = request()->segments();
        $last  = end($segments);
    @endphp

    @forelse($gameCategories as $gameCategory)

    <a href="{{route('category',[slug($gameCategory->name), $gameCategory->id])}}"
       class="{{( Request::routeIs('category') && $last == $gameCategory->id) ? 'active' : '' }}">
        @php echo $gameCategory->icon @endphp <span>{{$gameCategory->name}}</span>
    </a>
    @empty
    @endforelse
</div>
