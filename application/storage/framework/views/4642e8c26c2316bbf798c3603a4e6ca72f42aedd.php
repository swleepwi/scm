<?php $__env->startSection('section'); ?>

<div class="tile_menu">
    <p align="center">
    <br>
    <img src="<?php echo e(asset('public')); ?>/img/logofront.png" alt="Logo" class="logo_front" />
        <ul>
            <?php $__currentLoopData = session("erp_module"); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>            
                <?php if($module->module->is_ess == 0): ?>
                <li  onclick="window.location='<?php echo e(url('/')); ?><?php echo e($module->module->url); ?>'">
                    <i class="icon <?php echo e($module->module->fa_icon); ?>"></i>
                    <div class="menu_text" style="text-transform:uppercase"><?php echo e($module->module->name); ?></div>
                </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <br>
        <div align="right" style="padding-right:45px;">
            <button class="btn btn-mini btn-danger" onclick="logoutApp()"><i class="icon icon-key"></i> &nbsp; Logout</button>
        </div>
        <div class="controls copy_text" align="center">
            <br>
            &copy; 2019 Cakra Manunggal Pratama, 
            licensed to Djakarta Lloyd
        </div>  
    </p>
<div>
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo e(csrf_field()); ?>

</form>
<script src="<?php echo e(asset('public')); ?>/js/bootstrap.min.js"></script> 
<script>
function logoutApp(){
    bootbox.confirm({
        title: "Confirmation Popup",
        message: "Are you sure want to logout?",
        buttons: {
            cancel: {
                label: '<i class="icon-off"></i> Cancel',
                className: 'btn-mini'
            },
            confirm: {
                label: '<i class="icon-check"></i> Confirm',
                className: 'btn-mini btn-inverse'
            }
        },
        callback: function (result) {
            if(result) {
        event.preventDefault();
        document.getElementById('logout-form').submit();	
            }			
            
        }
    });
}  
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.headerblanklogin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>