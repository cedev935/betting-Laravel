<!-- slider -->
@if(isset($contentDetails['slider']))
    <div class="skitter-large-box">
        <div class="skitter skitter-large with-dots">
            <ul>
                @foreach($contentDetails['slider'] as $data)
                    <li>
                        <a href="{{optional($data->content->contentMedia->description)->button_link}}">
                            <img
                                src="{{getFile(config('location.content.path').@$data->content->contentMedia->description->image)}}"
                                class="downBars"
                            />
                        </a>
                        <div class="label_text">
                            <h2>{{optional($data->description)->name}}</h2>
                            <p class="mb-4">
                                {{optional($data->description)->short_description}}
                            </p>
                            <a href="{{optional($data->content->contentMedia->description)->button_link}}"><button class="btn-custom"> {{optional($data->description)->button_name}}</button></a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
