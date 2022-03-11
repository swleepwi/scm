<?php $__env->startSection('section'); ?>

<div id="loginbox">    
    <form method="POST" id="loginform" class="form-vertical" action="<?php echo e(url('/')); ?>/login/loginaction">
        <?php echo e(csrf_field()); ?>

        <div class="control-group normal_text"> <h3><img src="<?php echo e(asset('public')); ?>/img/logofront.png" alt="Logo" class="logo_front" /></h3></div>
        
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">                            
                    <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" placeholder="Username" id="username" name="username" />
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-lock"></i></span><input type="password" placeholder="Password" id="password" name="password" />
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <button class="btn btn-info login_btn" type="submit">LOGIN</button>
                </div>                
            </div>            
        </div>

        <div class="control-group">
            <br>
            <div class="controls copy_text" align="center">
                Please contact Administrator
                <br/>if you lost your password
            </div>            
        </div>


    </form>            
</div>
<script src="<?php echo e(asset('public')); ?>/js/matrix.login.js"></script> 
<script>
    $(document).ready(function(){
        $("#username").focus();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.headerblanklogin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>