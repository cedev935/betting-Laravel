<?php $__env->startSection('title', trans($title)); ?>

<?php $__env->startSection('content'); ?>
    <?php if(isset($contentDetails['blog'])): ?>
        <!-- blog details -->
        <section class="blog-details blog-list">
            <div class="container">
                <div class="row justify-content-center gy-5 g-lg-5">
                    <div class="col-lg-10">
                        <?php $__empty_1 = true; $__currentLoopData = $contentDetails['blog']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="blog-box row">
                                <div class="col-md-6 img-box">
                                    <img
                                        src="<?php echo e(getFile(config('location.content.path') . optional($item->content)->contentMedia->description->image)); ?>"
                                        class="img-fluid"
                                        alt="..."/>
                                </div>
                                <div class="col-md-6 text-box">
                                    <a href="<?php echo e(route('blogDetails', [slug(optional($item->description)->title), $item->content_id])); ?>"
                                       class="title">
                                        <?php echo app('translator')->get(optional($item->description)->title); ?>
                                    </a>
                                    <div class="date-author">
                           <span class="author">
                              <i class="fas fa-dot-circle"></i><?php echo app('translator')->get('Admin'); ?>
                           </span>
                                        <span class="float-end"><?php echo e(dateTime($item->created_at, 'd M, Y')); ?></span>
                                    </div>
                                    <p>
                                        <?php echo app('translator')->get(Str::limit(optional($item->description)->description,200)); ?>
                                    </p>
                                    <a href="<?php echo e(route('blogDetails', [slug(optional($item->description)->title), $item->content_id])); ?>" class="read-more"><?php echo app('translator')->get('Read more'); ?></a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/blog.blade.php ENDPATH**/ ?>