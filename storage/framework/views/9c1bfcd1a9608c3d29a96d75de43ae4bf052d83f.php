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

<script>

    $(document).ready(function () {
        $('.notiflix-confirm').on('click', function () {

        })
    })
</script>
<?php /**PATH F:\work\betting\orca odd\resources\views/admin/layouts/notification.blade.php ENDPATH**/ ?>