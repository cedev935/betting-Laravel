@extends($theme.'layouts.user')
@section('title',trans($title))
@section('content')

    <div class="row justify-content-between ">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="title text-start m-0">@lang('Referral link')</h5>
                </div>
                <div class="card-body">
                    <p>
                        @lang('Automatically top up your account balance by sharing your referral link, Earn a percentage of whatever plan your referred user buys.')</p>
                    <div>
                        <form>
                            <div class="form-group">
                                <div class="input-group input-box">
                                    <input type="text"
                                           value="{{route('register.sponsor',[Auth::user()->username])}}"
                                           class="form-control" id="sponsorURL" readonly="">
                                    <div class="input-group-append">
                                            <span class="input-group-text form-control copytext" id="copyBoard"
                                                  onclick="copyFunction()">
                                                    <i class="fa fa-copy"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if(0 < count($referrals))
                <div class="card ">
                    <div class="card-header">
                        <h5 class="title text-start m-0">@lang('Referral Members')</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-start flex-column flex-wrap" id="ref-label">
                            <div class="nav w-sm-100 nav-pills mx-2 d-flex flex-wrap" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                @foreach($referrals as $key => $referral)
                                    <a class=" nav-link @if($key == '1')   active  @endif "
                                       id="v-pills-{{$key}}-tab" href="javascript:void(0)" data-bs-toggle="pill"
                                       data-bs-target="#v-pills-{{$key}}" role="tab"
                                       aria-controls="v-pills-{{$key}}"
                                       aria-selected="true">@lang('Level') {{$key}}</a>
                                @endforeach
                            </div>
                            <div class="tab-content w-sm-100" id="v-pills-tabContent">
                                @foreach($referrals as $key => $referral)
                                    <div class="tab-pane fade @if($key == '1') show active  @endif "
                                         id="v-pills-{{$key}}" role="tabpanel"
                                         aria-labelledby="v-pills-{{$key}}-tab">
                                        @if( 0 < count($referral))
                                            <div class="table-parent table-responsive m-0 mt-4">
                                                <table class="table table-striped service-table" >
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">@lang('Username')</th>
                                                        <th scope="col">@lang('Email')</th>
                                                        <th scope="col">@lang('Mobile')</th>
                                                        <th scope="col">@lang('Joined At')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($referral as $user)
                                                        <tr>

                                                            <td data-label="@lang('Username')">
                                                                @lang($user->username)
                                                            </td>
                                                            <td data-label="@lang('Email')"
                                                                class="">{{$user->email}}</td>
                                                            <td data-label="@lang('Mobile')">
                                                                {{$user->phone}}
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
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@push('script')
    <script>
        "use strict";

        function copyFunction() {
            var copyText = document.getElementById("sponsorURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush
