@extends('template.headerblanklight')
@section('content')
<link rel="stylesheet" href="{{ asset('public') }}/css/uniform.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/select2.css" />
<script src="{{ asset('public') }}/plugins/barcode128/JsBarcode.all.min.js"></script>
<script src="{{ asset('public') }}/plugins/barcode128/barcode128.js"></script>
<style>
    body{
        width:100%; 
    }

    .labelPrint{
        width:100%;
        
    }
    .labelPrint tr td{
        border: solid 1px #000;
        padding:2px;
        text-align: center;
        font-weight:bold;
    }

    .fieldColumn{
        background-color: #ccc;
            font-weight:bold;
    }

    .valueColumn{
        font-weight:normal !important;
            font-weight:bold  !important;
    }
    .bigNumber{
        font-size: 20px;
        font-weight:bold  !important;
    }

    @media print {
        body{
            width:100%; 
        }

        .labelPrint{
            width:100%;
        }
        .labelPrint tr td{
            border: solid 1px #000;
            padding:2px;
            text-align: center;
            font-weight:bold;
        }

        .fieldColumn{
            background-color: #ccc;
            font-weight:bold;
        }

        .valueColumn{
            font-weight:normal !important;
            font-weight:bold  !important;
        }

        .bigNumber{
            font-size: 20px;
            font-weight:bold  !important;
        }

    }
</style>
<br/>


<table class="labelPrint">
    <tr>
        <td style='width:100px' class='fieldColumn'>P/O</td>
        <td colspan="3">PWI3-SUB-PO-200701-0001</td>
    </tr>
    <tr>
        <td class='fieldColumn'>BUYER PO</td>
        <td colspan="3">869945564</td>
    </tr>
    <tr>
        <td class='fieldColumn'>SUPPLIER</td>
        <td colspan="3" class='valueColumn'>PT. ANAM SINERGI INDONESIA</td>
    </tr>
    <tr>
        <td class='fieldColumn'>MODEL</td>
        <td colspan="3" class='valueColumn'>ADVANTAGE BASE</td>
    </tr>
    <tr>
        <td class='fieldColumn'>COMP</td>
        <td colspan="3" class='valueColumn'>KOMPONEN UPPER</td>
    </tr>
    <tr>
        <td class='fieldColumn'>GENDER</td>
        <td class='valueColumn' style="width:50px">M</td>
        <td class='fieldColumn'>ART_NO</td>
        <td class='valueColumn' style="width:70px">557654</td>
    </tr>
    <tr>
        <td class='fieldColumn'>COLOR</td>
        <td colspan="3" class='valueColumn'></td>
    </tr>
    <tr>
        <td style='height:80px' class='fieldColumn bigNumber'>12</td>
        <td class='valueColumn' class='fieldColumn bigNumber'>4</td>
        <td class='valueColumn' colspan='2'>
            <svg id="barcode1"></svg>
        </td>
    </tr>

</table>
<div style="page-break-after: always;"></div>
<script>
    JsBarcode("#barcode1", "10001051", {
        lineColor: "#000",
    });    
</script>


<table class="labelPrint">
    <tr>
        <td style='width:100px' class='fieldColumn'>P/O</td>
        <td colspan="3">PWI3-SUB-PO-200701-0001</td>
    </tr>
    <tr>
        <td class='fieldColumn'>ADIDAS PO</td>
        <td colspan="3">869945564</td>
    </tr>
    <tr>
        <td class='fieldColumn'>SUPPLIER</td>
        <td colspan="3" class='valueColumn'>PT. ANAM SINERGI INDONESIA</td>
    </tr>
    <tr>
        <td class='fieldColumn'>MODEL</td>
        <td colspan="3" class='valueColumn'>ADVANTAGE BASE</td>
    </tr>
    <tr>
        <td class='fieldColumn'>COMP</td>
        <td colspan="3" class='valueColumn'>KOMPONEN UPPER</td>
    </tr>
    <tr>
        <td class='fieldColumn'>GENDER</td>
        <td class='valueColumn' style="width:50px">M</td>
        <td class='fieldColumn'>ART_NO</td>
        <td class='valueColumn' style="width:70px">557654</td>
    </tr>
    <tr>
        <td class='fieldColumn'>COLOR</td>
        <td colspan="3" class='valueColumn'></td>
    </tr>
    <tr>
        <td style='height:80px' class='fieldColumn bigNumber'>12</td>
        <td class='valueColumn' class='fieldColumn bigNumber'>4</td>
        <td class='valueColumn' colspan='2'>
            <svg id="barcode2"></svg>
        </td>
    </tr>

</table>
<div style="page-break-after: always;"></div>
<script>
    JsBarcode("#barcode2", "10001052", {
        lineColor: "#000",
    });    
</script>




<table class="labelPrint">
    <tr>
        <td style='width:100px' class='fieldColumn'>P/O</td>
        <td colspan="3">PWI3-SUB-PO-200701-0001</td>
    </tr>
    <tr>
        <td class='fieldColumn'>ADIDAS PO</td>
        <td colspan="3">869945564</td>
    </tr>
    <tr>
        <td class='fieldColumn'>SUPPLIER</td>
        <td colspan="3" class='valueColumn'>PT. ANAM SINERGI INDONESIA</td>
    </tr>
    <tr>
        <td class='fieldColumn'>MODEL</td>
        <td colspan="3" class='valueColumn'>ADVANTAGE BASE</td>
    </tr>
    <tr>
        <td class='fieldColumn'>COMP</td>
        <td colspan="3" class='valueColumn'>KOMPONEN UPPER</td>
    </tr>
    <tr>
        <td class='fieldColumn'>GENDER</td>
        <td class='valueColumn' style="width:50px">M</td>
        <td class='fieldColumn'>ART_NO</td>
        <td class='valueColumn' style="width:70px">557654</td>
    </tr>
    <tr>
        <td class='fieldColumn'>COLOR</td>
        <td colspan="3" class='valueColumn'></td>
    </tr>
    <tr>
        <td style='height:80px' class='fieldColumn bigNumber'>12</td>
        <td class='valueColumn' class='fieldColumn bigNumber'>4</td>
        <td class='valueColumn' colspan='2'>
            <svg id="barcode3"></svg>
        </td>
    </tr>

</table>
<div style="page-break-after: always;"></div>
<script>
    JsBarcode("#barcode3", "10001053", {
        lineColor: "#000",
    });    
</script>



<script src="{{ asset('public') }}//js/select2.min.js"></script> 
<script src="{{ asset('public') }}//js/jquery.validate.js"></script>
<script>
    var method = "POST";
    var urlApi = "{{url('/')}}/api/customer";

    setTimeout(function(){
        print(document);
    }, 1000)
    
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
