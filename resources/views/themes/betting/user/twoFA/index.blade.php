@extends($theme.'layouts.user')
@section('title',__('2 Step Security'))

@section('content')
    <div class="row">
        @if(auth()->user()->two_fa)
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title text-start m-0">@lang('Two Factor Authenticator')</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <div class="input-group input-box">
                                    <input type="text" value="{{$previousCode}}"
                                           class="form-control" id="referralURL"
                                           readonly>
                                    <div class="input-group-append">
                                            <span class="input-group-text copytext" id="copyBoard"
                                                  onclick="copyFunction()">
                                                <i class="fa fa-copy"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mx-auto text-center mt-3">
                                <img class="mx-auto" src="{{$previousQR}}">
                            </div>

                            <div class="form-group mx-auto text-center">
                                <a href="javascript:void(0)" class="btn-custom line-h22 w-100 mt-4"
                                   data-bs-toggle="modal"
                                   data-bs-target="#disableModal">@lang('Disable Two Factor Authenticator')</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card ">
                    <div class="card-header text-center">
                        <h5 class="title text-start m-0">@lang('Two Factor Authenticator')</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group input-box">
                                <div class="input-group ">
                                    <input type="text" value="{{$secret}}"
                                           class="form-control" id="referralURL"
                                           readonly>
                                    <div class="input-group-append">
                                                <span class="input-group-text copytext" id="copyBoard"
                                                      onclick="copyFunction()">
                                                    <i class="fa fa-copy"></i>
                                                </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="form-group mx-auto text-center mt-3">
                            <img class="mx-auto" src="{{$qrCodeUrl}}">
                        </div>

                        <div class="form-group mx-auto text-center">
                            <a href="javascript:void(0)" class="btn-custom line-h22 w-100 mt-4"
                               data-bs-toggle="modal"
                               data-bs-target="#enableModal">@lang('Enable Two Factor Authenticator')</a>
                        </div>
                    </div>

                </div>
            </div>

        @endif


        <div class="col-lg-6 col-md-6 mb-3">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="title text-start m-0">@lang('Google Authenticator')</h5>
                </div>
                <div class="card-body">
                    <h6 class="text-uppercase my-3">@lang('Use Google Authenticator to Scan the QR code  or use the code')</h6>
                    <p >@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                    <a class="btn-custom line-h22 mt-3"
                       href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                       target="_blank">@lang('DOWNLOAD APP')</a>
                </div>
            </div>
        </div>
    </div>

    <!--Enable Modal -->
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-custom-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Verify Your OTP')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>
                <form action="{{route('user.twoStepEnable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group input-box">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code"
                                   placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn-custom">@lang('Verify')</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-custom-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Verify Your OTP to Disable')</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twoStepDisable')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group input-box">
                            <input type="text" class="form-control bg-transparent" name="code"
                                   placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn-custom">@lang('Verify')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function copyFunction() {
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            Notiflix.Notify.Success(`Copied: ${copyText.value}`);
        }
    </script>
@endpush

