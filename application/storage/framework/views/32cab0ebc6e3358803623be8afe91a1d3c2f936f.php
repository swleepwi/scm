<!DOCTYPE html>
<html lang="en">
<head>
<title>The F Test</title>
<link rel="shortcut icon" href="<?php echo e(asset('public')); ?>/img/favicon.png" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/webfont/webfont.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/matrix-media.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/iziModal.css" />
<link href="<?php echo e(asset('public')); ?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
<script src="<?php echo e(asset('public')); ?>/js/jquery.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/jquery.ui.custom.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/bootbox/bootbox.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/bootbox/bootbox.locales.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/js/iziModal.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/js/jquery.bootstrap-growl.js"></script> 
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">&nbsp;</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome User</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
        <li class="divider"></li>
      </ul>
    </li>
    <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
  </ul>
</div>


<!--sidebar-menu-->
<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-fullscreen"></i>Full width</a>
    <ul>
      <li><a href="<?php echo e(url('/')); ?>"><i class="icon icon-user"></i> <span>Customer</span></a> </li>      
    </ul>
</div>
<!--End menu -->

<!-- Modal structure -->
<div id="modal-iframe"> <!-- data-iziModal-fullscreen="true"  data-iziModal-title="Welcome"  data-iziModal-subtitle="Subtitle"  data-iziModal-icon="icon-home" -->
  <!-- Modal content -->
</div>

<div id="content">
  <?php echo $__env->yieldContent('page_heading'); ?>       
  <?php echo $__env->yieldContent('add_button'); ?>         
  <?php echo $__env->yieldContent('content'); ?>
</div>

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12">&nbsp;</div>
</div>
<!--end-Footer-part-->

<script>
var public = "<?php echo e(asset('public')); ?>";
</script>
<script src="<?php echo e(asset('public')); ?>/js/bootstrap.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/matrix.js"></script>
<script>

<?php if(Session::has('notif')): ?> 
    $.bootstrapGrowl("<?php echo e(Session::get('notif')['notification']); ?>", {
        type: "<?php echo e(Session::get('notif')['type']); ?>"
    });
<?php endif; ?>   
</script>
</body>
</html>
