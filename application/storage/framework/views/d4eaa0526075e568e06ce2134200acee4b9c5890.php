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
        <meta http-equiv="refresh" content="3600">
    </head>

    <body>
        
        <div id="content">
            <?php echo $__env->yieldContent('section'); ?>
        </div>
        
        <script src="<?php echo e(asset('public')); ?>/js/jquery.idle.js"></script>
        <script>
            
            $(document).idle({
                onIdle: function(){
                    window.location="<?php echo e(url('/')); ?>";
                    //alert('You have no activity more than 5 minutes ago, the system will logout');
                },
                idle: 300000
            });

            <?php if(Session::has('notif')): ?> 
                $.bootstrapGrowl("<?php echo e(Session::get('notif')['notification']); ?>", {
                    type: "<?php echo e(Session::get('notif')['type']); ?>",offset: {from: 'top', amount: 250},align: 'center'
                });
            <?php endif; ?>   
        </script>
    </body>
</html>
