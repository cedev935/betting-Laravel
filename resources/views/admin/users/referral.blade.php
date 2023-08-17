@extends('admin.layouts.app')
@section('title',trans('Referrals').': '.$user->username )
@section('content')



<div id="feature">

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0">
        <div class="card-body">
            @if(0 < count($referrals))
                <div class="d-flex align-items-start">
                    <div class="nav nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach($referrals as $key => $referral)
                            <a class="nav-link @if($key == '1')  active  @endif " id="v-pills-{{$key}}-tab" data-toggle="pill" href="#v-pills-{{$key}}"  role="tab" aria-controls="v-pills-{{$key}}" aria-selected="true">@lang('Level') {{$key}}</a>
                        @endforeach
                    </div>

                    <div class="tab-content" id="v-pills-tabContent">

                        @foreach($referrals as $key => $referral)
                            <div class="tab-pane fade @if($key == '1') show active  @endif " id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab">
                                @if( 0 < count($referral))
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">@lang('Username')</th>
                                                <th scope="col">@lang('Email')</th>
                                                <th scope="col">@lang('Phone Number')</th>
                                                <th scope="col">@lang('Joined At')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($referral as $user)
                                                <tr>

                                                    <td data-label="@lang('Username')">
                                                        <a href="{{route('admin.user-edit',$user->id)}}" target="_blank">
                                                            @lang($user->username)
                                                        </a>
                                                    </td>
                                                    <td data-label="@lang('Email')">{{$user->email}}</td>
                                                    <td data-label="@lang('Phone Number')">
                                                        {{$user->mobile}}
                                                    </td>
                                                    <td data-label="@lang('Joined At')">
                                                        {{dateTime($user->created_at)}}
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif
        </div>
    </div>


</div>
@endsection
