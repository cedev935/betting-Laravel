<?php
    $segments = request()->segments();
    $last  = end($segments);
?>

<ul class="main">
    <li>
        <a  <?php if(Request::routeIs('home')): ?> class="active" <?php endif; ?>
            href="<?php echo e(route('home')); ?>">
            <i class="far fa-globe-americas"></i> <span><?php echo e(trans('All Sports')); ?></span>
        </a>
    </li>
    <?php $__empty_1 = true; $__currentLoopData = $gameCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gameCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <li>
            <a
                class="dropdown-toggle "
                data-bs-toggle="collapse"
                href="#collapse<?php echo e($gameCategory->id); ?>"
                role="button"
                aria-expanded="true"
                aria-controls="collapseExample">
                <?php echo $gameCategory->icon; ?><?php echo e($gameCategory->name); ?>

                <span class="count"><span class="font-italic">(<?php echo e($gameCategory->game_active_match_count); ?>)</span></span>
            </a>
            <!-- dropdown item -->

            <div class="collapse <?php echo e(($loop->index == 0) ? 'show' :''); ?>" id="collapse<?php echo e($gameCategory->id); ?>">
                <ul class="">
                    <?php $__empty_2 = true; $__currentLoopData = $gameCategory->activeTournament; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <li>
                            <a href="<?php echo e(route('tournament',[slug($tItem->name) , $tItem->id ])); ?>" class="sidebar-link <?php echo e(( Request::routeIs('tournament') && $last == $tItem->id) ? 'active' : ''); ?>">
                                <i class="far fa-hand-point-right"></i> <?php echo e($tItem->name); ?></a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                    <?php endif; ?>
                </ul>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
</ul>
<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/partials/home/leftMenu.blade.php ENDPATH**/ ?>