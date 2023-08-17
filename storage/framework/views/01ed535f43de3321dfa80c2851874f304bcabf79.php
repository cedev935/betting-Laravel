<header class="topbar" data-navbarbg="skin6">

    <nav class="navbar top-navbar navbar-expand-md">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <div class="navbar-brand">
                <a href="<?php echo e(url('/')); ?>">

                    <div class="logo-text">
                        <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png' )); ?>" alt="homepage"
                             class="dark-logo"/>
                        <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png' )); ?>" class="light-logo"
                             alt="homepage"/>
                    </div>
                </a>
            </div>

            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
               data-toggle="collapse" data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                <li class="nav-item dropdown" id="pushNotificationArea">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                       id="bell" role="button" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <span><i data-feather="bell" class="svg-icon"></i></span>
                        <span class="badge badge-primary notify-no rounded-circle" v-cloak>{{ items.length }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                        <ul class="list-style-none">
                            <li>
                                <div class="scrollable message-center notifications position-relative">
                                    <!-- Message -->
                                    <a v-for="(item, index) in items"
                                       @click.prevent="readAt(item.id, item.description.link)"
                                       href="javascript:void(0)"
                                       class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="btn btn-danger rounded-circle btn-circle">
                                            <i :class="item.description.icon" class="text-white"></i>
                                        </div>


                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <span class="font-12 text-nowrap d-block text-muted" v-cloak
                                                  v-html="item.description.text"></span>
                                            <span class="font-12 text-nowrap d-block text-muted" v-cloak>{{ item.formatted_date }}</span>
                                        </div>
                                    </a>


                                </div>
                            </li>
                            <li>
                                <a class="nav-link pt-3 text-center text-dark notification-clear-btn"
                                   href="javascript:void(0);"
                                   v-if="items.length > 0" @click.prevent="readAll">
                                    <strong><?php echo app('translator')->get('Clear all'); ?></strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>

                                <a class="nav-link pt-3 text-center text-dark" href="javascript:void(0);" v-else>
                                    <strong><?php echo app('translator')->get('No notification found'); ?></strong>
                                </a>

                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav float-right">
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <form class="navbar-search-form" onsubmit="return false;">
                            <div class="customize-input">
                                <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                       type="search" name="navbar_search" id="navbar_search" autocomplete="off"
                                       placeholder="Search" aria-label="Search">
                                <i class="form-control-icon" data-feather="search"></i>
                            </div>

                            <div id="navbar_search_result_area">
                                <ul class="navbar_search_result"></ul>
                            </div>
                        </form>
                    </a>
                </li>

                <!-- ============================================================== -->
                <!-- User profile and search
                .ti-menu:before {
                content: "\e68e";
                }
                -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">


                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo e(getFile(config('location.admin.path').Auth::guard('admin')->user()->image)); ?>"
                             alt="user"
                             class="rounded-circle width-40p">
                        <span class="ml-2 d-none d-lg-inline-block"><span class="text-dark"><?php echo app('translator')->get('Hello,'); ?></span> <span
                                class="text-dark"><?php echo e(Auth::guard('admin')->user()->username); ?></span> <i
                                data-feather="chevron-down"
                                class="svg-icon"></i></span>
                    </a>


                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">

                        <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                            <i class="svg-icon mr-2 ml-1 icon-user"></i>
                            <?php echo app('translator')->get('Profile'); ?>
                        </a>

                        <a class="dropdown-item" href="<?php echo e(route('admin.password')); ?>">
                            <i class="svg-icon mr-2 ml-1 icon-settings"></i>
                            <?php echo app('translator')->get('Password'); ?>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo e(route('admin.logout')); ?>"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                data-feather="power" class="svg-icon mr-2 ml-1"></i>
                            <?php echo e(__('Logout')); ?>

                        </a>
                        <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>

                    </div>
                </li>


            </ul>
        </div>

    </nav>
</header>

<?php /**PATH F:\work\betting\orca odd\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>