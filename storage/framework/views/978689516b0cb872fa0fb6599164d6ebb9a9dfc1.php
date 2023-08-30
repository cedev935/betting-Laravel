<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get("Transaction"); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.transaction.search')); ?>" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" name="transaction_id" value="<?php echo e(@request()->transaction_id); ?>" class="form-control get-trx-id"
                                       placeholder="<?php echo app('translator')->get('Search for Transaction ID'); ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="user_name" value="<?php echo e(@request()->user_name); ?>" class="form-control get-username"
                                       placeholder="<?php echo app('translator')->get('Username'); ?>">
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="remark" value="<?php echo e(@request()->remark); ?>" class="form-control get-service"
                                       placeholder="<?php echo app('translator')->get('Remark'); ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn waves-effect waves-light btn-primary"><i class="fas fa-search"></i> <?php echo app('translator')->get('Search'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th scope="col"><?php echo app('translator')->get('No.'); ?></th>
                    <th scope="col"><?php echo app('translator')->get('TRX'); ?></th>
                    <th scope="col"><?php echo app('translator')->get('User'); ?></th>
                    <th scope="col"><?php echo app('translator')->get('Amount'); ?></th>
                    <th scope="col"><?php echo app('translator')->get('Detail'); ?></th>
                    <th scope="col"><?php echo app('translator')->get('Date - Time'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td data-label="<?php echo app('translator')->get('No.'); ?>"><?php echo e(loopIndex($transaction) + $k); ?></td>
                        <td data-label="<?php echo app('translator')->get('TRX'); ?>"><?php echo app('translator')->get($row->trx_id); ?></td>
                        <td data-label="<?php echo app('translator')->get('User'); ?>">
                            <a href="<?php echo e(route('admin.user-edit',$row->user_id)); ?>">
                                <div class="d-lg-flex d-block align-items-center ">
                                    <div class="mr-3"><img src="<?php echo e(getFile(config('location.user.path').optional($row->user)->image)); ?>" alt="user" class="rounded-circle" width="45" height="45"></div>
                                    <div class="">
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo app('translator')->get(optional($row->user)->username); ?></h5>
                                        <span class="text-muted font-14"><?php echo e(optional($row->user)->email); ?></span>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td data-label="<?php echo app('translator')->get('Amount'); ?>"> <span class="text-<?php echo e(($row->trx_type == "+") ? 'success' :'danger'); ?>"><?php echo e(config('basic.currency_symbol')); ?><?php echo e(getAmount($row->amount, config('basic.fraction_number'))); ?></span></td>
                        <td data-label="<?php echo app('translator')->get('Detail'); ?>"><?php echo app('translator')->get($row->remarks); ?></td>
                        <td data-label="<?php echo app('translator')->get('Date - Time'); ?>"><?php echo e(dateTime($row->created_at, 'd M, Y h:i A')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="text-center text-danger" colspan="8"><?php echo app('translator')->get('No User Data'); ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($transaction->links('partials.pagination')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/transaction/index.blade.php ENDPATH**/ ?>