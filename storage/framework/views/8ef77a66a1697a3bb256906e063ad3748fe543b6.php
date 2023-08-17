<!-- FOOTER SECTION -->
<?php if(!in_array(Request::route()->getName(),['home','category','tournament','match','login','register','register.sponsor','user.check','password.request'])): ?>

    <!-- FOOTER SECTION -->
    <footer class="footer-section" id="subscribe">
        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-box">
                            <a class="navbar-brand" href="javascript:void(0)">
                                <img class="img-fluid"
                                     src="<?php echo e(getFile(config('location.logoIcon.path') . 'logo1.png')); ?>"
                                     alt="..."/> </a>
                            <p>
                                <?php if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0]): ?>
                                    <?php echo app('translator')->get(strip_tags(@$contact->description->footer_short_details)); ?>
                                <?php endif; ?>
                            </p>
                            <?php if(isset($contactUs['contact-us'][0]) && $contact = $contactUs['contact-us'][0]): ?>
                                <ul>
                                    <li>
                                        <i class="fas fa-phone-alt"></i>
                                        <span><?php echo app('translator')->get(@$contact->description->phone); ?></span>
                                    </li>
                                    <li>
                                        <i class="far fa-envelope"></i>
                                        <span><?php echo app('translator')->get(@$contact->description->email); ?></span>
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo app('translator')->get(@$contact->description->email); ?></span>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 ps-lg-5">
                        <div class="footer-box">
                            <h5><?php echo app('translator')->get('Quick Links'); ?></h5>
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('about')); ?>"><?php echo app('translator')->get('About'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('blog')); ?>"><?php echo app('translator')->get('Blog'); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Contact'); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php if(isset($contentDetails['support'])): ?>
                        <div class="col-md-6 col-lg-3 ps-lg-5">
                            <div class="footer-box">
                                <h5><?php echo e(trans('OUR Services')); ?></h5>
                                <ul>
                                    <?php $__currentLoopData = $contentDetails['support']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <a href="<?php echo e(route('getLink', [slug($data->description->title), $data->content_id])); ?>"> <?php echo app('translator')->get($data->description->title); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-box">
                            <h5><?php echo app('translator')->get('subscribe newsletter'); ?></h5>
                            <form action="<?php echo e(route('subscribe')); ?>" method="post" class="mb-3">
                                <?php echo csrf_field(); ?>
                                <div class="input-group mb-3">
                                    <input
                                        type="email"
                                        name="email"
                                        autocomplete="off"
                                        class="form-control"
                                        placeholder="<?php echo e(trans('Enter Email')); ?>"
                                        aria-label="Subscribe Newsletter"
                                        aria-describedby="basic-addon"/>
                                    <button type="submit">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </form>
                            <?php if(isset($contentDetails['social'])): ?>
                                <div class="social-links">
                                    <?php $__currentLoopData = $contentDetails['social']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(@$data->content->contentMedia->description->link); ?>">
                                            <i class="<?php echo e(@$data->content->contentMedia->description->icon); ?>"></i>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="copyright">
                                <?php echo app('translator')->get('Copyright'); ?> &copy; <?php echo e(date('Y')); ?> <?php echo app('translator')->get($basic->site_title); ?> <?php echo app('translator')->get('All Rights Reserved'); ?>
                            </p>
                        </div>
                        <div class="col-md-6 language">
                            <?php $__empty_1 = true; $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <a href="<?php echo e(route('language',$lang->short_name)); ?>"><?php echo e(trans($lang->name)); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <style>
        .footer-section {
            background: url(<?php echo e(getFile(config('location.logo.path').'footer.jpg')); ?>);
            background-size: cover;
            background-position: center top;
        }
    </style>

<?php endif; ?>


<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/partials/footer.blade.php ENDPATH**/ ?>