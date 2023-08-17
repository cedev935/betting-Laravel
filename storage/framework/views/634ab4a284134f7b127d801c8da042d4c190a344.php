<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('SMS Controls'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/admin/css/jquery-ui.min.css')); ?>" rel="stylesheet" type="text/css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-6">

            <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
                <div class="card-body">
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
                                    <pre>[[receiver]]</pre>
                                </td>
                                <td> <?php echo app('translator')->get('User Contact Number'); ?> </td>
                            </tr>
                            <tr>
                                <td>
                                    <pre>[[message]]</pre>
                                </td>
                                <td> <?php echo app('translator')->get('Receiver Message'); ?> </td>
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
                    <h4 class="card-title"><?php echo app('translator')->get('SMS Action'); ?></h4>
                    <form method="post" action="<?php echo e(route('admin.sms-controls.action')); ?>" novalidate="novalidate"
                          class="needs-validation base-form ">
                        <?php echo csrf_field(); ?>
                        <div class="row">

                            <div class="form-group col-lg-6 col-md-6">
                                <label class="font-weight-bold"><?php echo app('translator')->get('SMS Notification'); ?></label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='sms_notification'>
                                    <input type="checkbox" name="sms_notification" class="custom-switch-checkbox"
                                           id="sms_notification"
                                           value="0" <?php if ($control->sms_notification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="sms_notification">
                                        <span class="custom-switch-checkbox-inner"></span>
                                        <span class="custom-switch-checkbox-switch"></span>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group col-lg-6 col-md-6">
                                <label class="d-block"><?php echo app('translator')->get('SMS Verification'); ?></label>
                                <div class="custom-switch-btn">
                                    <input type='hidden' value='1' name='sms_verification'>
                                    <input type="checkbox" name="sms_verification" class="custom-switch-checkbox"
                                           id="sms_verification"
                                           value="0" <?php if ($control->sms_verification == 0):echo 'checked'; endif ?> >
                                    <label class="custom-switch-checkbox-label" for="sms_verification">
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
    </div>

    <?php
        if (old()){
            $headerData = array_combine(old('headerDataKeys'),old('headerDataValues'));
            $paramData = array_combine(old('paramKeys'),old('paramValues'));
            $formData = array_combine(old('formDataKeys'),old('formDataValues'));
            $headerData = (empty(array_filter($headerData))) ? null : json_encode($headerData);
            $paramData = (empty(array_filter($paramData))) ? null : json_encode($paramData);
            $formData = (empty(array_filter($formData))) ? null : json_encode($formData);
        } else {
            $headerData = $smsControl->headerData;
            $paramData = $smsControl->paramData;
            $formData = $smsControl->formData;
        }

        $headerActive = false;
        $paramActive = false;
        $formActive = false;

        if ($errors->has('headerDataKeys.*') || $errors->has('headerDataValues.*')) {
            $headerActive = true;
        }elseif ($errors->has('paramKeys.*') || $errors->has('paramValues.*')) {
            $paramActive = true;
        } elseif ($errors->has('formDataKeys.*') || $errors->has('formDataValues.*')) {
            $formActive = true;
        } else {
            $headerActive = true;
        }
    ?>

    <div class="card  card-form m-0 m-md-4 my-4 m-md-0">
        <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-white"><?php echo app('translator')->get('SMS Configuration'); ?></h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.sms.config')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="actionMethod"><?php echo app('translator')->get('Method'); ?></label>
                            <select name="actionMethod" id="actionMethod"
                                    class="form-control  <?php $__errorArgs = ['actionMethod'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option
                                    value="GET" <?php echo e((old('actionMethod',$smsControl->actionMethod) == 'GET') ? 'selected' : ''); ?>>
                                    GET
                                </option>
                                <option
                                    value="POST" <?php echo e((old('actionMethod',$smsControl->actionMethod) == 'POST') ? 'selected' : ''); ?> >
                                    POST
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                <?php $__errorArgs = ['actionMethod'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="actionUrl"><?php echo app('translator')->get('URL'); ?></label>
                            <input type="text" name="actionUrl" value="<?php echo e(old('actionUrl',$smsControl->actionUrl)); ?>"
                                   placeholder="<?php echo app('translator')->get('Enter request URL'); ?>"
                                   class="form-control  <?php $__errorArgs = ['actionUrl'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <div class="invalid-feedback">
                                <?php $__errorArgs = ['actionUrl'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(($headerActive) ? 'active' : ''); ?>" id="headerData-tab" data-toggle="tab"
                           href="#headerData" role="tab" aria-controls="headerData"
                           aria-selected="<?php echo e(($headerActive) ? 'true' : 'false'); ?>"><?php echo app('translator')->get('Headers'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(($paramActive) ? 'active' : ''); ?>" id="params-tab" data-toggle="tab"
                           href="#params" role="tab" aria-controls="params"
                           aria-selected="<?php echo e(($paramActive) ? 'true' : 'false'); ?>"><?php echo app('translator')->get('Params'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(($formActive) ? 'active' : ''); ?>" id="formData-tab" data-toggle="tab"
                           href="#formData" role="tab" aria-controls="contact"
                           aria-selected="<?php echo e(($formActive) ? 'true' : 'false'); ?>"><?php echo app('translator')->get('Form Data'); ?></a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="mt-2 tab-pane fade <?php echo e(($headerActive) ? 'show active' : ''); ?>" id="headerData"
                         role="tabpanel" aria-labelledby="headerData-tab">
                        <label for="headerData  my-3"><?php echo app('translator')->get('Headers'); ?></label>

                        <div class="headerDataWrapper mt-2">
                            <?php if(is_null($headerData)): ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="headerDataKeys[]" value=""
                                                   placeholder="<?php echo app('translator')->get('Key'); ?>" class="form-control  headerDataKeys">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="headerDataValues[]" value=""
                                                   placeholder="<?php echo app('translator')->get('Value'); ?>" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a href="javascript:void(0);"
                                               class="btn btn-primary btn-sm addHeaderData"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php $__currentLoopData = json_decode($headerData); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="headerDataKeys[]" value="<?php echo e($key); ?>"
                                                       placeholder="<?php echo app('translator')->get('Key'); ?>" autocomplete="off"
                                                       class="form-control  headerDataKeys <?php $__errorArgs = ["headerDataKeys.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div
                                                    class="invalid-feedback"><?php $__errorArgs = ["headerDataKeys.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="headerDataValues[]" value="<?php echo e($value); ?>"
                                                       placeholder="<?php echo app('translator')->get('Value'); ?>"
                                                       class="form-control  <?php $__errorArgs = ["headerDataValues.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div
                                                    class="invalid-feedback"><?php $__errorArgs = ["headerDataValues.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <?php if($loop->first): ?>
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-primary btn-sm addHeaderData"><i
                                                            class="fas fa-plus"></i></a>
                                                <?php else: ?>
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-danger btn-sm removeDiv"><i
                                                            class="fas fa-minus"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade <?php echo e(($paramActive) ? 'show active' : ''); ?>" id="params" role="tabpanel"
                         aria-labelledby="params-tab">
                        <label for="params  my-3"><?php echo app('translator')->get('Params'); ?></label>
                        <div class="paramsWrapper mt-2 ">
                            <?php if(is_null($paramData)): ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="paramKeys[]" value="" placeholder="<?php echo app('translator')->get('Key'); ?>"
                                                   class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="paramValues[]" value=""
                                                   placeholder="<?php echo app('translator')->get('Value'); ?>" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm addParams"><i
                                                    class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php $__currentLoopData = json_decode($paramData); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="paramKeys[]" value="<?php echo e($key); ?>"
                                                       placeholder="<?php echo app('translator')->get('Key'); ?>"
                                                       class="form-control  <?php $__errorArgs = ["paramKeys.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div
                                                    class="invalid-feedback"><?php $__errorArgs = ["paramKeys.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="paramValues[]" value="<?php echo e($value); ?>"
                                                       placeholder="<?php echo app('translator')->get('Value'); ?>"
                                                       class="form-control  <?php $__errorArgs = ["paramValues.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div
                                                    class="invalid-feedback"><?php $__errorArgs = ["paramValues.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <?php if($loop->first): ?>
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-primary btn-sm addParams"><i
                                                            class="fas fa-plus"></i></a>
                                                <?php else: ?>
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-danger btn-sm removeDiv"><i
                                                            class="fas fa-minus"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tab-pane fade<?php echo e(($formActive) ? 'show active' : ''); ?>" id="formData" role="tabpanel"
                         aria-labelledby="formData-tab">
                        <label for="formData my-3"><?php echo app('translator')->get('Form Data'); ?></label>
                        <div class="formDataWrapper mt-2">
                            <?php if(is_null($formData)): ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="formDataKeys[]" value="" placeholder="<?php echo app('translator')->get('Key'); ?>"
                                                   class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="formDataValues[]" value=""
                                                   placeholder="<?php echo app('translator')->get('Value'); ?>" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm addFormData"><i
                                                    class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php $__currentLoopData = json_decode($formData); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="formDataKeys[]" value="<?php echo e($key); ?>"
                                                       placeholder="<?php echo app('translator')->get('Key'); ?>"
                                                       class="form-control  <?php $__errorArgs = ["formDataKeys.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div
                                                    class="invalid-feedback"><?php $__errorArgs = ["formDataKeys.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="formDataValues[]" value="<?php echo e($value); ?>"
                                                       placeholder="<?php echo app('translator')->get('Value'); ?>"
                                                       class="form-control  <?php $__errorArgs = ["formDataValues.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <div
                                                    class="invalid-feedback"><?php $__errorArgs = ["formDataValues.$loop->index"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <?php if($loop->first): ?>
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-primary btn-sm addFormData"><i
                                                            class="fas fa-plus"></i></a>
                                                <?php else: ?>
                                                    <a href="javascript:void(0);"
                                                       class="btn btn-danger btn-sm removeDiv"><i
                                                            class="fas fa-minus"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <button type="submit"
                        class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3"><?php echo app('translator')->get('Save Changes'); ?></button>
            </form>
        </div>
    </div>


    <div class="paramHtml d-none">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="paramKeys[]" value="" placeholder="<?php echo app('translator')->get('Key'); ?>" class="form-control ">
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <input type="text" name="paramValues[]" value="" placeholder="<?php echo app('translator')->get('Value'); ?>" class="form-control ">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <a href="#" class="btn btn-danger btn-sm removeDiv"><i class="fas fa-minus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="formDataHtml d-none">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="formDataKeys[]" value="" placeholder="<?php echo app('translator')->get('Key'); ?>" class="form-control ">
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <input type="text" name="formDataValues[]" value="" placeholder="<?php echo app('translator')->get('Value'); ?>"
                           class="form-control ">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <a href="#" class="btn btn-danger btn-sm removeDiv"><i class="fas fa-minus"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="headerDataHtml d-none">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="headerDataKeys[]" value="" placeholder="<?php echo app('translator')->get('Key'); ?>"
                           class="form-control  headerDataKeys">
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <input type="text" name="headerDataValues[]" value="" placeholder="<?php echo app('translator')->get('Value'); ?>"
                           class="form-control ">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <a href="#" class="btn btn-danger btn-sm removeDiv"><i class="fas fa-minus"></i></a>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js-lib'); ?>
    <script src="<?php echo e(asset('assets/admin/js/jquery-ui.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>

    <script>
        'use strict'
        $(document).ready(function () {
            let headerDataHtml = $('.headerDataHtml').html();
            let addHeaderData = $('.addHeaderData'); //Add button selector
            let headerDataWrapper = $('.headerDataWrapper'); //Input field wrapper
            //Once add button is clicked
            $(addHeaderData).click(function () {
                $(headerDataWrapper).append(headerDataHtml); //Add field html
            });

            let formDataHtml = $('.formDataHtml').html();
            let addFormData = $('.addFormData'); //Add button selector
            let formDataWrapper = $('.formDataWrapper'); //Input field wrapper
            //Once add button is clicked
            $(addFormData).click(function () {
                $(formDataWrapper).append(formDataHtml); //Add field html
            });

            let paramHtml = $('.paramHtml').html();
            let addParams = $('.addParams'); //Add button selector
            let paramsWrapper = $('.paramsWrapper'); //Input field wrapper
            //Once add button is clicked
            $(addParams).click(function () {
                $(paramsWrapper).append(paramHtml); //Add field html
            });

            //Once remove button is clicked
            $(document).on('click', '.removeDiv', function (e) {
                e.preventDefault();
                $(this).closest('.row').remove();
            });

            let availableTags = ["Accept", "Accept-CH", "Accept-CH-Lifetime", "Accept-Charset", "Accept-Encoding", "Accept-Language", "Accept-Patch", "Accept-Post", "Accept-Ranges", "Access-Control-Allow-Credentials", "Access-Control-Allow-Headers", "Access-Control-Allow-Methods", "Access-Control-Allow-Origin", "Access-Control-Expose-Headers", "Access-Control-Max-Age", "Access-Control-Request-Headers", "Access-Control-Request-Method", "Age", "Allow", "Alt-Svc", "Authorization", "Cache-Control", "Clear-Site-Data", "Connection", "Content-Disposition", "Content-Encoding", "Content-Language", "Content-Length", "Content-Location", "Content-Range", "Content-Security-Policy", "Content-Security-Policy-Report-Only", "Content-Type", "Cookie", "Cookie2", "Cross-Origin-Embedder-Policy", "Cross-Origin-Opener-Policy", "Cross-Origin-Resource-Policy", "DNT", "DPR", "Date", "Device-Memory", "Digest", "ETag", "Early-Data", "Expect", "Expect-CT", "Expires", "Feature-Policy", "Forwarded", "From", "Host", "If-Match", "If-Modified-Since", "If-None-Match", "If-Range", "If-Unmodified-Since", "Index", "Keep-Alive", "Large-Allocation", "Last-Modified", "Link", "Location", "NEL", "Origin", "Pragma", "Proxy-Authenticate", "Proxy-Authorization", "Public-Key-Pins", "Public-Key-Pins-Report-Only", "Range", "Referer", "Referrer-Policy", "Retry-After", "Save-Data", "Sec-Fetch-Dest", "Sec-Fetch-Mode", "Sec-Fetch-Site", "Sec-Fetch-User", "Sec-WebSocket-Accept", "Server", "Server-Timing", "Set-Cookie", "Set-Cookie2", "SourceMap", "Strict-Transport-Security", "TE", "Timing-Allow-Origin", "Tk", "Trailer", "Transfer-Encoding", "Upgrade", "Upgrade-Insecure-Requests", "User-Agent", "Vary", "Via", "WWW-Authenticate", "Want-Digest", "Warning", "X-Content-Type-Options", "X-DNS-Prefetch-Control", "X-Forwarded-For", "X-Forwarded-Host", "X-Forwarded-Proto", "X-Frame-Options", "X-XSS-Protection"];

            $(document).on('click', addHeaderData, function () {
                $(".headerDataKeys").autocomplete({
                    // source: availableTags,
                    autoFocus: true,
                    source: function (request, response) {
                        var results = $.ui.autocomplete.filter(availableTags, request.term);
                        response(results.slice(0, 10));
                    }
                });
            })
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/sms-template/config.blade.php ENDPATH**/ ?>