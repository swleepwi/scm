<?php $__env->startSection('content'); ?>

<!--Content Title -->
<div id="content-header">
    <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#" class="current">Wallboard</a>
    </div>
</div>
<!-- End Content Title -->

<!-- Start Content -->
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
        Welcome
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>