<?php $__env->startSection('title', trans($page_title)); ?>
<?php $__env->startSection('content'); ?>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <?php if(adminAccessRoute(config('role.payout_manage.access.add'))): ?>
                <div class="media mb-4 justify-content-end">
                    <a href="<?php echo e(route('admin.payout-method.create')); ?>" class="btn btn-sm  btn-primary mr-2">
                        <span><i class="fas fa-plus"></i> <?php echo app('translator')->get('Add New'); ?></span>
                    </a>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered no-wrap" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('Name'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('Name'); ?>">
                                <div class="d-flex no-block align-items-center">
                                    <div class="mr-3">
                                        <img src="<?php echo e(getFile(config('location.withdraw.path').$method->image)); ?>"
                                             alt="<?php echo e($method->name); ?>" class="rounded-circle" width="45" height="45">
                                    </div>
                                    <div class="mr-3">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo e($method->name); ?></h5>
                                    </div>
                                    <?php if($method->is_automatic == 1): ?>
                                        <div class="">
                                            <span class="badge badge-pill  badge-success"><?php echo app('translator')->get('Automated'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Status'); ?>" class="text-sm">
                                <span class="badge badge-light">
                                    <i class="fa fa-circle <?php echo e($method->status == 0 ? 'text-danger danger font-12' : 'text-success success font-12'); ?>"></i> <?php echo e($method->status == 0 ? 'Inactive' : 'Active'); ?></span>
                            </td>
                            <?php if(adminAccessRoute(config('role.payout_manage.access.edit'))): ?>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <a href="<?php echo e(route('admin.payout-method.edit', $method->id)); ?>"
                                       class="btn btn-sm btn-primary"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-original-title="<?php echo app('translator')->get('Edit Payment Methods Info'); ?>">
                                        <i class="fa fa-edit"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-center text-danger" colspan="8">
                                <?php echo app('translator')->get('No Data Found'); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/admin/css/dataTables.bootstrap4.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('assets/admin/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/datatable-basic.init.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/payout/index.blade.php ENDPATH**/ ?>