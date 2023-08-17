<?php $__env->startSection('title', trans($page_title)); ?>
<?php $__env->startSection('content'); ?>

    <?php if(adminAccessRoute(config('role.identify_form.access.edit'))): ?>
        <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
            <div class="card-body">
                <form method="post" action="<?php echo e(route('admin.identify-form.action')); ?>"
                      class="form-row align-items-center ">
                    <?php echo csrf_field(); ?>

                    <div class="form-group col-md-3">
                        <label class="d-block"><?php echo app('translator')->get('Address Verification'); ?></label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='address_verification'>
                            <input type="checkbox" name="address_verification" class="custom-switch-checkbox"
                                   id="address_verification"
                                   value="0" <?php echo e(($control->address_verification == 0) ? 'checked' : ''); ?> >
                            <label class="custom-switch-checkbox-label" for="address_verification">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="d-block"><?php echo app('translator')->get('Identity Verification'); ?></label>
                        <div class="custom-switch-btn">
                            <input type='hidden' value='1' name='identity_verification'>
                            <input type="checkbox" name="identity_verification" class="custom-switch-checkbox"
                                   id="identity_verification"
                                   value="0" <?php echo e(($control->identity_verification == 0) ? 'checked' : ''); ?> >
                            <label class="custom-switch-checkbox-label" for="identity_verification">
                                <span class="custom-switch-checkbox-inner"></span>
                                <span class="custom-switch-checkbox-switch"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit"
                                class="btn btn-primary btn-block  btn-rounded mx-2 mt-4">
                            <span><?php echo app('translator')->get('Save Changes'); ?></span></button>
                    </div>

                </form>
            </div>
        </div>
    <?php endif; ?>



    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <?php
                $newArr = ['Driving License','Passport','National ID'];
            ?>

            <?php if(count($formExist) != count($newArr) ): ?>
                <div class="d-flex justify-content-end mb-2 text-right">
                    <button data-toggle="modal" data-target="#btn_add" type="button" class="btn btn-primary btn-sm"><i
                            class="fa fa-plus-circle"></i> <?php echo e(trans('Add Form')); ?> </button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"><?php echo app('translator')->get('SL'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Identity Type'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Status'); ?></th>
                        <?php if(adminAccessRoute(config('role.identify_form.access.edit'))): ?>
                            <th scope="col"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo app('translator')->get('SL'); ?>"><?php echo e(++$key); ?></td>
                            <td data-label="<?php echo app('translator')->get('Name'); ?>">
                                <h5 class="text-dark mb-0 font-16 "><?php echo app('translator')->get($data->name); ?></h5>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                <span
                                    class="badge badge-pill <?php echo e($data->status == 0 ? 'badge-danger' : 'badge-success'); ?>"><?php echo e($data->status == 0 ? 'Inactive' : 'Active'); ?></span>
                            </td>

                            <?php if(adminAccessRoute(config('role.identify_form.access.edit'))): ?>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <a href="javascript:void(0)"
                                       data-id="<?php echo e($data->id); ?>"
                                       data-name="<?php echo e($data->name); ?>"
                                       data-status="<?php echo e($data->status); ?>"
                                       data-services_form="<?php echo e(($data->services_form == null) ? null :  json_encode(@$data->services_form)); ?>"
                                       data-toggle="modal" data-target="#editModal" data-original-title="Edit"
                                       class="btn btn-primary btn-sm editButton"><i class="fa fa-edit"></i></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-center text-danger" colspan="100%"><?php echo app('translator')->get('No Data Found'); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>


    <div class="modal  fade " id="btn_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <form action="" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i> <?php echo e(trans('Add New')); ?>

                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>


                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-6 form-group">
                                <label for="inputName" class="control-label"><strong><?php echo e(trans('Identity Type')); ?>

                                        :</strong></label>

                                <select class="form-control  w-100"
                                        data-live-search="true" name="name"
                                        required="">
                                    <option disabled selected><?php echo app('translator')->get("Select Type"); ?></option>
                                    <?php if(!in_array('Driving License', $formExist)): ?>
                                        <option value="Driving License"><?php echo e(trans('Driving License')); ?></option>
                                    <?php endif; ?>
                                    <?php if(!in_array('Passport', $formExist)): ?>
                                        <option value="Passport"><?php echo e(trans('Passport')); ?></option>
                                    <?php endif; ?>
                                    <?php if(!in_array('National ID', $formExist)): ?>
                                        <option value="National ID"><?php echo e(trans('National ID')); ?></option>
                                    <?php endif; ?>
                                </select>
                                <br>
                                <br>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e(trans($message)); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>


                            <div class="col-md-6 form-group ">
                                <label for="inputName" class="control-label d-block"><strong><?php echo e(trans('Status')); ?>

                                        :</strong></label>

                                <select class="form-control  w-100"
                                        data-live-search="true" name="status"
                                        required="">
                                    <option disabled selected><?php echo app('translator')->get("Select Status"); ?></option>
                                    <option value="1"><?php echo e(trans('Active')); ?></option>
                                    <option value="0"><?php echo e(trans('Deactive')); ?></option>
                                </select>
                                <br>

                                <br>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e(trans($message)); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-12 form-group">
                                <br>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm float-right generate"><i
                                        class="fa fa-plus-circle"></i> <?php echo e(trans('Add Field')); ?></a>

                            </div>
                        </div>

                        <div class="row addedField mt-3">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">
                            <?php echo e(trans('Close')); ?>

                        </button>
                        <button type="submit" class="btn btn-primary"> <?php echo e(trans('Save')); ?></button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <div class="modal  fade " id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <form action="" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i
                                class="fa fa-sync-alt"></i> <?php echo e(trans('Update Identity Form')); ?>

                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>


                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-md-6 form-group d-none">
                                <label for="inputName" class="control-label"><strong><?php echo e(trans('Identity Type')); ?>

                                        :</strong></label>

                                <select class="form-control  w-100 edit_name d-none"
                                        data-live-search="true" name="name"
                                        required="">
                                    <option disabled selected><?php echo app('translator')->get("Select Type"); ?></option>
                                    <option value="Driving License"><?php echo e(trans('Driving License')); ?></option>
                                    <option value="Passport"><?php echo e(trans('Passport')); ?></option>
                                    <option value="National ID"><?php echo e(trans('National ID')); ?></option>
                                </select>
                                <br>
                                <br>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e(trans($message)); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 form-group ">
                                <label for="inputName" class="control-label d-block"><strong><?php echo e(trans('Status')); ?>

                                        :</strong></label>
                                <select class="form-control  w-100 edit_status"
                                        data-live-search="true" name="status"
                                        required="">
                                    <option disabled><?php echo app('translator')->get("Select Status"); ?></option>
                                    <option value="1"><?php echo e(trans('Active')); ?></option>
                                    <option value="0"><?php echo e(trans('Deactive')); ?></option>
                                </select>
                                <br>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e(trans($message)); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 form-group">
                                <br>
                                <a href="javascript:void(0)" class="btn btn-success btn-sm float-right generate"><i
                                        class="fa fa-plus-circle"></i> <?php echo e(trans('Add Field')); ?></a>

                            </div>
                        </div>

                        <div class="row addedField mt-3">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">
                            <?php echo e(trans('Close')); ?>

                        </button>
                        <button type="submit" class="btn btn-primary"> <?php echo e(trans('Update')); ?></button>
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

            $(".generate").on('click', function () {
                var form = `<div class="col-md-12">
                                 <div class="card border-primary">
                                        <div class="card-header  bg-primary p-2 d-flex justify-content-between">
                                            <h5 class="card-title text-white font-weight-bold"><?php echo e(trans('Field information')); ?></h3>
                                            <button  class="btn  btn-danger btn-sm delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Field Name')); ?></label>
                                                    <input name="field_name[]" class="form-control " type="text" value="" required
                                                           placeholder="<?php echo e(trans('Field Name')); ?>">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Form Type')); ?></label>
                                                    <select name="type[]" class="form-control  ">
                                                        <option value="text"><?php echo e(trans('Input Text')); ?></option>
                                                        <option value="textarea"><?php echo e(trans('Textarea')); ?></option>
                                                        <option value="file"><?php echo e(trans('File upload')); ?></option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Field Length')); ?></label>
                                                    <input name="field_length[]" class="form-control " type="number" min="2" value="" required
                                                           placeholder="<?php echo e(trans('Length')); ?>">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Field Length Type')); ?></label>
                                                    <select name="length_type[]" class="form-control">
                                                        <option value="max"><?php echo e(trans('Maximum Length')); ?></option>
                                                        <option value="digits"><?php echo e(trans('Fixed Length')); ?></option>
                                                    </select>
                                                </div>



                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Form Validation')); ?></label>
                                                    <select name="validation[]" class="form-control  ">
                                                        <option value="required"><?php echo e(trans('Required')); ?></option>
                                                        <option value="nullable"><?php echo e(trans('Optional')); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                            </div> `;

                $('.addedField').append(form)
            });

            $('select').select2({
                width: '100%'
            });


            $(document).on('click', '.editButton', function (e) {
                $('.addedField').html('')

                var obj = $(this).data()
                $('.edit_id').val(obj.id)
                $('.edit_name').val(obj.name).trigger('change');
                $(".edit_status").val(obj.status).trigger('change');
                $(".edit_service_id").val(obj.service_id).trigger('change');

                if (obj.services_form == 'null') {

                } else {
                    var objData = Object.entries(obj.services_form);

                    var form = '';
                    for (let i = 0; i < objData.length; i++) {
                        form += `<div class="col-md-12">

                                    <div class="card border-primary">

                                        <div class="card-header  bg-primary p-2 d-flex justify-content-between">
                                            <h5 class="card-title text-white font-weight-bold"><?php echo e(trans('Field information')); ?></h3>
                                            <button  class="btn  btn-danger btn-sm delete_desc" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Field Name')); ?></label>
                                                    <input name="field_name[]" class="form-control"
                                                     value="${objData[i][1].field_level}"
                                                     type="text" required
                                                           placeholder="<?php echo e(trans('Field Name')); ?>">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Form Type')); ?></label>
                                                    <select name="type[]" class="form-control  ">
                                                        <option value="text" ${(objData[i][1].type === 'text' ? 'selected="selected"' : '')}><?php echo e(trans('Input Text')); ?></option>
                                                        <option value="textarea" ${(objData[i][1].type === 'textarea' ? 'selected="selected"' : '')}><?php echo e(trans('Textarea')); ?></option>
                                                        <option value="file" ${(objData[i][1].type === 'file' ? 'selected="selected"' : '')}><?php echo e(trans('File upload')); ?></option>
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Field Length')); ?></label>
                                                    <input name="field_length[]" class="form-control " type="number" min="2" required
                                                    value="${objData[i][1].field_length}"
                                                           placeholder="<?php echo e(trans('Length')); ?>">
                                                </div>

                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Field Length Type')); ?></label>
                                                    <select name="length_type[]" class="form-control">
                                                        <option value="max"  ${(objData[i][1].length_type === 'max' ? 'selected="selected"' : '')}><?php echo e(trans('Maximum Length')); ?></option>
                                                        <option value="digits"  ${(objData[i][1].length_type === 'digits' ? 'selected="selected"' : '')}><?php echo e(trans('Fixed Length')); ?></option>
                                                    </select>
                                                </div>



                                                <div class="col-md-4 form-group">
                                                    <label><?php echo e(trans('Form Validation')); ?></label>
                                                    <select name="validation[]" class="form-control  ">
                                                            <option value="required" ${(objData[i][1].validation === 'required' ? 'selected="selected"' : '')}><?php echo e(trans('Required')); ?></option>
                                                            <option value="nullable" ${(objData[i][1].validation === 'nullable' ? 'selected="selected"' : '')}><?php echo e(trans('Optional')); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                            </div> `;
                    }
                    $('.addedField').append(form)

                }

            });

            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.card').parent().remove();
            });


        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/identify/services.blade.php ENDPATH**/ ?>