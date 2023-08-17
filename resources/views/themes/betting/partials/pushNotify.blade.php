<li class="ml-20 push-notification " >
    <div class="dropdown account-dropdown">
        <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="javascript:void(0)">
            <span class="rotate-icon">
                <i class="icofont-alarm"></i>
            </span>
            <span class="badge"  v-cloak>@{{items.length}}</span>
        </a>
        <div class="xs-dropdown-menu dropdown-menu dropdown-right">
            <div class="dropdown-content scrolling-iv">
                <a v-for="(item, index) in items" @click.prevent="readAt(item.id, item.description.link)"  href="javascript:void(0)" class="dropdown-item">
                    <div class="media align-items-center">
                        <div class="media-icon">
                            <i :class="item.description.icon" ></i>
                        </div>
                        <div class="media-body ml-15">
                            <h6 class="font-weight-bold" v-cloak v-html="item.description.text"></h6>
                            <p v-cloak>@{{ item.formatted_date }}</p>
                        </div>
                    </div>
                </a>

            </div>
            <div class="pt-15 pr-15 pb-15 pl-15 d-flex justify-content-center ">
                <a class="btn-viewnotification" href="javascript:void(0)" v-if="items.length == 0">@lang('You have no notifications')</a>
                <button class="btn-clear " type="button" v-if="items.length > 0" @click.prevent="readAll">@lang('Clear')</button>
            </div>
        </div>
    </div>
</li>


