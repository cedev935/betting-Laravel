<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Language'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="row">

                <?php if(adminAccessRoute(config('role.language_settings.access.add'))): ?>
                    <div class="col-md-12">
                        <a href="<?php echo e(route('admin.language.create')); ?>"
                           class="btn btn-sm btn-primary float-right mb-3"><i
                                class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add New'); ?></a>
                    </div>
                <?php endif; ?>

                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <div class="card shadow border-eee">
                            <div class="card-header bg-white ">
                                <h4 class="py-3 text-primary"><i
                                        class="fa fa-folder-open"></i> <?php echo e(kebab2Title($language->name)); ?>

                                    <?php if($language->is_active): ?>
                                        <span class="float-right badge badge-success badge-pill"><?php echo app('translator')->get('Active'); ?></span>
                                    <?php else: ?>
                                        <span
                                            class="float-right badge badge-warning badge-pill"><?php echo app('translator')->get('Inactive'); ?></span>
                                    <?php endif; ?>
                                </h4>
                            </div>

                            <?php if(adminAccessRoute(array_merge(config('role.language_settings.access.edit'), config('role.language_settings.access.delete')))): ?>
                                <div class="card-footer bg-white border-top-eee d-flex justify-content-between">
                                    <?php if(adminAccessRoute(config('role.language_settings.access.edit'))): ?>
                                        <a href="<?php echo e(route('admin.language.edit',$language)); ?>"
                                           class=" btn-sm btn btn-outline-dark" title="<?php echo app('translator')->get('Edit'); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a class="btn btn-sm btn-outline-primary" title="<?php echo e(trans('Keywords')); ?>"
                                           href="<?php echo e(route('admin.language.keywordEdit',$language)); ?>">
                                            <i class="fas fa-code"></i>
                                        </a>

                                    <?php endif; ?>

                                    <?php if($language->short_name != 'US'): ?>
                                        <?php if(adminAccessRoute(config('role.language_settings.access.delete'))): ?>
                                            <a href="javascript:void(0)" title="<?php echo app('translator')->get('Delete'); ?>"
                                               class="btn btn-sm btn-outline-danger deleteBtn"
                                               data-toggle="modal" data-target="#deleteModal"
                                               data-route="<?php echo e(route('admin.language.delete',$language)); ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>


                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>
    </div>



    <!-- Primary Header Modal -->
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="primary-header-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel"><?php echo app('translator')->get('Delete Confirmation'); ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to delete this?'); ?></p>
                </div>

                <form action="" method="post" class="actionForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('delete'); ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                                data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Delete'); ?></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.deleteBtn').on('click', function () {
                $('.actionForm').attr('action', $(this).data('route'));
            })
        })

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/language/index.blade.php ENDPATH**/ ?>