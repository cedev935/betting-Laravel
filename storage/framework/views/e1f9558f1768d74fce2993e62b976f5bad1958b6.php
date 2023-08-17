<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('Manage Match'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.searchMatch')); ?>" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="search" value="<?php echo e(@request()->search); ?>" class="form-control"
                                       placeholder="<?php echo app('translator')->get('Team name'); ?>">
                            </div>
                        </div>

                        <div class="col-md-2 mb-2">
                            <div class="form-group">
                                <select class="form-control" name="searchCategory">
                                    <option value="" disabled selected><?php echo app('translator')->get('Select Category'); ?></option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"
                                                <?php if($item->id ==@request()->searchCategory): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <select class="form-control" name="searchTournament">
                                    <option value="" disabled selected><?php echo app('translator')->get('Select Tournament'); ?></option>
                                    <?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tournament->id); ?>"
                                                <?php if($tournament->id == @request()->searchTournament): ?> selected <?php endif; ?>>
                                            <?php echo e($tournament->name); ?>

                                            <span>[<?php echo e(optional($tournament->gameCategory)->name); ?>]</span>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control" name="date_time" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-2">
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

        <div class="card-header bg-transparent">
            <div class="d-flex flex-wrap align-items-center justify-content-between">

                <?php if(adminAccessRoute(config('role.manage_game.access.add'))): ?>
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary mr-2" data-target="#newModal"
                       data-toggle="modal">
                        <span><i class="fa fa-plus-circle"></i> <?php echo app('translator')->get('Add New'); ?></span>
                    </a>
                <?php endif; ?>

                <?php if(adminAccessRoute(config('role.manage_game.access.edit'))): ?>
                    <div class="dropdown text-right">
                        <button class="btn btn-sm  btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span><i class="fas fa-bars pr-2"></i> <?php echo app('translator')->get('Action'); ?></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_active"><?php echo app('translator')->get('Active'); ?></button>
                            <button class="dropdown-item" type="button" data-toggle="modal"
                                    data-target="#all_inactive"><?php echo app('translator')->get('DeActive'); ?></button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="categories-show-table table table-hover table-striped table-bordered" id="zero_config">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">
                            <input type="checkbox" class="form-check-input check-all tic-check" name="check-all"
                                   id="check-all">
                            <label for="check-all"></label>
                        </th>

                        <th scope="col" class="text-center"><?php echo app('translator')->get('SL No.'); ?></th>
                        <th scope="col" class="text-center"><?php echo app('translator')->get('Match'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Active Question'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Tournament'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Category'); ?></th>
                        <th scope="col"><?php echo app('translator')->get('Start Date'); ?></th>
                        <th scope="col" class="text-center"><?php echo app('translator')->get('Status'); ?></th>

                        <?php if(adminAccessRoute(config('role.manage_game.access.edit'))): ?>
                        <th scope="col" class="text-center"><?php echo app('translator')->get('Locker'); ?></th>
                            <th scope="col" class="text-center"><?php echo app('translator')->get('Action'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" id="chk-<?php echo e($item->id); ?>"
                                       class="form-check-input row-tic tic-check" name="check" value="<?php echo e($item->id); ?>"
                                       data-id="<?php echo e($item->id); ?>">
                                <label for="chk-<?php echo e($item->id); ?>"></label>
                            </td>

                            <td data-label="<?php echo app('translator')->get('SL No.'); ?>" class="text-center"><?php echo e($loop->index + 1); ?></td>
                            <td data-label="<?php echo app('translator')->get('Match'); ?>">

                                <div class="d-lg-flex d-block align-items-center ">
                                    <div class="mr-3 cursor-pointer" title="<?php echo e(optional($item->gameTeam1)->name); ?>">
                                        <small
                                            class="text-dark font-weight-bold"><?php echo e(shortName(optional($item->gameTeam1)->name)); ?></small>
                                    </div>
                                    <div class="mr-2 cursor-pointer" title="<?php echo e(optional($item->gameTeam1)->name); ?>">
                                        <img
                                            src="<?php echo e(getFile(config('location.team.path') . optional($item->gameTeam1)->image)); ?>"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <small class="font-italic mb-0 font-16 "><?php echo app('translator')->get('vs'); ?></small>

                                    <div class="mr-3 ml-2 cursor-pointer" title="<?php echo e(optional($item->gameTeam2)->name); ?>">
                                        <img
                                            src="<?php echo e(getFile(config('location.team.path') . optional($item->gameTeam2)->image)); ?>"
                                            alt="user" class="rounded-circle" width="25" height="25">
                                    </div>
                                    <div class="cursor-pointer" title="<?php echo e(optional($item->gameTeam2)->name); ?>">
                                        <small
                                            class="text-dark font-weight-bold"><?php echo e(shortName(optional($item->gameTeam2)->name)); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Active Question'); ?>">
                                <span class="badge badge-pill badge-success"><?php echo e($item->active_questions_count); ?></span>
                            </td>
                            <td data-label="<?php echo app('translator')->get('Tournament'); ?>" class="text-dark">
                                <?php echo e(optional($item->gameTournament)->name); ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('Category'); ?>" class="text-dark">
                                <?php echo optional($item->gameCategory)->icon; ?>

                                <?php echo e(optional($item->gameCategory)->name); ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('Start Date'); ?>">
                                <?php echo e(dateTime($item->start_date, 'd M, Y')); ?>

                            </td>
                            <td data-label="<?php echo app('translator')->get('Status'); ?>" class="text-lg-center text-right">
                                <?php if($item->status == 0): ?>
                                    <span class="badge badge-light">
                               <i class="fa fa-circle text-danger danger font-12"></i> <?php echo app('translator')->get('Deactive'); ?> </span>
                                <?php else: ?>
                                    <span class="badge badge-light">
                               <i class="fa fa-circle text-success success font-12"></i> <?php echo app('translator')->get('Active'); ?></span>
                                <?php endif; ?>
                            </td>

                            <?php if(adminAccessRoute(config('role.manage_game.access.edit'))): ?>
                            <td data-label="<?php echo app('translator')->get('Locker'); ?>" class="text-lg-center text-right">

                                <a class="btn btn-sm  btn-outline-<?php echo e(($item->is_unlock == 1) ? 'primary':'dark'); ?>"
                                   href="<?php echo e(route('admin.match.locker')); ?>"
                                   onclick="event.preventDefault();
                                       document.getElementById('locker<?php echo e($item->id); ?>').submit();">
                                    <?php if($item->is_unlock == 1): ?>
                                        <i class="fa fa-unlock"></i>  <?php echo e(__('Unlock Now')); ?>

                                    <?php else: ?>
                                        <i class="fa fa-lock"></i> <?php echo e(__('Lock Now')); ?>

                                    <?php endif; ?>

                                </a>
                                <form id="locker<?php echo e($item->id); ?>" action="<?php echo e(route('admin.match.locker')); ?>"
                                      method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                    <input type="text" name="match_id" value="<?php echo e($item->id); ?>">
                                </form>

                            </td>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">

                                    <div class="dropdown show dropup text-lg-center text-right">
                                        <a class="dropdown-toggle  p-3" href="#" id="dropdownMenuLink"
                                           data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item editBtn" href="javascript:void(0)"
                                               data-match="<?php echo e($item); ?>"
                                               data-action="<?php echo e(route('admin.updateMatch', $item->id)); ?>">
                                                <i class="fa fa-edit text-warning pr-2"
                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Edit'); ?>
                                            </a>


                                            <a class="dropdown-item notiflix-confirm"
                                               href="<?php echo e(route('admin.addQuestion',$item->id)); ?>">
                                                <i class="fa fa-plus-circle text-success pr-2"
                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Make Question'); ?>
                                            </a>
                                            <a class="dropdown-item notiflix-confirm"
                                               href="<?php echo e(route('admin.infoMatch',$item->id)); ?>">
                                                <i class="fa fa-list-alt text-primary pr-2"
                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Question List'); ?>
                                            </a>

                                            <a class="dropdown-item notiflix-confirm" href="javascript:void(0)"
                                               data-target="#delete-modal"
                                               data-route="<?php echo e(route('admin.deleteMatch',$item->id)); ?>"
                                               data-toggle="modal">
                                                <i class="fa fa-trash-alt text-danger pr-2"
                                                   aria-hidden="true"></i> <?php echo app('translator')->get('Delete'); ?>
                                            </a>
                                        </div>
                                    </div>

                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e($matches->appends(@$search)->links('partials.pagination')); ?>

            </div>
        </div>
    </div>

    <!-- All Active Modal -->
    <div class="modal fade" id="all_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Active Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to active the Match"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary active-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- All Inactive Modal -->
    <div class="modal fade" id="all_inactive" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('DeActive Confirmation'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get("Are you really want to Deactive the Match"); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><span><?php echo app('translator')->get('No'); ?></span></button>
                    <form action="" method="post">
                        <?php echo csrf_field(); ?>
                        <a href="" class="btn btn-primary inactive-yes"><span><?php echo app('translator')->get('Yes'); ?></span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div id="newModal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Add Match'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.storeMatch')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Game Category'); ?> <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control js-example-basic-single" name="category" id="category">
                                        <option value="" selected disabled><?php echo app('translator')->get('Select Game Category'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(old('category', $item->id)); ?>">
                                                <?php echo e($item->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['category'];
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
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Game Tournament'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control " name="tournament">

                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['tournament'];
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Match Name'); ?> <span class="text-muted font-italic">(<?php echo app('translator')->get('optional'); ?>)</span></label>
                                    <input type="text" class="form-control" name="name">
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
                            </div>
                        </div>

                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Team 01'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control team1" data-live-search="true" name="team1">

                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['team1'];
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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Team 02'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="team2">
                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['team2'];
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
                            </div>
                        </div>
                        <div class="row  mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Start Date'); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="datepicker"/>
                                    <?php $__errorArgs = ['start_date'];
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('End Date'); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="datepicker"/>
                                    <?php $__errorArgs = ['end_date'];
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
                        </div>
                        <div class="form-group ">
                            <label for="status" class="text-dark"> <?php echo app('translator')->get('Status'); ?> </label>
                            <input data-toggle="toggle" id="status" data-onstyle="success" data-offstyle="info"
                                   data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" name="status">
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Save'); ?></button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="editModal" class="modal fade show" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h5 class="modal-title"><?php echo app('translator')->get('Edit Match'); ?></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Game Category'); ?> <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control js-example-basic-single editCategory" name="category"
                                            id="editCategory">
                                        <option value="" selected disabled><?php echo app('translator')->get('Select Game Category'); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(old('category', $item->id)); ?>">
                                                <?php echo e($item->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['category'];
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
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Game Tournament'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control js-example-basic-single" name="tournament"
                                            id="editTournament">
                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['tournament'];
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Match Name'); ?> <span class="text-muted font-italic">(<?php echo app('translator')->get('optional'); ?>)</span></label>
                                    <input type="text" class="form-control" name="name">
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
                            </div>
                        </div>

                        <div class="row  mb-3">
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Team 01'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control team1" data-live-search="true" name="team1"
                                            id="editTeam1">

                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['team1'];
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
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Team 02'); ?> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="team2" id="editTeam2">
                                    </select>
                                    <div class="mt-3">
                                        <?php $__errorArgs = ['team2'];
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
                            </div>
                        </div>
                        <div class="row  mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('Start Date'); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="start_date" id="editStartDate"/>
                                    <?php $__errorArgs = ['start_date'];
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark"><?php echo app('translator')->get('End Date'); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control end_date" name="end_date" id="editEndDate"/>
                                    <?php $__errorArgs = ['end_date'];
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
                        </div>
                        <div class="form-group ">
                            <label for="status" class="text-dark"> <?php echo app('translator')->get('Status'); ?> </label>
                            <input data-toggle="toggle" id="edit-status" data-onstyle="success" data-offstyle="info"
                                   data-on="Active" data-off="Deactive" data-width="100%" type="checkbox" name="status">
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Update'); ?></button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="primary-header-modalLabel"><?php echo app('translator')->get('Delete Confirmation'); ?>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Are you sure to delete this?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <form action="" method="post" class="deleteRoute">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('delete'); ?>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Yes'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('style'); ?>
    <script src="<?php echo e(asset('assets/admin/js/fontawesome/fontawesomepro.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('js'); ?>

    <script src="<?php echo e(asset('assets/admin/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/moment.js')); ?>"></script>


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
        'use strict'
        $(document).ready(function () {
            $('select').select2();
        });


        $('select[name=team1]').append(` <option value="" selected disabled><?php echo app('translator')->get('Select Team'); ?></option>`);
        $('select[name=team2]').append(` <option value="" selected disabled><?php echo app('translator')->get('Select Team'); ?></option>`);
        $('select[name=tournament]').append(` <option value="" selected disabled><?php echo app('translator')->get('Select a tournament'); ?></option>`);


        var categoryId = null, tournament_id = null, match_team1_id = null, match_team2_id = null;
        $(document).on('change', "#category", function () {
            categoryId = $(this).val();
            getTeamByCategory(categoryId);
        });

        $(document).on('change', ".editCategory", function () {
            categoryId = $(this).val();
            getTeamByCategory(categoryId);
        });

        $(document).on('click', '.editBtn', function () {
            var modal = $('#editModal');

            var match = $(this).data('match');

            $('.id-get').text(match.id)

            modal.find('input[name=name]').val(match.name);


            match_team1_id = match.team1_id
            match_team2_id = match.team2_id
            tournament_id = match.tournament_id
            $('#editStartDate').val(match.start_date);
            $('#editEndDate').val(match.end_date);
            getTeamByCategory(match.category_id, match_team1_id, match_team2_id)
            $('#editCategory').val("" + match.category_id).select2();

            modal.find('form').attr('action', $(this).data('action'));
            if (match.status == 1) {
                $('#edit-status').bootstrapToggle('on')
            } else {
                $('#edit-status').bootstrapToggle('off')
            }
            modal.modal('show');
        });


        function getTeamByCategory(categoryId = 0, match_team1_id = null, match_team2_id = null) {


            if (categoryId == 0) {
                return 0;
            }
            $('select[name=team1]').empty();
            $('select[name=team2]').empty();
            $('select[name=tournament]').empty();
            $.ajax({
                url: "<?php echo e(route('admin.ajax.listMatch')); ?>",
                type: 'POST',
                data: {
                    categoryId
                },
                success(data) {

                    $.each(data.team, function (key, item) {
                        $('select[name=team1]').append(`<option value="${item.id}" ${(item.status == '0') ? 'disabled' : ''}  ${(match_team1_id == item.id) ? 'selected' : ''}>${item.name}</option`);
                        $('select[name=team2]').append(`<option value="${item.id}" ${(item.status == '0') ? 'disabled' : ''} ${(match_team2_id == item.id) ? 'selected' : ''}>${item.name}</option`);
                    });

                    $.each(data.tournament, function (key, item) {
                        $('select[name=tournament]').append(`<option value="${item.id}" ${(tournament_id == item.id) ? 'selected' : ''}>${item.name}</option`);
                    });
                },
                complete: function () {
                },
                error(err) {
                    var errors = err.responseJSON;
                    for (var obj in errors) {
                        $('.errors').text(`${errors[obj]}`)
                    }

                }
            });

        }


        $(document).on('shown.bs.modal', '#editModal', function (e) {
            $(document).off('focusin.modal');
        });
        $(document).on('shown.bs.modal', '#newModal', function (e) {
            $(document).off('focusin.modal');
        });

        $(document).on('click', '.notiflix-confirm', function () {
            var route = $(this).data('route');
            $('.deleteRoute').attr('action', route)
        })

        $(document).on('click', '#check-all', function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $(document).on('change', ".row-tic", function () {
            let length = $(this).length;
            let checkedLength = $(".row-tic:checked").length;
            if (length == checkedLength) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
        });

        //multiple active
        $(document).on('click', '.active-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });

            var strIds = allVals;

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "<?php echo e(route('admin.match-active')); ?>",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                },
            });
        });

        //multiple deactive
        $(document).on('click', '.inactive-yes', function (e) {
            e.preventDefault();
            var allVals = [];
            $(".row-tic:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            var strIds = allVals;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: "<?php echo e(route('admin.match-deactive')); ?>",
                data: {strIds: strIds},
                datatType: 'json',
                type: "post",
                success: function (data) {
                    location.reload();

                }
            });
        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\work\betting\orca odd\resources\views/admin/match/list.blade.php ENDPATH**/ ?>