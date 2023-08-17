<nav id="pagination">
    <?php if($paginator->hasPages()): ?>
        <ul class="pagination wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.35s">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="disabled page-item">
                    <a href="#" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only"><?php echo app('translator')->get('Previous'); ?></span>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="page-link" rel="prev">&laquo;</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class=" page-item">
                        <a href="#" class="page-link"><?php echo e($element); ?></a>
                    </li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active">
                                <a href="#" class="page-link"><?php echo e($page); ?><span class="sr-only">(current)</span></a>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a href="<?php echo e($url); ?>" class="page-link"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="page-link" rel="next">&raquo;</a>
                </li>
            <?php else: ?>
                <li class="disabled page-item">
                    <a href="#" class="disabled page-link" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only"><?php echo app('translator')->get('Next'); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
</nav>
<?php /**PATH F:\work\betting\orca odd\resources\views/partials/pagination.blade.php ENDPATH**/ ?>