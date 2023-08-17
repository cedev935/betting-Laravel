<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- bootstrap 5 -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/bootstrap.min.css')); ?>"/>
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/style.css')); ?>"/>
</head>
<body <?php if(session()->get('dark-mode') == 'true'): ?> class="dark-mode"  <?php endif; ?>>
    <?php echo $__env->yieldContent('content'); ?>

</body>
</html>

<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/layouts/error.blade.php ENDPATH**/ ?>