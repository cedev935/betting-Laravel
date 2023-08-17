<?php if(session()->has('success')): ?>
    <script>
        Notiflix.Notify.Success("<?php echo app('translator')->get(session('success')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('error')): ?>
    <script>
        Notiflix.Notify.Failure("<?php echo app('translator')->get(session('error')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('warning')): ?>
    <script>
        Notiflix.Notify.Warning("<?php echo app('translator')->get(session('warning')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('info')): ?>
    <script>
        Notiflix.Notify.Info("<?php echo app('translator')->get(session('info')); ?>");
    </script>
<?php endif; ?>


<?php /**PATH F:\work\betting\orca odd\resources\views/themes/betting/partials/notification.blade.php ENDPATH**/ ?>