<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Bet History'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.searchBet')); ?>" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="search" value="<?php echo e(@request()->search); ?>" class="form-control"
                                       placeholder="<?php echo app('translator')->get('Trx. or User email or username'); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date_time" id="datepicker"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn w-100  btn-primary"><i
                                        class="fas fa-search"></i> <?php echo app('translator')->get('Search'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card card-primary m-0 m-md-4  m-md-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th><?php echo app('translator')->get('SL No.'); ?></th>
                        <th><?php echo app('translator')->get('Trx.'); ?></th>
                        <th><?php echo app('translator')->get('User'); ?></th>
                        <th><?php echo app('translator')->get('Prediction Amount'); ?></th>
                        <th><?php echo app('translator')->get('Return Amount'); ?></th>
                        <th><?php echo app('translator')->get('Charge'); ?></th>
                        <th><?php echo app('translator')->get('Ratio'); ?></th>
                        <th><?php echo app('translator')->get('Time'); ?></th>
                        <th class="text-center"><?php echo app('translator')->get('Status'); ?></th>
                        <th class="text-center"><?php echo app('translator')->get('More'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $betInvests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL No.'); ?>"><?php echo e(++$key); ?></td>
                            <td data-label="<?php echo app('translator')->get('Trx.'); ?>"><?php echo e($item->transaction_id); ?></td>
                            <td data-label="<?php echo app('translator')->get('User'); ?>">
                                <a href="<?php echo e(route('admin.user-edit',$item->user_id)); ?>">
                                    <div class="d-lg-flex d-block align-items-center ">
                                        <div class="mr-3"><img
                                                src="<?php echo e(getFile(config('location.user.path').optional($item->user)->image)); ?>"
                                                alt="user" class="rounded-circle" width="45" height="45"></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium"><?php echo app('translator')->get(optional($item->user)->username); ?></h5>
                                            <span class="text-muted font-14"><?php echo e(optional($item->user)->email); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Prediction Amount'); ?>"><?php echo e(config('basic.currency_symbol')); ?><?php echo app('translator')->get($item->invest_amount); ?></td>
                            <td data-label="<?php echo app('translator')->get('Return Amount'); ?>"><?php echo e(config('basic.currency_symbol')); ?><?php echo app('translator')->get($item->return_amount); ?></td>
                            <td data-label="<?php echo app('translator')->get('Charge'); ?>"><?php echo e(config('basic.currency_symbol')); ?><?php echo app('translator')->get($item->charge); ?></td>
                            <td data-label="<?php echo app('translator')->get('Ratio'); ?>"> <?php echo app('translator')->get($item->ratio); ?></td>
                            <td data-label="<?php echo app('translator')->get('Time'); ?>">
                                <?php echo e(dateTime($item->created_at, 'd/m/Y H:i')); ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('Status'); ?>" class="text-lg-center text-right">
                                <?php if($item->status == 0): ?>
                                    <span class="badge badge-light"><i
                                            class="fa fa-circle text-warning warning font-12"></i>
                                        <?php echo app('translator')->get('Processing'); ?></span>
                                <?php elseif($item->status == 1): ?>
                                    <span class="badge badge-light"><i
                                            class="fa fa-circle text-success success font-12"></i>
                                        <?php echo app('translator')->get('Win'); ?></span>
                                <?php elseif($item->status == -1): ?>
                                    <span class="badge badge-light"><i class="fa fa-circle text-danger danger font-12"></i>
                                        <?php echo app('translator')->get('Loss'); ?></span>
                                <?php elseif($item->status == 2): ?>
                                    <span class="badge badge-light"><i
                                            class="fa fa-circle text-danger danger font-12"></i>
                                        <?php echo app('translator')->get('Refund'); ?></span>
                                <?php endif; ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('More'); ?>" class="text-center">
                                <button type="button" data-resource="<?php echo e($item->betInvestLog); ?>"
                                        data-target="#investLogList" data-toggle="modal"
                                        class="btn btn-sm btn-outline-success investLogList">
                                    <i class="fa fa-info-circle"></i></button>
                                <button type="button" data-id="<?php echo e($item->id); ?>" data-route="<?php echo e(route('admin.refundBet')); ?>"
                                        data-target="#refund" data-toggle="modal"
                                        class="btn btn-sm btn-outline-primary refundBet" <?php echo e(($item->status == 2 )?'disabled':''); ?> >
                                    <i class="fa fa-paper-plane"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($betInvests->appends(@$search)->links('partials.pagination')); ?>

            </div>
        </div>
    </div>

    
    <div class="modal fade" id="investLogList" role="dialog">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title service-title">Information</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">×
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"><?php echo app('translator')->get('Match Name'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Category Name'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Tournament Name '); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Question Name'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Option Name'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Ratio'); ?></th>
                            <th scope="col"><?php echo app('translator')->get('Result'); ?></th>
                        </tr>
                        </thead>
                        <tbody class="result-body">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal"><span><?php echo app('translator')->get('Close'); ?></span></button>
                </div>
            </div>
        </div>
    </div>

    
    <div id="refund" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel"><?php echo app('translator')->get('Refund Amount'); ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you want to this?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="refundRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('post'); ?>
                        <input type="hidden" name="betInvestId" value="" class="betInvestId">
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <script src="<?php echo e(asset('assets/admin/js/fontawesome/fontawesomepro.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        'use strict'
        $(document).on('click', '.refundBet', function () {
            $('.betInvestId').val($(this).data('id'));
            var route = $(this).data('route');
            $('.refundRoute').attr('action', route)
        });

        $(document).on('click', '.investLogList', function () {
            var obj = $(this).data('resource');
            var output = [];
            if (0 < obj.length) {
                obj.map(function (obj, i) {
                    var tr =
                        `<tr>
                        <td>${++i}</td>
                        <td>${(obj).match_name}</td>
                        <td>${obj.category_icon} ${obj.category_name}</td>
                        <td>${obj.tournament_name}</td>
                        <td>${obj.question_name}</td>
                        <td>${obj.option_name}</td>
                        <td>${obj.ratio}</td>
                        <td>
                            ${(obj.status == '0') ? ` <span class='badge badge-light'><i class="fa fa-circle text-warning warning font-12"></i> <?php echo app('translator')->get('Processing'); ?></span>` : ''}
                            ${(obj.status == '2') ? ` <span class='badge badge-light'><i class="fa fa-circle text-success success font-12"></i> <?php echo app('translator')->get('Win'); ?></span>` : ''}
                            ${(obj.status == '-2') ? ` <span class='badge badge-light'><i class="fa fa-circle text-danger danger font-12"></i> <?php echo app('translator')->get('Lose'); ?></span>` : ''}
                            ${(obj.status == '3') ? ` <span class='badge badge-light'><i class="fa fa-circle text-secondary secondary font-12"></i> <?php echo app('translator')->get('Refunded'); ?></span>` : ''}

                        </td>

                    </tr>`;

                    output[i] = tr;
                });

            } else {
                output[0] = `
                        <tr>
                            <td colspan="100%" class=""text-center><?php echo app('translator')->get('No Data Found'); ?></td>
                        </tr>`;
            }

            $('.result-body').html(output);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/bet_history/index.blade.php ENDPATH**/ ?>