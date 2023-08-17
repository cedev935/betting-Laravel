<!-- Login Modal -->
<div
    class="modal fade"
    id="loginModal"
    tabindex="-1"
    aria-labelledby="loginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>@lang('Login here')</h4>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="login-form" id="login-form" action="{{route('loginModal')}}" method="post">
                    @csrf
                    <div class="row g-4">
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="username"
                                class="form-control"
                                placeholder="@lang('Username')"/>
                            <span class="text-danger emailError"></span>
                            <span class="text-danger usernameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="password"
                                name="password"
                                autocomplete="off"
                                class="form-control"
                                placeholder="@lang('Password')"
                            />
                            <span class="text-danger passwordError"></span>
                        </div>
                        <div class="col-12">
                            <div class="links">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        autocomplete="off"
                                        value=""
                                        id="flexCheckDefault"
                                        name="remember" {{ old('remember') ? 'checked' : '' }}
                                    />
                                    <label
                                        class="form-check-label"
                                        for="flexCheckDefault">
                                        @lang('Remember Me')
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-custom w-100">@lang('sign in')</button>
                    <div class="bottom">
                        @lang("Don't have an account?")

                        <a href="{{route('register')}}">@lang('Create account')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Register Modal -->
<div
    class="modal fade"
    id="registerModal"
    tabindex="-1"
    aria-labelledby="registerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>@lang('Join us')</h4>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="login-form" id="signup-form" action="{{route('register')}}" method="post">
                    @csrf
                    <div class="row g-4">
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="firstname"
                                value="{{old('firstname')}}"
                                class="form-control"
                                placeholder="@lang('First Name')"/>
                            <span class="text-danger firstnameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="lastname" value="{{old('lastname')}}"
                                class="form-control"
                                placeholder="@lang('Last name')"/>
                            <span class="text-danger lastnameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="username" value="{{old('username')}}"
                                class="form-control"
                                placeholder="@lang('Username')"/>
                            <span class="text-danger usernameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="email"
                                autocomplete="off"
                                name="email" value="{{old('email')}}"
                                class="form-control"
                                placeholder="@lang('Email address')"/>
                            <span class="text-danger emailError"></span>
                        </div>
                        <div class="input-box col-6">
                            @php
                                $country_code = (string) @getIpInfo()['code'] ?: null;
                                $myCollection = collect(config('country'))->map(function($row) {
                                    return collect($row);
                                });
                                $countries = $myCollection->sortBy('code');
                            @endphp
                            <select
                                class="form-select form-control country_code dialCode-change" name="phone_code"
                                aria-label="Default select example" id="basic-addon1">
                                <option selected="" disabled>@lang('Select Code')</option>
                                @foreach(config('country') as $value)
                                    <option value="{{$value['phone_code']}}"
                                            data-name="{{$value['name']}}"
                                            data-code="{{$value['code']}}"
                                        {{$country_code == $value['code'] ? 'selected' : ''}}> {{$value['name']}}
                                        ({{$value['phone_code']}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-box col-6">
                            <input
                                type="text"
                                autocomplete="off"
                                name="phone" value="{{old('phone')}}"
                                class="form-control dialcode-set"
                                placeholder="@lang('Phone Number')"/>
                            <span class="text-danger phoneError"></span>
                            <input  autocomplete="off" type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark">
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="password"
                                name="password" value="{{old('password')}}"
                                class="form-control"
                                placeholder="@lang('Password')"/>
                            <span class="text-danger passwordError"></span>
                        </div>
                        <div class="input-box col-12 mb-3">
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="@lang('Confirm Password')"/>
                        </div>
                    </div>

                    <button type="submit" class="btn-custom w-100 login-signup-auth-btn">@lang('sign up')</button>
                    <div class="bottom">
                        @lang('Already have an account?')

                        <a href="{{route('login')}}">@lang('Login here')</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        "use strict";
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                $('.dialcode-set').val(currency);
            }

        });
    </script>
@endpush
