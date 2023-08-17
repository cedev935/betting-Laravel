<?php $__env->startSection('title', trans('Latest 10 Results')); ?>
<?php $__env->startSection('content'); ?>
    <?php if($betResult): ?>
        <!-- faq section -->
        <section class="faq-section faq-page">
            <div class="container">
                <div class="row g-4 gy-5 justify-content-center align-items-center">
                    <div class="col-lg-12">
                        <div class="accordion" id="accordionExample">
                            <?php $__empty_1 = true; $__currentLoopData = $betResult; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="accordion-item">
                                    <h5 class="accordion-header" id="heading<?php echo e($key); ?>">
                                        <button
                                            class="accordion-button <?php if($key != 0): ?>collapsed" <?php endif; ?>
                                        type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse<?php echo e($key); ?>"
                                            aria-expanded="true"
                                            aria-controls="collapse<?php echo e($key); ?>">
                                            <?php echo e(optional($item->gameTeam1)->name); ?>

                                            <img src="<?php echo e(getFile(config('location.team.path') . optional($item->gameTeam1)->image)); ?>"
                                                alt="user" class="rounded-circle mx-1" width="25" height="25">
                                            <?php echo app('translator')->get('vs'); ?>
                                            <img src="<?php echo e(getFile(config('location.team.path') . optional($item->gameTeam2)->image)); ?>"
                                                 alt="user" class="rounded-circle mx-1" width="25" height="25">
                                            <?php echo e($item->gameTeam2->name); ?>

                                        </button>
                                    </h5>
                                    <div
                                        id="collapse<?php echo e($key); ?>"
                                        class="accordion-collapse collapse <?php if($key==0): ?>
                                        show"
                                        <?php endif; ?>
                                        aria-labelledby="heading<?php echo e($key); ?>"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-striped ">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                                                    <th scope="col"><?php echo app('translator')->get('Result'); ?></th>
                                                </tr>
                                                </thead>
                                                <tbody class="result-body">
                                                <?php $__empty_2 = true; $__currentLoopData = $item->gameQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gameQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <tr>
                                                        <td data-label="<?php echo app('translator')->get('#'); ?>"><?php echo e(++$key); ?></td>
                                                        <td data-label="<?php echo app('translator')->get('Name'); ?>"><?php echo e($gameQuestion->name); ?></td>
                                                        <?php if(optional($gameQuestion->gameOptionResult)->option_name): ?>
                                                            <td data-label="<?php echo app('translator')->get('Result'); ?>"><?php echo e(optional($gameQuestion->gameOptionResult)->option_name); ?></td>
                                                        <?php else: ?>
                                                            <td data-label="<?php echo app('translator')->get('Result'); ?>"><?php echo app('translator')->get('N/A'); ?></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/user/betResult/index.blade.php ENDPATH**/ ?>