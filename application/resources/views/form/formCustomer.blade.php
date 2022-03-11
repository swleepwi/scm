@extends('template.headerblanklight')
@section('content')
<link rel="stylesheet" href="{{ asset('public') }}/css/uniform.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/select2.css" />
<div class="row-fluid">
    <div class="span12">
    <div class="widget-box">

        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Customer</h5>
        </div>

        <div class="widget-content nopadding">
            <form class="form-horizontal" name="formEntry" id="formEntry" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="control-group">
                    <label class="control-label">Customer Name</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{{ isset($edit) ? $edit->name : old('name') }}"> *
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input type="email" name="email" id="email" value="{{ isset($edit) ? $edit->email : old('email') }}"> *
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
                        <input type="checkbox" name="is_married" id="is_married" value="1" @if(isset($edit) && $edit->is_married == "1") checked="checked" @endif>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Address</label>
                    <div class="controls">
                        <textarea name="address" id="address" style="height:100px; width:300px">{{ isset($edit) ? $edit->address : old('address') }}</textarea>                        
                    </div>
                </div>

                <hr>

                <div class="control-group">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input type="password" name="pass1" id="pass1" @if(isset($edit)) disabled placeholder="updating, password locked" @endif> *
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Retype Password</label>
                    <div class="controls">
                        <input type="password" name="pass2" id="pass2" @if(isset($edit)) disabled placeholder="updating, password locked" @endif> *
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
<script src="{{ asset('public') }}//js/select2.min.js"></script> 
<script src="{{ asset('public') }}//js/jquery.validate.js"></script>
<script>
    var method = "POST";
    var urlApi = "{{url('/')}}/api/customer";
    
    @if(isset($edit))
        method = "PUT";
        urlApi = "{{url('/')}}/api/customer/{{$edit->id}}";
    @endif

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
                            type: "success",offset: {from: 'top', amount: 250},align: 'center'
                        });   

                        window.parent.$('.data-table').DataTable().ajax.reload();
                        setTimeout(function(){
                            window.parent.$('#modal-iframe').iziModal('close'); 
                        }, 800);                        
                    }
                    else{
                        $.bootstrapGrowl(json.status.message, {
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
