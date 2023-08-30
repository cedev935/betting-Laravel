<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Referral Commission'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class=" m-0 m-md-4 my-4 m-md-0">
        <div class="row justify-content-between ">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary shadow">
                            <div class="card-body">
                                <form method="post" action="<?php echo e(route('admin.referral-commission.action')); ?>" class="form-inline align-items-center justify-content-between">
                                    <?php echo csrf_field(); ?>

                                    <div class="form-group col-md-6 mb-3">
                                        <label class="text-dark"><?php echo app('translator')->get('Upline Deposit Bonus'); ?></label>
                                        <div class="custom-switch-btn ">
                                            <input type='hidden' value='1' name='deposit_commission'>
                                            <input type="checkbox" name="deposit_commission"
                                                   class="custom-switch-checkbox "
                                                   id="deposit_commission"
                                                   value="0" <?php if ($control->deposit_commission == 0):echo 'checked'; endif ?> >
                                            <label class="custom-switch-checkbox-label" for="deposit_commission">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <label class="text-dark"><?php echo app('translator')->get('Upline Bet Commission'); ?></label>
                                        <div class="custom-switch-btn ">
                                            <input type='hidden' value='1' name='bet_commission'>
                                            <input type="checkbox" name="bet_commission"
                                                   class="custom-switch-checkbox "
                                                   id="bet_commission"
                                                   value="0" <?php if ($control->bet_commission == 0):echo 'checked'; endif ?> >
                                            <label class="custom-switch-checkbox-label" for="bet_commission">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="form-group col-md-6 mb-3">
                                        <label class="text-dark"><?php echo app('translator')->get('Upline Bet Win Commission'); ?></label>
                                        <div class="custom-switch-btn ">
                                            <input type='hidden' value='1' name='bet_win_commission'>
                                            <input type="checkbox" name="bet_win_commission"
                                                   class="custom-switch-checkbox "
                                                   id="bet_win_commission"
                                                   value="0" <?php if ($control->bet_win_commission == 0):echo 'checked'; endif ?> >
                                            <label class="custom-switch-checkbox-label" for="bet_win_commission">
                                                <span class="custom-switch-checkbox-inner"></span>
                                                <span class="custom-switch-checkbox-switch"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 mb-3">
                                        <button type="submit"
                                                class="btn  btn-rounded btn-primary mt-4 btn-block">
                                            <span><?php echo app('translator')->get('Save Changes'); ?></span></button>
                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="card card-primary shadow">
                            <div class="card-body">


                                <h5 class="card-title"><?php echo app('translator')->get('Deposit Bonus'); ?></h5>
                                <div class="table-responsive">
                                    <table class="categories-show-table table table-hover table-striped table-bordered"
                                           id="zero_config">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"><?php echo app('translator')->get('Level'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('Bonus'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $referrals->where('commission_type','deposit'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td data-label="Level"><?php echo app('translator')->get('LEVEL'); ?># <?php echo e($item->level); ?></td>
                                                <td data-label="<?php echo app('translator')->get('Bonus'); ?>">
                                                    <?php echo e($item->percent); ?> %
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="100%"><?php echo app('translator')->get('No Data Found'); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="card card-primary shadow">
                            <div class="card-body">


                                <h5 class="card-title"><?php echo app('translator')->get('Bet Invest Bonus'); ?></h5>
                                <div class="table-responsive">
                                    <table class="categories-show-table table table-hover table-striped table-bordered"
                                           id="zero_config">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"><?php echo app('translator')->get('Level'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('Bonus'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $referrals->where('commission_type','bet_invest'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td data-label="Level"><?php echo app('translator')->get('LEVEL'); ?># <?php echo e($item->level); ?></td>
                                                <td data-label="<?php echo app('translator')->get('Bonus'); ?>">
                                                    <?php echo e($item->percent); ?> %
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="100%"><?php echo app('translator')->get('No Data Found'); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>


                        <div class="card card-primary shadow">
                            <div class="card-body">


                                <h5 class="card-title"><?php echo app('translator')->get('Bet Win Bonus'); ?></h5>
                                <div class="table-responsive">
                                    <table class="categories-show-table table table-hover table-striped table-bordered"
                                           id="zero_config">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col"><?php echo app('translator')->get('Level'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('Bonus'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $referrals->where('commission_type','bet_win'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td data-label="Level"><?php echo app('translator')->get('LEVEL'); ?># <?php echo e($item->level); ?></td>
                                                <td data-label="<?php echo app('translator')->get('Bonus'); ?>">
                                                    <?php echo e($item->percent); ?> %
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="100%"><?php echo app('translator')->get('No Data Found'); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">

                <div class="card card-primary shadow">

                    <div class="card-body">

                        <div class="row  formFiled justify-content-between ">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label class="font-weight-bold"><?php echo app('translator')->get('Select Type'); ?></label>
                                    <select name="type" class="form-control  type">
                                        <option value="" disabled><?php echo app('translator')->get('Select Type'); ?></option>
                                        <option value="deposit"><?php echo app('translator')->get('Deposit Bonus'); ?></option>
                                        <option value="bet_invest"><?php echo app('translator')->get('Bet Invest Bonus'); ?></option>
                                        <option value="bet_win"><?php echo app('translator')->get('Bet Win Bonus'); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold"><?php echo app('translator')->get('Set Level'); ?></label>
                                    <input type="number" name="level" placeholder="<?php echo app('translator')->get('Number Of Level'); ?>"
                                           class="form-control  numberOfLevel">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-primary btn-block  makeForm ">
                                        <i class="fa fa-spinner"></i> <?php echo app('translator')->get('GENERATE'); ?>
                                    </button>
                                </div>
                            </div>


                        </div>

                        <form action="" method="post" class="form-row">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="commission_type" value="">
                            <div class="col-md-12 newFormContainer">

                            </div>


                            <div class="col-md-12">
                                <button type="submit"
                                        class="btn btn-primary btn-block mt-3 submit-btn"><?php echo app('translator')->get('Submit'); ?></button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>

        .table-responsive {
             min-height: initial;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>

    <?php if($errors->any()): ?>
        <?php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        ?>
        <script>
            "use strict";
            <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            Notiflix.Notify.Failure("<?php echo e(trans($error)); ?>");
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>

    <script>
        "use strict";
        $(document).ready(function () {

            $('.submit-btn').addClass('d-none');

            $(".makeForm").on('click', function () {

                var levelGenerate = $(this).parents('.formFiled').find('.numberOfLevel').val();
                var selectType = $('.type :selected').val();
                if (selectType == '') {
                    Notiflix.Notify.Failure("<?php echo e(trans('Please Select a type')); ?>");
                    return 0
                }

                $('input[name=commission_type]').val(selectType)
                var value = 1;
                var viewHtml = '';
                if (levelGenerate !== '' && levelGenerate > 0) {
                    for (var i = 0; i < parseInt(levelGenerate); i++) {
                        viewHtml += `<div class="input-group mt-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text no-right-border">LEVEL</span>
                            </div>
                            <input name="level[]" class="form-control" type="number" readonly value="${value++}" required placeholder="<?php echo app('translator')->get('Level'); ?>">
                            <input name="percent[]" class="form-control" type="text" required placeholder="<?php echo app('translator')->get("Level Bonus (%)"); ?>">
                            <span class="input-group-btn">
                            <button class="btn btn-danger removeForm" type="button"><i class='fa fa-trash'></i></button></span>
                            </div>`;
                    }

                    $('.newFormContainer').html(viewHtml);
                    $('.submit-btn').addClass('d-block');
                    $('.submit-btn').removeClass('d-none');

                } else {

                    $('.submit-btn').addClass('d-none');
                    $('.submit-btn').removeClass('d-block');
                    $('.newFormContainer').html(``);
                    Notiflix.Notify.Failure("<?php echo e(trans('Please Set number of level')); ?>");
                }
            });

            $(document).on('click', '.removeForm', function () {
                $(this).closest('.input-group').remove();
            });


            $('select').select2({
                selectOnClose: true
            });

        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/referral-commission.blade.php ENDPATH**/ ?>