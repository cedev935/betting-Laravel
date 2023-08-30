<?php $__env->startSection('title', $page_title); ?>



<?php $__env->startSection('content'); ?>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <?php if(adminAccessRoute(config('role.subscriber.access.view'))): ?>
            <a href="<?php echo e(route('admin.subscriber.sendEmail')); ?>"
               class="btn btn-primary mb-3 float-right" >
               <?php echo app('translator')->get('Send Email'); ?>
            </a>
            <?php endif; ?>


            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Email'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Joined'); ?></th>
                        <?php if(adminAccessRoute(config('role.subscriber.access.delete'))): ?>
                        <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscriber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL.'); ?>"><?php echo e(loopIndex($subscribers) + $loop->index); ?></td>
                            <td data-label="<?php echo app('translator')->get('Email'); ?>"><?php echo e($subscriber->email); ?></td>
                            <td data-label="<?php echo app('translator')->get('Joined'); ?>"><?php echo e(dateTime($subscriber->created_at)); ?></td>

                            <?php if(adminAccessRoute(config('role.subscriber.access.delete'))): ?>
                            <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                <a href="javascript:void(0)"
                                   data-id="<?php echo e($subscriber->id); ?>"
                                   data-email="<?php echo e($subscriber->email); ?>"
                                   class="btn btn-danger removeModalBtn" data-toggle="tooltip" title=""
                                   data-original-title="<?php echo app('translator')->get('Remove'); ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-center text-danger" colspan="9"><?php echo app('translator')->get('No Subscriber Found!'); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($subscribers->links('partials.pagination')); ?>



            </div>
        </div>
    </div>




    <div class="modal fade" id="removeModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Are you sure want to remove?'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="<?php echo e(route('admin.subscriber.remove')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="subscriber">
                        <p><span class="font-weight-bold subscriber-email"></span> <?php echo app('translator')->get('will be removed.'); ?></p>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn-danger"><?php echo app('translator')->get('Remove'); ?></button>
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
            $('.removeModalBtn').on('click', function () {
                $('#removeModal').find('input[name=subscriber]').val($(this).data('id'));
                $('#removeModal').find('.subscriber-email').text($(this).data('email'));
                $('#removeModal').modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/subscriber/index.blade.php ENDPATH**/ ?>