
<?php $__env->startSection('section'); ?>

<div id="loginbox">    
    <form method="POST" id="loginform" class="form-vertical" action="<?php echo e(url('/')); ?>/login/loginaction">
        <?php echo e(csrf_field()); ?>

        <div class="control-group normal_text"> <h3><img src="<?php echo e(asset('public')); ?>/img/logo_depan_system.png" alt="Logo" class="logo_front" /></h3></div>
        <div style="text-align: center" class="login_title">SCM SYSTEM</div>
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
				If you lost your ID or Password, Please contact <a href="mailto:hs.choi@pwi.co.id?cc=webadmin@pwi.co.id&subject=Lost ID or Password for SCM SYSTEM&body=Request :%0d%0aPT  :%0d%0aFirst Name :%0d%0aLast Name :%0d%0aPhone :%0d%0aMessage :%0d%0a%0d%0a%0d%0a (Example)%0d%0aRequest : Make Account / Lost ID / Lost Password%0d%0aPT : Parkland World Indonesia Jepara%0d%0aFirst Name : HS%0d%0aLast Name : CHOI%0d%0aPhone : 081311110000%0d%0aMessage : I want to make new account.%0d%0a%0d%0a">Administrator</a>
			</div>            
        </div>


    </form>            
</div>
<script src="<?php echo e(asset('public')); ?>/js/matrix.login.js"></script> 
<script src="<?php echo e(asset('public')); ?>//js/jquery.validate.js"></script>
<script>
    $(document).ready(function(){
        $("#username").focus();
    });

    $("#loginform").validate({
		rules:{
            username: {
                required: true,
            },
            password: {
                required: true,
            }
        },
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
            $(element).parents('.control-group').removeClass('success');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.headerblanklogin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>