<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/bootstrap.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/skitter.css')); ?>"/>
    <?php echo $__env->yieldPushContent('css-lib'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/animate.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/owl.carousel.min.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/owl.theme.default.min.css')); ?>"/>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/aos.css')); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/jquery.fancybox.min.css')); ?>"/>

    <script src="<?php echo e(asset('assets/admin/js/fontawesome/fontawesomepro.js')); ?>"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset($themeTrue . 'css/style.css')); ?>"/>


    <?php echo $__env->yieldPushContent('style'); ?>

</head>

<body <?php if(session()->get('dark-mode') == 'true'): ?> class="dark-mode" <?php endif; ?>>


<?php echo $__env->make($theme.'partials.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make($theme.'partials.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make($theme.'partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php echo $__env->yieldPushContent('extra-content'); ?>

<?php echo $__env->make($theme.'partials.modal-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?php echo e(asset($themeTrue . 'js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/masonry.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery-3.6.0.min.js')); ?>"></script>


<script src="<?php echo e(asset($themeTrue . 'js/jquery.skitter.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.easing.1.3.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/owl.carousel.min.js')); ?>"></script>

<?php echo $__env->yieldPushContent('extra-js'); ?>

<script src="<?php echo e(asset($themeTrue . 'js/jquery.waypoints.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.counterup.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/aos.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/jquery.fancybox.min.js')); ?>"></script>
<script src="<?php echo e(asset($themeTrue . 'js/script.js')); ?>"></script>


<script src="<?php echo e(asset('assets/global/js/pusher.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/vue.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/global/js/notiflix-aio-2.7.0.min.js')); ?>"></script>

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
    // dark mode
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
<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/layouts/app.blade.php ENDPATH**/ ?>