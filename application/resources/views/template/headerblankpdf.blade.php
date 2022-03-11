<!DOCTYPE html>
<html lang="en">
<head>
<title>Parkland - SCM System</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap.min.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap2.min.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="{{ asset('public') }}/webfont/webfont.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/matrix-style.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/matrix-media.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/iziModal.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/jquery-ui.css" />
<link href="{{ asset('public') }}/font-awesome/css/font-awesome.css" rel="stylesheet" />
<script src="{{ asset('public') }}/js/jquery.min.js"></script> 
<script src="{{ asset('public') }}/js/jquery.ui.js"></script>
<script src="{{ asset('public') }}/plugins/bootbox/bootbox.min.js"></script>
<script src="{{ asset('public') }}/plugins/bootbox/bootbox.locales.min.js"></script>
<script src="{{ asset('public') }}/js/iziModal.min.js"></script>
<script src="{{ asset('public') }}/js/jquery-mask.js"></script> 
<script src="{{ asset('public') }}/js/jquery.bootstrap-growl.js"></script> 
<script src="{{ asset('public') }}/js/moment.js"></script> 
<script src="{{ asset('public') }}/js/moment.locale.js"></script> 
<script src="{{ asset('public') }}/js/qrcode.min.js"></script> 
<script>
    var baseUrl = "{{url('/')}}";

    $(document).ready(function() {
       
    });
</script>

<style>
.widget-box {
	margin-top: 16px !important;
}
</style>
</head>
<body style="background-color: #fff !important; font-size:12px !important;">
    <div id="letter_header" style="width:100%; display:flex; position:relative;">
        <div style="width:25%; float:left;  position:relative">
            <br/>
            <img src="{{ asset('public') }}/company/{{session("erp_company")->logo}}" style="height:40px; width:auto">
        </div>
        <div style="width:75%; text-align:center; float:right; padding-top:20px;  position:relative">
            <span style="text-transform: uppercase; font-size: 14px; font-weight: bold; ">{{session("erp_company")->name}}</span>
            <div style="position: relative; margin: auto; left:0; right:0; text-align:center; font-size:11px; line-height:15px;">
                    {!! session("erp_company")->address !!}
                    {!! session("erp_company")->city !!} {!! session("erp_company")->postal_code !!}, {!! session("erp_company")->country !!}<br>
                    Phone: {!! session("erp_company")->phone !!}, Fax: {!! session("erp_company")->fax !!}, Email: {!! session("erp_company")->email !!}
            </div>
            
        </div>
        
    </div>
    <br/><br/><br/><br/>
    <hr style="border-top: solid 1px #666; border-bottom: solid 2px #666; height:1px; margin-botom:10px !important;">
    @yield('content')
    
<script>
    var public = "{{ asset('public') }}";
    function tableToExcel(table, name, filename) {
            let uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
            base64 = function(s) { return window.btoa(decodeURIComponent(encodeURIComponent(s))) }, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })}

            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

            var link = document.createElement('a');
            link.download = filename;
            link.href = uri + base64(format(template, ctx));
            link.click();
    }
</script>
<script src="{{ asset('public') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('public') }}/js/jquery-cookies.js"></script>  
<script src="{{ asset('public') }}/js/matrix.js"></script>

</body>
</html>
