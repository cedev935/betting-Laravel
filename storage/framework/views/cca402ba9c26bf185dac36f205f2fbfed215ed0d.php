<?php $__env->startSection('title','Page Not Found'); ?>
<?php $__env->startSection('content'); ?>
    <!-- not found -->
    <section class="not-found">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col">
                    <div class="text-box text-center">
                        <img src="<?php echo e(asset($themeTrue . '/images/404.svg')); ?>" alt="..." />
                        <h1><?php echo e(trans('Opps!')); ?></h1>
                        <p><?php echo e(trans('The page you are looking for was not found.')); ?></p>
                        <a href="<?php echo e(url('/')); ?>" class="btn-custom text-white line-h22"><?php echo app('translator')->get('Back To Home'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/errors/404.blade.php ENDPATH**/ ?>