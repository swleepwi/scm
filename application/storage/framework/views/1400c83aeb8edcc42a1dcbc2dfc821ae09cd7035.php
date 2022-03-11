<!DOCTYPE html>
<html lang="en">
    
    <head>
        <title>Parkland - SCM System</title>
        <link rel="shortcut icon" href="<?php echo e(asset('public')); ?>/img/favicon.png" /><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/matrix-login.css" />
        <link href="<?php echo e(asset('public')); ?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo e(asset('public')); ?>/webfont/webfont.css" />
        <script src="<?php echo e(asset('public')); ?>/js/jquery.min.js"></script> 
        <script src="<?php echo e(asset('public')); ?>/js/jquery.ui.custom.js"></script>
        <script src="<?php echo e(asset('public')); ?>/plugins/bootbox/bootbox.min.js"></script>
        <script src="<?php echo e(asset('public')); ?>/plugins/bootbox/bootbox.locales.min.js"></script>
        <script src="<?php echo e(asset('public')); ?>/js/iziModal.min.js"></script>
        <script src="<?php echo e(asset('public')); ?>/js/jquery.bootstrap-growl.js"></script> 
    </head>

    <body>
        
        <div id="content">
            <?php echo $__env->yieldContent('section'); ?>
        </div>
        
        <script>
            
            
            <?php if(Session::has('notif')): ?> 
                $.bootstrapGrowl("<?php echo e(Session::get('notif')['notification']); ?>", {
                    type: "<?php echo e(Session::get('notif')['type']); ?>"
                });
            <?php endif; ?>   
        </script>
    </body>
</html>
