<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/uniform.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/select2.css" />
<div class="row-fluid">
    <div class="span12">
    <div class="widget-box">

        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Customer</h5>
        </div>

        <div class="widget-content nopadding">
            <form class="form-horizontal" name="formEntry" id="formEntry" novalidate="novalidate">
                <?php echo e(csrf_field()); ?>

                <div class="control-group">
                    <label class="control-label">Customer Name</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="<?php echo e(isset($edit) ? $edit->name : old('name')); ?>"> *
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input type="email" name="email" id="email" value="<?php echo e(isset($edit) ? $edit->email : old('email')); ?>"> *
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Gender</label>
                    <div class="controls">
                        <select name="gender" id="gender" style="width:100px">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Married</label>
                    <div class="controls">
                        <input type="checkbox" name="is_married" id="is_married" value="1" <?php if(isset($edit) && $edit->is_married == "1"): ?> checked="checked" <?php endif; ?>>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Address</label>
                    <div class="controls">
                        <textarea name="address" id="address" style="height:100px; width:300px"><?php echo e(isset($edit) ? $edit->address : old('address')); ?></textarea>                        
                    </div>
                </div>

                <hr>

                <div class="control-group">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input type="password" name="pass1" id="pass1" <?php if(isset($edit)): ?> disabled placeholder="updating, password locked" <?php endif; ?>> *
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Retype Password</label>
                    <div class="controls">
                        <input type="password" name="pass2" id="pass2" <?php if(isset($edit)): ?> disabled placeholder="updating, password locked" <?php endif; ?>> *
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" value="Save" class="btn-small btn-inverse"><i class="icon-save"></i> Save</button>
                </div>
            </form>
        </div>
        
    </div>
    </div>
</div>
<script src="<?php echo e(asset('public')); ?>//js/select2.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>//js/jquery.validate.js"></script>
<script>
    var method = "POST";
    var urlApi = "<?php echo e(url('/')); ?>/api/customer";
    
    <?php if(isset($edit)): ?>
        method = "PUT";
        urlApi = "<?php echo e(url('/')); ?>/api/customer/<?php echo e($edit->id); ?>";
    <?php endif; ?>

    $("#formEntry").validate({
		rules:{
            name: {
                required: true,
                minlength: 4
            },
            email: {
                required: true,
                email: true
            },
            pass1: {
                required: true,
                minlength: 6
            },
            pass2: {
                equalTo: "#pass1",
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
        },
        submitHandler: function (form) {
             $.ajax({
                 type: method,
                 url: urlApi,
                 data: $(form).serialize(),
                 success: function (json) {
                    if(json.status.code == "200")
                    {
                        $.bootstrapGrowl(json.status.message, {
                            type: "success"
                        });   

                        window.parent.$('.data-table').DataTable().ajax.reload();
                        setTimeout(function(){
                            window.parent.$('#modal-iframe').iziModal('close'); 
                        }, 800);                        
                    }
                    else{
                        $.bootstrapGrowl(json.status.message, {
                            type: "error"
                        });
                    }
                 }
             });
             return false; 
        }
    });
    
</script> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.headerblanklight', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>