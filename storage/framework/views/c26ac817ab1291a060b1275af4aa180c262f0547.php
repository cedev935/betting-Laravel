<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Create Language'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="card card-primary card-form m-0 m-md-4 my-4 m-md-0">
        <div class="card-body">

            <a href="<?php echo e(route('admin.language.index')); ?>" class="btn btn-sm btn-primary float-right mb-3"><i
                    class="fas fa-arrow-left"></i> <?php echo app('translator')->get('Back'); ?></a>


            <form method="post" action="<?php echo e(route('admin.language.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row mt-5 justify-content-center">

                    <div class="col-md-3 d-none">
                        <div class="image-input ">
                            <label for="image-upload" id="image-label"><i class="fas fa-upload"></i></label>
                            <input type="file" name="flag" placeholder="Choose image" id="image">
                            <img id="image_preview_container" class="preview-image"
                                 src="<?php echo e(getFile(config('location.language.path'))); ?>"
                                 alt="preview image">
                        </div>
                        <?php $__errorArgs = ['flag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>


                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name"><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" name="name" placeholder="<?php echo app('translator')->get('Enter name of country'); ?>"
                                   class="form-control  <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <div class="invalid-feedback"><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>

                        <div class="form-group">
                            <label for="short_name"><?php echo app('translator')->get('Short Name'); ?></label>
                            <select name="short_name"
                                    class="select2-single form-control <?php $__errorArgs = ['short_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="short_name">
                                <?php $__currentLoopData = config('languages.langCode'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($key); ?>" <?php echo e((old('short_name') == $key ? ' selected' : '')); ?>><?php echo e($key.' - '.$value); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback"><?php $__errorArgs = ['short_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo app('translator')->get($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?></div>
                        </div>

                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group ">
                                   <label class="d-block"><?php echo app('translator')->get('Status'); ?></label>
                                   <div class="custom-switch-btn w-md-75">
                                       <input type='hidden' value='1' name='is_active'>
                                       <input type="checkbox" name="is_active" class="custom-switch-checkbox" id="is_active"
                                              value="0">
                                       <label class="custom-switch-checkbox-label" for="is_active">
                                           <span class="custom-switch-checkbox-inner"></span>
                                           <span class="custom-switch-checkbox-switch"></span>
                                       </label>
                                   </div>
                                   <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                   <span class="text-danger"><?php echo e($message); ?></span>
                                   <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                               </div>
                           </div>

                           <div class="col-md-6 d-none">
                               <div class="form-group ">
                                   <label class="d-block"><?php echo app('translator')->get('RTL'); ?></label>
                                   <div class="custom-switch-btn w-md-75">
                                       <input type='hidden' value='1' name='rtl'>
                                       <input type="checkbox" name="rtl" class="custom-switch-checkbox" id="rtl"
                                              value="0">
                                       <label class="custom-switch-checkbox-label" for="rtl">
                                           <span class="custom-switch-checkbox-inner"></span>
                                           <span class="custom-switch-checkbox-switch"></span>
                                       </label>
                                   </div>
                                   <?php $__errorArgs = ['rtl'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                   <span class="text-danger"><?php echo e($message); ?></span>
                                   <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                               </div>
                           </div>

                       </div>


                        <button class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">
                            <?php echo app('translator')->get('Create New Language'); ?>
                        </button>

                    </div>


                </div>

            </form>

        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        $(document).ready(function (e) {
            "use strict";

            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('select[name=short_name]').select2({
                selectOnClose: true
            });
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/language/create.blade.php ENDPATH**/ ?>