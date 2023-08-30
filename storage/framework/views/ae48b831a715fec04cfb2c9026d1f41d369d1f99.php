<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Result History'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.searchResult')); ?>" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="search" value="<?php echo e(@request()->search); ?>" class="form-control"
                                       placeholder="<?php echo app('translator')->get('Questions or teams name'); ?>">
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
                        <th><?php echo app('translator')->get('Question'); ?></th>
                        <th class="text-center"><?php echo app('translator')->get('Match'); ?></th>
                        <th><?php echo app('translator')->get('End Time'); ?></th>
                        <th><?php echo app('translator')->get('Predictions'); ?></th>
                        <th><?php echo app('translator')->get('Action'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $gameQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL No.'); ?>"><?php echo e(++$key); ?></td>
                            <td data-label="<?php echo app('translator')->get('Question'); ?>"><?php echo app('translator')->get($item->name); ?></td>
                            <td data-label="<?php echo app('translator')->get('Match'); ?>">
                                <div class="d-lg-flex d-block align-items-center ">
                                    <div class="mr-3 cursor-pointer"
                                         title="<?php echo e(optional($item->gameMatch)->gameTeam1->name); ?>">
                                        <small
                                            class="text-dark font-weight-bold"><?php echo e(shortName(optional($item->gameMatch)->gameTeam1->name)); ?></small>
                                    </div>
                                    <div class="mr-2 cursor-pointer"
                                         title="<?php echo e(optional($item->gameMatch)->gameTeam1->name); ?>">
                                        <img
                                            src="<?php echo e(getFile(config('location.team.path') . optional($item->gameMatch)->gameTeam1->image)); ?>"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <small class="font-italic mb-0 font-16 "><?php echo app('translator')->get('vs'); ?></small>

                                    <div class="mr-3 ml-2 cursor-pointer"
                                         title="<?php echo e(optional($item->gameMatch)->gameTeam2->name); ?>">
                                        <img
                                            src="<?php echo e(getFile(config('location.team.path') . optional($item->gameMatch)->gameTeam2->image)); ?>"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <div class="cursor-pointer" title="<?php echo e(optional($item->gameMatch)->gameTeam2->name); ?>">
                                        <small
                                            class="text-dark font-weight-bold"><?php echo e(shortName(optional($item->gameMatch)->gameTeam2->name)); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td data-label="<?php echo app('translator')->get('End Time'); ?>">
                                <?php echo e(dateTime($item->end_time, 'd M Y h:i A')); ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('Predictions'); ?>"><span
                                    class="badge badge-success"><?php echo e($item->bet_invest_log_count); ?></span></td>
                            <td data-label="<?php echo app('translator')->get('Action'); ?>">

                                <a href="<?php echo e(route('admin.resultWinner',$item->id)); ?>">
                                    <button type="button"
                                            class="btn btn-outline-dark btn-sm optionInfo"
                                            title="<?php echo app('translator')->get('Select Winner'); ?>">
                                        <i class="fa fa-eye"
                                           aria-hidden="true"></i>
                                    </button>
                                </a>


                                <button type="button" class="btn btn-sm btn-outline-primary editBtn"
                                        data-resource="<?php echo e($item); ?>"
                                        data-action="<?php echo e(route('admin.updateQuestion', $item->id)); ?>"
                                        data-target="#edit-modal"
                                        data-toggle="modal" data-backdrop="static"
                                        title="<?php echo app('translator')->get('Edit Question'); ?>" <?php echo e(($item->result == 1)?'disabled':''); ?>>
                                    <i class="fa fa-edit"
                                       aria-hidden="true"></i>
                                </button>


                                <?php if($item->result == 0): ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger refundQuestion"
                                            data-action="<?php echo e(route('admin.refundQuestion', $item->id)); ?>"
                                            data-target="#refundQuestion-Modal"
                                            data-toggle="modal" data-backdrop="static"
                                            title="<?php echo app('translator')->get('Refund Bet'); ?>">
                                        <i class="fa fa-paper-plane"
                                           aria-hidden="true"></i>
                                    </button>
                                <?php endif; ?>



                                <a href="<?php echo e(route('admin.betUser',$item->id)); ?>">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-success investLogList">
                                        <i class="fa fa-info-circle"></i></button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($gameQuestions->appends(@$search)->links('partials.pagination')); ?>

            </div>
        </div>
    </div>
    
    <div id="editModal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Edit Question'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" class="questionId" name="questionId" value="">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" class="form-control editName" name="name" value="" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="text-dark"><?php echo app('translator')->get('Status'); ?> </label>
                            <select id="editStatus" class="form-control editStatus"
                                    name="status" required>
                                <option value=""><?php echo app('translator')->get('Select Status'); ?></option>
                                <option value="1"><?php echo app('translator')->get('Active'); ?></option>
                                <option value="0"><?php echo app('translator')->get('Pending'); ?></option>
                                <option value="2"><?php echo app('translator')->get('Closed'); ?></option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('End Date'); ?></label>
                            <input type="datetime-local" class="form-control editTime" name="end_time"
                                   id="editEndDate" required>
                            <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Update'); ?></button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="refundQuestion-Modal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Refund Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure to refund this?'); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Yes'); ?></button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <script src="<?php echo e(asset('assets/admin/js/fontawesome/fontawesomepro.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        'use script'
        $(document).on('click', '.editBtn', function () {
            var modal = $('#editModal');
            var obj = $(this).data('resource');
            modal.find('input[name=name]').val(obj.name);
            $('.questionId').val(obj.id);
            $('#editStatus').val(obj.status);
            $('#editEndDate').val(obj.end_time);
            modal.find('form').attr('action', $(this).data('action'));
            modal.modal('show');
        });

        $(document).on('click', '.refundQuestion', function () {
            var modal = $('#refundQuestion-Modal');
            modal.find('form').attr('action', $(this).data('action'));
            modal.modal('show');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/result_history/index.blade.php ENDPATH**/ ?>