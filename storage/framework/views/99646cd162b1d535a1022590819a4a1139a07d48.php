<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get("Commissions"); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.commissions.search')); ?>" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="user_name" value="<?php echo e(@request()->user_name); ?>" class="form-control get-username"
                                       placeholder="<?php echo app('translator')->get('Username'); ?>">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-search"></i> <?php echo app('translator')->get('Search'); ?></button>
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
                    <th><?php echo app('translator')->get('SL No.'); ?></th>
                    <th><?php echo app('translator')->get('Username'); ?></th>
                    <th><?php echo app('translator')->get('Bonus From'); ?></th>
                    <th><?php echo app('translator')->get('Amount'); ?></th>
                    <th><?php echo app('translator')->get('Remarks'); ?></th>
                    <th><?php echo app('translator')->get('Time'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td data-label="<?php echo app('translator')->get('No.'); ?>"><?php echo e(loopIndex($transactions) + $k); ?></td>
                        <td data-label="<?php echo app('translator')->get('Username'); ?>">
                            <a href="<?php echo e(route('admin.user-edit',$transaction->from_user_id)); ?>" target="_blank">
                                <?php echo app('translator')->get($transaction->user->username); ?>
                            </a>
                        </td>
                        <td data-label="<?php echo app('translator')->get('Bonus From'); ?>"><?php echo app('translator')->get(optional($transaction->bonusBy)->fullname); ?></td>
                        <td data-label="<?php echo app('translator')->get('Amount'); ?>">
                                                    <span
                                                        class="font-weight-bold text-success"><?php echo e(getAmount($transaction->amount, config('basic.fraction_number')). ' ' . trans(config('basic.currency'))); ?></span>
                        </td>

                        <td data-label="<?php echo app('translator')->get('Remarks'); ?>"> <?php echo app('translator')->get($transaction->remarks); ?></td>
                        <td data-label="<?php echo app('translator')->get('Time'); ?>">
                            <?php echo e(dateTime($transaction->created_at, 'd M Y h:i A')); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="text-center text-danger" colspan="6"><?php echo app('translator')->get('No User Data'); ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($transactions->links('partials.pagination')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/transaction/commission.blade.php ENDPATH**/ ?>