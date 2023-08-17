<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/bootstrap.min.css')); ?>"/>
    <?php echo $__env->yieldPushContent('css-lib'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/animate.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/owl.carousel.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/owl.theme.default.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/skitter.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/aos.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/jquery.fancybox.min.css')); ?>"/>

    <script src="<?php echo e(asset('assets/admin/js/fontawesome/fontawesomepro.js')); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/style.css')); ?>"/>

    <?php echo $__env->yieldPushContent('style'); ?>

</head>

<body <?php if(session()->get('dark-mode') == 'true'): ?> class="dark-mode" <?php endif; ?>>


<!-- navbar -->
<?php echo $__env->make($theme.'partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- wrapper -->
<div class="wrapper">
    <!-- leftbar -->
    <div class="leftbar" id="userPanelSideBar">
        <div class="px-2 d-lg-none">
            <button
                class="remove-class-btn light btn-custom"
                onclick="removeClass('userPanelSideBar')">
                <i class="fal fa-chevron-left"></i><?php echo app('translator')->get('Back'); ?>
            </button>
        </div>
        <div class="top profile">
            <h4 class="d-flex justify-content-between p-2">
                Profile
                <a href="<?php echo e(route('logout')); ?>"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                >
                    <button class="btn-custom light">
                        <i class="fal fa-sign-out-alt"></i>
                    </button>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                    <?php echo csrf_field(); ?>
                </form>
            </h4>
            <img src="<?php echo e(getFile(config('location.user.path').auth()->user()->image)); ?>" alt="..."/>
            <h5> <?php echo e(auth()->user()->username); ?></h5>
        </div>
        <ul class="main">
            <li>
                <a href="<?php echo e(route('user.home')); ?>" class="<?php echo e(menuActive('user.home')); ?>">
                    <i class="fal fa-home"></i>
                    <?php echo app('translator')->get('Dashboard'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.addFund')); ?>" class="<?php echo e(menuActive('user.addFund')); ?>">
                    <i class="fal fa-money-bill"></i>
                    <?php echo app('translator')->get('Make A Deposit'); ?>
                </a>
            </li>

            <li>
                <a href="<?php echo e(route('user.fund-history')); ?>" class="<?php echo e(menuActive('user.fund-history')); ?>">
                    <i class="fal fa-hand-holding-usd"></i>
                    <?php echo app('translator')->get('deposit history'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.transaction')); ?>" class="<?php echo e(menuActive('user.transaction')); ?>">
                    <i class="far fa-money-check-edit"></i>
                    <?php echo app('translator')->get('Transaction'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.betHistory')); ?>" class="<?php echo e(menuActive('user.betHistory')); ?>">
                    <i class="fal fa-history"></i>
                    <?php echo app('translator')->get('bet history'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.ticket.list')); ?>" class="<?php echo e(menuActive('user.ticket.list')); ?>">
                    <i class="fas fa-headset"></i>
                    <?php echo app('translator')->get('Support Tickets'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.payout.money')); ?>" class="<?php echo e(menuActive('user.payout.money')); ?>">
                    <i class="fas fa-envelope-open-dollar"></i>
                    <?php echo app('translator')->get('Withdraw Funds'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.payout.history')); ?>" class="<?php echo e(menuActive('user.payout.history')); ?>">
                    <i class="fal fa-wallet"></i>
                    <?php echo app('translator')->get('payouts history'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.referral')); ?>" class="<?php echo e(menuActive('user.referral')); ?>">
                    <i class="fal fa-user-friends"></i>
                    <?php echo app('translator')->get('invite friends'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.referral.bonus')); ?>" class="<?php echo e(menuActive('user.referral.bonus')); ?>">
                    <i class="fal fa-cog"></i>
                    <?php echo app('translator')->get('Referral Bonus'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.twostep.security')); ?>" class="<?php echo e(menuActive('user.twostep.security')); ?>">
                    <i class="fas fa-key"></i>
                    <?php echo app('translator')->get('2FA Security'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.profile')); ?>" class="<?php echo e(menuActive('user.profile')); ?>">
                    <i class="fal fa-user"></i>
                    <?php echo app('translator')->get('personal profile'); ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="content user-panel">
        <div class="d-flex justify-content-between">
            <div>
                <h4><?php echo $__env->yieldContent('title'); ?></h4>
            </div>
            <button
                class="btn-custom light toggle-user-panel-sidebar d-lg-none"
                onclick="toggleSidebar('userPanelSideBar')">
                <i class="fal fa-sliders-h"></i>
            </button>
        </div>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

</div>


<?php echo $__env->yieldPushContent('loadModal'); ?>


<script src="<?php echo e(asset($themeTrue . 'js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery-3.6.0.min.js')); ?>"></script>

<?php echo $__env->yieldPushContent('extra-js'); ?>


<script src="<?php echo e(asset($themeTrue . 'js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/masonry.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.counterup.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.easing.1.3.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.skitter.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/aos.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/script.js')); ?>"></script>


<script src="<?php echo e(asset('assets/global/js/notiflix-aio-2.7.0.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/pusher.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/vue.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/axios.min.js')); ?>"></script>

<?php echo $__env->make('plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(auth()->guard()->check()): ?>
    <?php if(config('basic.push_notification') == 1): ?>
    <script>
        'use strict';
        let pushNotificationArea = new Vue({
            el: "#pushNotificationArea",
            data: {
                items: [],
            },
            mounted() {
                this.getNotifications();
                this.pushNewItem();
            },
            methods: {
                getNotifications() {
                    let app = this;
                    axios.get("<?php echo e(route('user.push.notification.show')); ?>")
                        .then(function (res) {
                            app.items = res.data;
                        })
                },
                readAt(id, link) {
                    let app = this;
                    let url = "<?php echo e(route('user.push.notification.readAt', 0)); ?>";
                    url = url.replace(/.$/, id);
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.getNotifications();
                                if (link != '#') {
                                    window.location.href = link
                                }
                            }
                        })
                },
                readAll() {
                    let app = this;
                    let url = "<?php echo e(route('user.push.notification.readAll')); ?>";
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.items = [];
                            }
                        })
                },
                pushNewItem() {
                    let app = this;
                    // Pusher.logToConsole = true;
                    let pusher = new Pusher("<?php echo e(env('PUSHER_APP_KEY')); ?>", {
                        encrypted: true,
                        cluster: "<?php echo e(env('PUSHER_APP_CLUSTER')); ?>"
                    });
                    let channel = pusher.subscribe('user-notification.' + "<?php echo e(Auth::id()); ?>");
                    channel.bind('App\\Events\\UserNotification', function (data) {
                        app.items.unshift(data.message);
                    });
                    channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                        app.getNotifications();
                    });
                }
            }
        });
    </script>
    <?php endif; ?>
<?php endif; ?>
<?php echo $__env->yieldPushContent('script'); ?>


<?php echo $__env->make($theme.'partials.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    $(document).ready(function () {
        $(".language").find("select").change(function () {
            window.location.href = "<?php echo e(route('language')); ?>/" + $(this).val()
        })
    })

    const darkMode = () => {
        var $theme = document.body.classList.toggle("dark-mode");
        $.ajax({
            url: "<?php echo e(route('themeMode')); ?>/" + $theme,
            type: 'get',
            success: function (response) {
                console.log(response);
            }
        });
    };
</script>

</body>
</html>
<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/layouts/user.blade.php ENDPATH**/ ?>