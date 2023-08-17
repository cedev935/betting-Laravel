<!-- slider -->
<?php if(isset($contentDetails['slider'])): ?>
    <div class="skitter-large-box">
        <div class="skitter skitter-large with-dots">
            <ul>
                <?php $__currentLoopData = $contentDetails['slider']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(optional($data->content->contentMedia->description)->button_link); ?>">
                            <img
                                src="<?php echo e(getFile(config('location.content.path').@$data->content->contentMedia->description->image)); ?>"
                                class="downBars"
                            />
                        </a>
                        <div class="label_text">
                            <h2><?php echo e(optional($data->description)->name); ?></h2>
                            <p class="mb-4">
                                <?php echo e(optional($data->description)->short_description); ?>

                            </p>
                            <a href="<?php echo e(optional($data->content->contentMedia->description)->button_link); ?>"><button class="btn-custom"> <?php echo e(optional($data->description)->button_name); ?></button></a>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/partials/home/slider.blade.php ENDPATH**/ ?>