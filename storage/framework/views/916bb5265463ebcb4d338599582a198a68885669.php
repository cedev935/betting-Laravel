<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Pusher Notification'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-7">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <form method="post" action="" class="needs-validation base-form">
                        <?php echo csrf_field(); ?>
                        <div class="row my-3">
                            <div class="form-group col-sm-4 col-12">
                                <label class="font-weight-bold"><?php echo app('translator')->get('Pusher app ID'); ?></label>
                                <input type="text" name="PUSHER_APP_ID" value="<?php echo e(old('PUSHER_APP_ID',env('PUSHER_APP_ID'))); ?>"
                                       required="required" class="form-control ">
                                <?php $__errorArgs = ['PUSHER_APP_ID'];
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
                            <div class="form-group col-sm-4 col-12">
                                <label class="font-weight-bold"><?php echo app('translator')->get('Pusher app key'); ?></label>
                                <input type="text" name="PUSHER_APP_KEY"
                                       value="<?php echo e(old('PUSHER_APP_KEY',env('PUSHER_APP_KEY'))); ?>" required="required"
                                       class="form-control ">
                                <?php $__errorArgs = ['PUSHER_APP_KEY'];
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
                            <div class="form-group col-sm-4 col-12">
                                <label class="font-weight-bold"><?php echo app('translator')->get('Pusher app secret'); ?></label>
                                <input type="text" name="PUSHER_APP_SECRET"
                                       value="<?php echo e(old('PUSHER_APP_SECRET',env('PUSHER_APP_SECRET'))); ?>" required="required"
                                       class="form-control ">
                                <?php $__errorArgs = ['PUSHER_APP_SECRET'];
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

                            <div class="form-group col-sm-4 col-12">
                                <label class="font-weight-bold"><?php echo app('translator')->get('Pusher app cluster'); ?></label>
                                <input type="text" name="PUSHER_APP_CLUSTER"
                                       value="<?php echo e(old('PUSHER_APP_CLUSTER',env('PUSHER_APP_CLUSTER'))); ?>" required="required"
                                       class="form-control ">
                                <?php $__errorArgs = ['PUSHER_APP_CLUSTER'];
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


                            <div class="form-group col-sm-4  col-12">
                                <label class="font-weight-bold"><?php echo app('translator')->get('Push Notification'); ?></label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='push_notification'>
                                    <input type="checkbox" name="push_notification" class="custom-switch-checkbox"
                                           id="push_notification"
                                           value="0" <?php echo e(($control->push_notification == 0) ? 'checked' : ''); ?> >
                                    <label class="custom-switch-checkbox-label" for="push_notification">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3"><span><i
                                    class="fas fa-save pr-2"></i> <?php echo app('translator')->get('Save Changes'); ?></span></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between mb-3">
                        <div class="col-md-6">
                            <h4 class="card-title  font-weight-bold"><?php echo app('translator')->get('Instructions'); ?></h4>
                        </div>

                        <div class="col-md-6">
                            <a href="https://www.youtube.com/watch?MQszEDuWFeQ" target="_blank" class="btn btn-primary btn-sm mb-2 text-white float-right" type="button">
                                <span class="btn-label"><i class="fab fa-youtube"></i></span>
                                <?php echo app('translator')->get('How to set up it?'); ?>
                            </a>
                        </div>
                    </div>



                    <?php echo app('translator')->get('Pusher Channels provides realtime communication between servers, apps and devices.
                    When something happens in your system, it can update web-pages, apps and devices.
                    When an event happens on an app, the app can notify all other apps and your system
                    <br><br>
                    Get your free API keys'); ?>
                    <a href="https://dashboard.pusher.com/accounts/sign_up" target="_blank"><?php echo app('translator')->get('Create an account'); ?> <i class="fas fa-external-link-alt"></i></a>
                    <?php echo app('translator')->get(', then create a Channels app.
                    Go to the "Keys" page for that app, and make a note of your app_id, key, secret and cluster.'); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/notify/controls.blade.php ENDPATH**/ ?>