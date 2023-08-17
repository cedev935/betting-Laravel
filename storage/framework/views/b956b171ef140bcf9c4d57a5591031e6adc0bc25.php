<style>
    .banner-section {
        padding: 174px 0 100px 0;
        background-image: url(<?php echo e(getFile(config('location.logo.path').'banner.jpg')); ?>);
        background-position: center;
        background-size: cover;
    }
</style>
<?php if(!in_array(Request::route()->getName(),['home','category','tournament','match','login','register','register.sponsor','user.check','password.request'])): ?>
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header-text text-center">
                        <h3><?php echo $__env->yieldContent('title'); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/partials/banner.blade.php ENDPATH**/ ?>