<?php $__env->startSection('title',trans($title)); ?>
<?php $__env->startSection('content'); ?>

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">

            <?php if(adminAccessRoute(config('role.manage_staff.access.add'))): ?>
                <div class="d-flex justify-content-end mb-2 text-right">
                    <button data-target="#addModal" data-toggle="modal" class="btn btn-primary btn-sm"><i
                            class="fa fa-user-plus"></i> <?php echo e(trans('Add New')); ?> </button>
                </div>
            <?php endif; ?>

            <?php echo $__env->make('errors.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Username'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Email'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Phone'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <?php if(adminAccessRoute(config('role.manage_staff.access.edit'))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td data-label="SL"><?php echo e(++$k); ?></td>
                            <td data-label="Username"><strong><?php echo e($data->username); ?></strong></td>
                            <td data-label="Email"><?php echo e($data->email); ?></td>
                            <td data-label="Phone"><?php echo e($data->phone); ?></td>

                            <td>
                                <span
                                    class="badge  badge-pill  badge-<?php echo e($data->status ==0 ? 'danger' : 'success'); ?>"><?php echo e($data->status == 0 ? 'Deactive' : 'Active'); ?></span>
                            </td>
                            <?php if(adminAccessRoute(config('role.manage_staff.access.edit'))): ?>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <button
                                        class="edit_button   btn btn-primary  text-white  btn-sm "
                                        data-target="#myModal<?php echo e($data->id); ?>"
                                        data-id="<?php echo e($data->id); ?>"
                                        data-toggle="modal">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <!-- Modal for Edit button -->
                                    <div class="modal fade" id="myModal<?php echo e($data->id); ?>" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel"
                                         aria-hidden="true" data-backdrop="static">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content ">
                                                <div class="modal-header modal-colored-header bg-primary">
                                                    <h4 class="modal-title"
                                                        id="myModalLabel"><?php echo app('translator')->get('Manage Admin Role'); ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true">&times;
                                                    </button>
                                                </div>

                                                <form role="form" method="POST" class="actionRoute"
                                                      action="<?php echo e(route('admin.updateStaff',$data)); ?>"
                                                      enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('put'); ?>
                                                    <div class="modal-body">

                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> <?php echo e(trans('Name')); ?> :</label>
                                                                <input class="form-control " name="name"
                                                                       placeholder="<?php echo e(trans('Name')); ?>"
                                                                       value="<?php echo e($data->name); ?>" required
                                                                       autocomplete="off">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> <?php echo e(trans('Username')); ?>

                                                                    :</label>
                                                                <input class="form-control " name="username"
                                                                       placeholder="<?php echo e(trans('Username')); ?>"
                                                                       value="<?php echo e($data->username); ?>" autocomplete="off"
                                                                       required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> <?php echo e(trans('E-Mail')); ?> :</label>
                                                                <input class="form-control " name="email"
                                                                       placeholder="Email Address"
                                                                       value="<?php echo e($data->email); ?>"
                                                                       autocomplete="off"
                                                                       required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> <?php echo e(trans('Phone')); ?> :</label>
                                                                <input class="form-control " name="phone"
                                                                       placeholder="<?php echo e(trans('Mobile Number')); ?>"
                                                                       value="<?php echo e($data->phone); ?>" autocomplete="off"
                                                                       required>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> <?php echo e(trans('Password')); ?>

                                                                    :</label>
                                                                <input type="password" name="password"
                                                                       placeholder="Password" autocomplete="off"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label class="text-dark"> <?php echo e(trans('Select Status')); ?>

                                                                    :</label>
                                                                <select name="status" id="event-status"
                                                                        class="form-control " required>
                                                                    <option value="1"
                                                                            <?php if($data->status == '1'): ?> selected <?php endif; ?>>
                                                                        <?php echo e(trans('Active')); ?>

                                                                    </option>
                                                                    <option value="0"
                                                                            <?php if($data->status == '0'): ?> selected <?php endif; ?>>
                                                                        <?php echo e(trans('DeActive')); ?>

                                                                    </option>
                                                                </select>
                                                                <br>
                                                            </div>


                                                            <div class="form-group col-md-12">
                                                                <div class="card">
                                                                    <div
                                                                        class="card-header d-flex justify-content-between text-center">
                                                                        <h5 class="card-title text-center"><?php echo e(trans('Accessibility')); ?></h5>
                                                                    </div>

                                                                    <div class="card-body select-all-access">
                                                                        <div class="form-group">
                                                                            <label><input type="checkbox"
                                                                                          class="selectAll"
                                                                                          name="accessAll"> <?php echo e(trans('Select All')); ?>

                                                                            </label>
                                                                        </div>

                                                                        <table
                                                                            class=" table table-hover table-striped table-bordered text-center">
                                                                            <thead class="thead-dark">
                                                                            <tr>
                                                                                <th class="text-left"><?php echo app('translator')->get('Permissions'); ?></th>
                                                                                <th><?php echo app('translator')->get('View'); ?></th>
                                                                                <th><?php echo app('translator')->get('Add'); ?></th>
                                                                                <th><?php echo app('translator')->get('Edit'); ?></th>
                                                                                <th><?php echo app('translator')->get('Delete'); ?></th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $__currentLoopData = config('role'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <tr>
                                                                                    <td data-label="Permissions"
                                                                                        class="text-left"><?php echo e($value['label']); ?></td>
                                                                                    <td data-label="View">
                                                                                        <?php if(!empty($value['access']['view'])): ?>
                                                                                            <input type="checkbox"
                                                                                                   value="<?php echo e(join(',',$value['access']['view'])); ?>"
                                                                                                   name="access[]"
                                                                                                   <?php if(in_array_any( $value['access']['view'], $data->admin_access??[] )): ?>
                                                                                                   checked
                                                                                                <?php endif; ?>
                                                                                            />
                                                                                        <?php endif; ?>
                                                                                    </td>
                                                                                    <td data-label="Add">
                                                                                        <?php if(!empty($value['access']['add'])): ?>
                                                                                            <input type="checkbox"
                                                                                                   value="<?php echo e(join(',',$value['access']['add'])); ?>"
                                                                                                   name="access[]"

                                                                                                   <?php if(in_array_any($value['access']['add'], $data->admin_access??[] )): ?>
                                                                                                   checked
                                                                                                <?php endif; ?>
                                                                                            />
                                                                                        <?php endif; ?>
                                                                                    </td>
                                                                                    <td data-label="Edit">
                                                                                        <?php if(!empty($value['access']['edit'])): ?>
                                                                                            <input type="checkbox"
                                                                                                   value="<?php echo e(join(',',$value['access']['edit'])); ?>"
                                                                                                   name="access[]"
                                                                                                   <?php if(in_array_any($value['access']['edit'], $data->admin_access??[])): ?>
                                                                                                   checked
                                                                                                <?php endif; ?>/>
                                                                                        <?php endif; ?>
                                                                                    </td>

                                                                                    <td data-label="Delete">
                                                                                        <?php if(!empty($value['access']['delete'])): ?>
                                                                                            <input type="checkbox"
                                                                                                   value="<?php echo e(join(',',$value['access']['delete'])); ?>"
                                                                                                   name="access[]"
                                                                                                   <?php if(in_array_any( $value['access']['delete'], $data->admin_access??[])): ?>
                                                                                                   checked
                                                                                                <?php endif; ?>
                                                                                            />
                                                                                        <?php endif; ?>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </tbody>
                                                                        </table>


                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                                                        <button type="submit"
                                                                class="btn btn-success"><?php echo app('translator')->get('Update'); ?></button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <!-- Modal for Add button -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="myModalLabel"><?php echo app('translator')->get('Manage Admin Role'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <form role="form" method="POST" class="actionRoute" action="<?php echo e(route('admin.storeStaff')); ?>"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="text-dark"> <?php echo e(trans('Name')); ?> :</label>
                                <input class="form-control " name="name"
                                       placeholder="<?php echo e(trans('Name')); ?>" value="<?php echo e(old('name')); ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> <?php echo e(trans('Username')); ?> :</label>
                                <input class="form-control " name="username"
                                       placeholder="<?php echo e(trans('Username')); ?>" value="<?php echo e(old('username')); ?>"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> <?php echo e(trans('E-Mail')); ?> :</label>
                                <input class="form-control " name="email"
                                       placeholder="Email Address" value="<?php echo e(old('email')); ?>"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> <?php echo e(trans('Phone')); ?> :</label>
                                <input class="form-control " name="phone"
                                       placeholder="<?php echo e(trans('Mobile Number')); ?>" value="<?php echo e(old('phone')); ?>"
                                       required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> <?php echo e(trans('Password')); ?> :</label>
                                <input type="password" name="password" placeholder="Password"
                                       class="form-control " value="<?php echo e(old('password')); ?>" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"> <?php echo e(trans('Select Status')); ?> :</label>
                                <select name="status" id="event-status"
                                        class="form-control " required>
                                    <option value="1" <?php if(old('status') == '1'): ?> selected <?php endif; ?>>
                                        <?php echo e(trans('Active')); ?>

                                    </option>
                                    <option value="0" <?php if(old('status') == '0'): ?> selected <?php endif; ?>>
                                        <?php echo e(trans('DeActive')); ?>

                                    </option>
                                </select>
                                <br>
                            </div>


                            <div class="form-group col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between text-center">
                                        <h5 class="card-title text-center"><?php echo e(trans('Accessibility')); ?></h5>
                                    </div>

                                    <div class="card-body select-all-access">
                                        <div class="form-group">
                                            <label><input type="checkbox" class="selectAll"
                                                          name="accessAll"> <?php echo e(trans('Select All')); ?></label>
                                        </div>

                                        <table class=" table table-hover table-striped table-bordered text-center">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th class="text-left"><?php echo app('translator')->get('Permissions'); ?></th>
                                                <th><?php echo app('translator')->get('View'); ?></th>
                                                <th><?php echo app('translator')->get('Add'); ?></th>
                                                <th><?php echo app('translator')->get('Edit'); ?></th>
                                                <th><?php echo app('translator')->get('Delete'); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = config('role'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td data-label="Permissions"
                                                        class="text-left"><?php echo e($value['label']); ?></td>
                                                    <td data-label="View">
                                                        <?php if(!empty($value['access']['view'])): ?>
                                                            <input type="checkbox"
                                                                   value="<?php echo e(join(",",$value['access']['view'])); ?>"
                                                                   name="access[]"/>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td data-label="Add">
                                                        <?php if(!empty($value['access']['add'])): ?>
                                                            <input type="checkbox"
                                                                   value="<?php echo e(join(",",$value['access']['add'])); ?>"
                                                                   name="access[]"/>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td data-label="Edit">
                                                        <?php if(!empty($value['access']['edit'])): ?>
                                                            <input type="checkbox"
                                                                   value="<?php echo e(join(",",$value['access']['edit'])); ?>"
                                                                   name="access[]"/>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td data-label="Delete">
                                                        <?php if(!empty($value['access']['delete'])): ?>
                                                            <input type="checkbox"
                                                                   value="<?php echo e(join(",",$value['access']['delete'])); ?>"
                                                                   name="access[]"/>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn-success"><?php echo app('translator')->get('Save'); ?></button>
                    </div>

                </form>


            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>

    <script>
        $(document).ready(function () {
            "use strict";
            $('.selectAll').on('click', function () {
                if ($(this).is(':checked')) {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').attr('checked', 'checked')
                } else {
                    $(this).parents('.select-all-access').find('input[type="checkbox"]').removeAttr('checked')
                }
            })
        })

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/staff/index.blade.php ENDPATH**/ ?>