@extends('template.header')
@section('page_heading')

<style>
.data-table {
  table-layout:fixed;
}
.data-table td {
  word-wrap: break-word;
}
.data-table td {
  white-space:inherit;
}

.data-table tbody tr:hover {
  background-color: #ccc;
}
 
.data-table tbody tr:hover > .sorting_1 {
  background-color: #ccc;
}

.hightLight{
 background-color: #ccc;
}
.control-group {
    margin-bottom: 0px !important;
}
#detailInsert{
	opacity: 1;
	position: relative;
}
#blocker{
	position: absolute;
	display: none;
	width:100%;
	height:100%;
	top: 0;	
    z-index: 999;
}
</style>
<!--Content Title -->
<div id="content-header">
    <div id="breadcrumb">
        <a href="#"  class="tip-bottom content_title">Change Password</a>
    </div>
</div>
<!-- End Content Title -->
@endsection

@section('content')
	
<div class="container-fluid">
	<form  name="formEntry" id="formEntry"  novalidate="novalidate" style="	padding-top: 20px !important">
			{{ csrf_field() }}
		<div class="row-fluid">
			<div class="span12">
			<div class="widget-box">


				<div class="widget-content">
					
					<div style="display: inline-block">
						<table>
							<tr>
								<td>
									<label class="control-label">Username *</label>
									<div class="controls">
										<input type="text" name="username" id="username" style="width:150px; margin-right:30px">
									</div>
								</td>
								<td>
									<label class="control-label">Old Password *</label>
									<div class="controls">
										<input type="password" name="old_password" id="old_password" style="width:150px; margin-right:30px">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<label class="control-label">New Password *</label>
									<div class="controls">
										<input type="password" name="new_password1" id="new_password1" style="width:150px; margin-right:30px">
									</div>

								</td>
								<td>
									<label class="control-label">Retype New Password *</label>
									<div class="controls">
										<input type="password" name="new_password" id="new_password" style="width:150px; margin-right:30px">
									</div>

								</td>
							</tr>
						</table>


						
					</div>		
					<div class="control-group">
						<button type="submit" value="Save" class="btn-small search_btn"><i class="icon-save"></i> Change Password</button>
					</div>		
					
				</div>
				
			</div>
			</div>
		</div>
	</form>
</div>


	

<!-- End Content -->
<script src="{{ asset('public') }}//js/select2.min.js"></script> 
<script src="{{ asset('public') }}//js/jquery.validate.js"></script>
<script type="text/javascript" src="{{ asset('public') }}/js/jquery.dataTables.js"></script>

<script>
	

	var obj = new Object();
	obj.SelectedPO = "0";
	obj.y = 0;
	obj.w = -1;

	$("#formEntry").validate({
		rules:{
			username: {
                required: true
            },
            old_password: {
                required: true
            },
            new_password1: "required",
            new_password: {
                equalTo: "#new_password1",
                required: true
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
				type: "POST",
				url: "{{ url('/') }}/utility/changpasswordaction",
				data: $(form).serialize(),
				success: function (json) 
				{

					if(json.data.SUCCESS_YN == "Y")
					{
						$.bootstrapGrowl("Success, message: "+json.data.RESULT_MSG, {
							type: "success",offset: {from: 'top', amount: 250},align: 'center'
						}); 

                        $("#username").val('');
                        $("#old_password").val('');
                        $("#new_password1").val('');
                        $("#new_password").val('');
					}
					else{
						$.bootstrapGrowl("Failed, message: "+json.data.RESULT_MSG, {
							type: "error",offset: {from: 'top', amount: 250},align: 'center'
						});
					}
				}
			});
			return false; 
        }
	});
	
	
</script> 
@endsection