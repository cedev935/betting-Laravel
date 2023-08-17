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
                <h4><?php echo app('translator')->get('Login here'); ?></h4>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="login-form" id="login-form" action="<?php echo e(route('loginModal')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row g-4">
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="username"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Username'); ?>"/>
                            <span class="text-danger emailError"></span>
                            <span class="text-danger usernameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="password"
                                name="password"
                                autocomplete="off"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Password'); ?>"
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
                                        name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>

                                    />
                                    <label
                                        class="form-check-label"
                                        for="flexCheckDefault">
                                        <?php echo app('translator')->get('Remember Me'); ?>
                                    </label>
                                </div>
                                <a href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->get('Forgot password?'); ?></a>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-custom w-100"><?php echo app('translator')->get('sign in'); ?></button>
                    <div class="bottom">
                        <?php echo app('translator')->get("Don't have an account?"); ?>

                        <a href="<?php echo e(route('register')); ?>"><?php echo app('translator')->get('Create account'); ?></a>
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
                <h4><?php echo app('translator')->get('Join us'); ?></h4>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="login-form" id="signup-form" action="<?php echo e(route('register')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row g-4">
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="firstname"
                                value="<?php echo e(old('firstname')); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('First Name'); ?>"/>
                            <span class="text-danger firstnameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="lastname" value="<?php echo e(old('lastname')); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Last name'); ?>"/>
                            <span class="text-danger lastnameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="text"
                                autocomplete="off"
                                name="username" value="<?php echo e(old('username')); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Username'); ?>"/>
                            <span class="text-danger usernameError"></span>
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="email"
                                autocomplete="off"
                                name="email" value="<?php echo e(old('email')); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Email address'); ?>"/>
                            <span class="text-danger emailError"></span>
                        </div>
                        <div class="input-box col-6">
                            <?php
                                $country_code = (string) @getIpInfo()['code'] ?: null;
                                $myCollection = collect(config('country'))->map(function($row) {
                                    return collect($row);
                                });
                                $countries = $myCollection->sortBy('code');
                            ?>
                            <select
                                class="form-select form-control country_code dialCode-change" name="phone_code"
                                aria-label="Default select example" id="basic-addon1">
                                <option selected="" disabled><?php echo app('translator')->get('Select Code'); ?></option>
                                <?php $__currentLoopData = config('country'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value['phone_code']); ?>"
                                            data-name="<?php echo e($value['name']); ?>"
                                            data-code="<?php echo e($value['code']); ?>"
                                        <?php echo e($country_code == $value['code'] ? 'selected' : ''); ?>> <?php echo e($value['name']); ?>

                                        (<?php echo e($value['phone_code']); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="input-box col-6">
                            <input
                                type="text"
                                autocomplete="off"
                                name="phone" value="<?php echo e(old('phone')); ?>"
                                class="form-control dialcode-set"
                                placeholder="<?php echo app('translator')->get('Phone Number'); ?>"/>
                            <span class="text-danger phoneError"></span>
                            <input  autocomplete="off" type="hidden" name="country_code" value="<?php echo e(old('country_code')); ?>" class="text-dark">
                        </div>
                        <div class="input-box col-12">
                            <input
                                type="password"
                                name="password" value="<?php echo e(old('password')); ?>"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Password'); ?>"/>
                            <span class="text-danger passwordError"></span>
                        </div>
                        <div class="input-box col-12 mb-3">
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="<?php echo app('translator')->get('Confirm Password'); ?>"/>
                        </div>
                    </div>

                    <button type="submit" class="btn-custom w-100 login-signup-auth-btn"><?php echo app('translator')->get('sign up'); ?></button>
                    <div class="bottom">
                        <?php echo app('translator')->get('Already have an account?'); ?>

                        <a href="<?php echo e(route('login')); ?>"><?php echo app('translator')->get('Login here'); ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('script'); ?>
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
<?php $__env->stopPush(); ?>
<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/partials/modal-form.blade.php ENDPATH**/ ?>