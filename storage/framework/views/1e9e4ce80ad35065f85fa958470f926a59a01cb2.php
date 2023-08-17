<!-- categories -->
<div class="categories" id="categories">
    <a href="<?php echo e(route('home')); ?>" <?php if(Request::routeIs('home')): ?> class="active" <?php endif; ?>>
        <i class="far fa-globe-americas"></i> <span><?php echo e(trans('All Sports')); ?></span>
    </a>

    <?php
        $segments = request()->segments();
        $last  = end($segments);
    ?>

    <?php $__empty_1 = true; $__currentLoopData = $gameCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gameCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

    <a href="<?php echo e(route('category',[slug($gameCategory->name), $gameCategory->id])); ?>"
       class="<?php echo e(( Request::routeIs('category') && $last == $gameCategory->id) ? 'active' : ''); ?>">
        <?php echo $gameCategory->icon ?> <span><?php echo e($gameCategory->name); ?></span>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
</div>
<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/partials/home/navbar.blade.php ENDPATH**/ ?>