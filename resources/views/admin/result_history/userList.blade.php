@extends('admin.layouts.app')
@section('title')
    {{@$matchName}} <small>({{$question->name}})</small>
@endsection

@section('content')
    <div class="card card-primary m-0 m-md-4  m-md-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th>@lang('SL No.')</th>
                        <th>@lang('User')</th>
                        <th>@lang('Question')</th>
                        <th>@lang('Option')</th>
                        <th>@lang('Result')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($betInvestLogs as $key => $item)
                        <tr>
                            <td data-label="@lang('SL No.')">{{++$key}}</td>
                            <td data-label="@lang('User')">
                                <a href="{{route('admin.user-edit',[optional($item->user)->id])}}">
                                    <div class="d-lg-flex d-block align-items-center ">
                                        <div class="mr-3"><img
                                                src="{{getFile(config('location.user.path').optional($item->user)->image) }}"
                                                alt="user" class="rounded-circle" width="45"
                                                height="45"></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">@lang(optional($item->user)->username)</h5>
                                            <span class="text-muted font-14">{{optional($item->user)->email}}</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td data-label="@lang('Question')">@lang(optional($item->gameQuestion)->name)</td>
                            <td data-label="@lang('Option')">@lang(optional($item->gameOption)->option_name)</td>
                            <td data-label="@lang('Result')">
                                @if($item->gameQuestion->winOption)
                                    <span class="badge badge-success">{{@$item->gameQuestion->winOption->option_name}}</span>
                                @else
                                    <span class="badge badge-warning">@lang('N/A')</span>
                                @endif
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                {{$betInvestLogs->appends(@$search)->links('partials.pagination')}}
            </div>
        </div>
    </div>
@endsection
