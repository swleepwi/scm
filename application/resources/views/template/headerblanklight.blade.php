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
<link rel="stylesheet" href="{{ asset('public') }}/css/matrix-newstyle.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/matrix-newmedia.css" />
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
<body style="background-color: #fff !important">


<div id="modal-iframe"> <!-- data-iziModal-fullscreen="true"  data-iziModal-title="Welcome"  data-iziModal-subtitle="Subtitle"  data-iziModal-icon="icon-home" -->
  <!-- Modal content -->
</div>

<div id="content_blank">
    @yield('content')
</div>


<script>
    var public = "{{ asset('public') }}";
</script>
<script src="{{ asset('public') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('public') }}/js/jquery-cookies.js"></script>  
<script src="{{ asset('public') }}/js/matrix.js"></script>
<script>
    @if(Session::has('notif')) 
        $.bootstrapGrowl("{{ Session::get('notif')['notification'] }}", {
            type: "{{ Session::get('notif')['type'] }}"
        });

        if(window.parent.$('.data-table').length > 0 ) {
            window.parent.$('.data-table').DataTable().ajax.reload();
        }  

        if(window.parent.$('#modal-iframe').length > 0) {
            setTimeout(function(){
                window.parent.$('#modal-iframe').iziModal('close'); 
            }, 800);
        }
    @endif 
    
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
</body>
</html>
