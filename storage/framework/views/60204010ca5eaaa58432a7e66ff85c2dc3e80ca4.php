<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Email Controls'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <button class="btn btn-primary btn-sm mb-2" type="button" data-toggle="modal"
                            data-target="#testEmail">
                        <span class="btn-label"><i class="fas fa-envelope"></i></span>
                        <?php echo app('translator')->get('Test Email'); ?>
                    </button>
                    <a href="https://www.youtube.com/watch?v=dv3UxhWg" target="_blank"
                       class="btn btn-primary btn-sm mb-2 text-white float-right" type="button">
                        <span class="btn-label"><i class="fab fa-youtube"></i></span>
                        <?php echo app('translator')->get('How to set up it?'); ?>
                    </a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-primary">
                            <tr>
                                <th> <?php echo app('translator')->get('SHORTCODE'); ?> </th>
                                <th> <?php echo app('translator')->get('DESCRIPTION'); ?> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <pre><?php echo app('translator')->get(' [[name]] '); ?></pre>
                                </td>
                                <td> <?php echo app('translator')->get("User's Name will replace here."); ?> </td>
                            </tr>
                            <tr>
                                <td>
                                    <pre><?php echo app('translator')->get(' [[message]] '); ?></pre>
                                </td>
                                <td><?php echo app('translator')->get("Application notification message will replace here."); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <h4 class="card-title"><?php echo app('translator')->get('Email Action'); ?></h4>
                    <form method="post" action="<?php echo e(route('admin.email-controls.action')); ?>" novalidate="novalidate"
                          class="needs-validation base-form ">
                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <div class="form-group col-lg-6 col-md-6">
                                <label class="d-block"><?php echo app('translator')->get('Email Notification'); ?></label>

                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='email_notification'>
                                    <input type="checkbox" name="email_notification" class="custom-switch-checkbox"
                                           id="email_notification"
                                           value="0" <?php if ($control->email_notification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="email_notification">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group col-lg-6 col-md-6">
                                <label class="d-block"><?php echo app('translator')->get('Email Verification'); ?></label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='email_verification'>
                                    <input type="checkbox" name="email_verification" class="custom-switch-checkbox"
                                           id="email_verification"
                                           value="0" <?php if ($control->email_verification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="email_verification">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>

                        </div>

                        <button type="submit"
                                class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                            <span><?php echo app('translator')->get('Save Changes'); ?></span></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>

    </div>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <form action="" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label><?php echo app('translator')->get('From Email'); ?></label>
                            <input type="text" name="sender_email" class="form-control"
                                   placeholder="<?php echo app('translator')->get('Email Address'); ?>" value="<?php echo e($control->sender_email); ?>">
                            <?php $__errorArgs = ['sender_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e(trans($message)); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label><?php echo app('translator')->get('From Email Name'); ?></label>
                            <input type="text" name="sender_email_name" class="form-control"
                                   placeholder="<?php echo app('translator')->get('Email Address'); ?>" value="<?php echo e($control->sender_email_name); ?>">
                            <?php $__errorArgs = ['sender_email_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e(trans($message)); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>


                    <div class="col-md-3 d-none">
                        <div class="form-group">
                            <label><?php echo e(trans('Send Email Method')); ?></label>
                            <select name="email_method" class="form-control">
                                <option value="sendmail"
                                        <?php if(old('email_method', @$control->email_configuration->name) == "sendmail"): ?>  selected <?php endif; ?>><?php echo app('translator')->get('PHP Mail'); ?></option>
                                <option value="smtp"
                                        <?php if( old('email_method', @$control->email_configuration->name) == "smtp"): ?> selected <?php endif; ?>><?php echo app('translator')->get('SMTP'); ?></option>
                            </select>

                            <?php $__errorArgs = ['email_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e(trans($message)); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="form-row mt-4 d-none configForm" id="smtp">
                    <div class="col-md-12">
                        <h6 class="mb-2"><?php echo e(trans('SMTP Configuration')); ?></h6>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold"><?php echo e(trans('Host')); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Host or Email Address'); ?>"
                               name="smtp_host"
                               value="<?php echo e(old('smtp_host', $control->email_configuration->smtp_host ?? '')); ?>"/>
                        <?php $__errorArgs = ['smtp_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e(trans($message)); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="font-weight-bold"><?php echo e(trans('Port')); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Available port'); ?>" name="smtp_port"
                               value="<?php echo e(old('smtp_port', $control->email_configuration->smtp_port ?? '')); ?>"/>
                        <?php $__errorArgs = ['smtp_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e(trans($message)); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold"><?php echo e(trans('Encryption')); ?></label>

                        <select name="smtp_encryption" class="form-control">
                            <option value="tls"
                                    <?php if( old('smtp_encryption', @$control->email_configuration->smtp_encryption) == "tls"): ?> selected <?php endif; ?>><?php echo app('translator')->get('tls'); ?></option>
                            <option value="ssl"
                                    <?php if( old('smtp_encryption', @$control->email_configuration->smtp_encryption) == "ssl"): ?> selected <?php endif; ?>><?php echo app('translator')->get('ssl'); ?></option>
                        </select>

                        <?php $__errorArgs = ['smtp_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e(trans($message)); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold"><?php echo e(trans('Username')); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('username or Email'); ?>"
                               name="smtp_username"
                               value="<?php echo e(old('smtp_username', $control->email_configuration->smtp_username ?? '')); ?>"/>
                        <?php $__errorArgs = ['smtp_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e(trans($message)); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold"><?php echo e(trans('Password')); ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Password'); ?>" name="smtp_password"
                               value="<?php echo e(old('smtp_password', $control->email_configuration->smtp_password ?? '')); ?>"/>
                        <?php $__errorArgs = ['smtp_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e(trans($message)); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>


                <div class="form-group ">
                    <label><?php echo app('translator')->get('Email Description'); ?></label>
                    <textarea class="form-control summernote" name="email_description" id="summernote"
                              placeholder="<?php echo app('translator')->get('Email Description'); ?>"
                              rows="20"><?php echo $email_description ?></textarea>
                </div>
                <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                    <span><?php echo app('translator')->get('Save Changes'); ?></span></button>
            </form>
        </div>
    </div>
    <!-- testEmail Modal -->
    <div class="modal fade" id="testEmail">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="<?php echo e(route('admin.testEmail')); ?>" class="" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <!-- Modal Header -->
                    <div class="modal-header modal-colored-header bg-primary">
                        <h4 class="modal-title"><?php echo app('translator')->get('Test Email'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <label for="email"><?php echo app('translator')->get('Enter Your Email'); ?></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="<?php echo app('translator')->get('Enter Your Email'); ?>" >
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span>
                        </button>
                        <button type="submit" class=" btn btn-primary "><span><?php echo app('translator')->get('Yes'); ?></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/summernote.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/summernote.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        "use strict";
        $(document).ready(function () {


            $('#summernote').summernote({
                minHeight: 200,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable').val();
                        $(this).val(codeviewHtml);
                    }
                }
            });
        });
        $('select[name=email_method]').on('change', function () {
            var method = $(this).val();

            $('.configForm').addClass('d-none');
            if (method != 'sendmail') {
                $(`#${method}`).removeClass('d-none');
            }
        }).change();


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/email-template/config.blade.php ENDPATH**/ ?>