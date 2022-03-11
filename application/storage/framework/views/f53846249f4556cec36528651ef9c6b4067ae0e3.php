<!DOCTYPE html>
<html lang="en">
<head>
<title>Parkland - SCM System</title>
<link rel="shortcut icon" href="<?php echo e(asset('public')); ?>/img/favicon.png" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/webfont/webfont.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/matrix-newstyle.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/matrix-newmedia.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/iziModal.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/menu_custom.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/plugins/metismenu/metisMenu.css" />

<link href="<?php echo e(asset('public')); ?>/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/plugins/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/plugins/sidebarmenu/dist/sidebar-menu.css">
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/sidebar-menu_added.css">

<script src="<?php echo e(asset('public')); ?>/js/jquery.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/jquery.ui.custom.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/bootbox/bootbox.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/bootbox/bootbox.locales.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/js/iziModal.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/js/jquery.bootstrap-growl.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/jquery-mask.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/jquery-cookies.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/moment.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/moment.locale.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/ddacordion.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/jquery.injectCSS.js"></script> 
</head>
<body class="animate-menu-push animate-menu-push-right">

<!--Header-part-->
<div id="header">
  <div class="wide_div">
      <a href="javascript:void()" onclick="menuTrigger()" class="menu_toggle"><i class="fa fa-bars"></i></a>
      <div id="user-nav" class="navbar navbar-inverse title_app">
        SCM SYSTEM
      </div>
  </div>
  <div class="wide_div">
    <div id="user-nav" class="navbar navbar-inverse second">
        <ul class="nav">
          <li class=""><span><?php echo e(session('pwiscm_company_name')); ?> | <?php echo e(session('pwiscm_supplier_id')); ?></span></li>
        </ul>  
    </div>
</div>
    
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->


<!-- Modal structure -->
<div id="modal-iframe" style="background: #fff !important;"> <!-- data-iziModal-fullscreen="true"  data-iziModal-title="Welcome"  data-iziModal-subtitle="Subtitle"  data-iziModal-icon="icon-home" -->
  <!-- Modal content -->
</div>
<section class="animate-menu animate-menu-left animate-menu-open">
    <div class="div_menu"></div>
    <ul class="sidebar-menu">
        <li>
          <a href="<?php echo e(url('/')); ?>/po/management">
              <i class="icon icon-gift"></i> <span>PO Management</span>
          </a>
        </li> 
        <li>
          <a href="<?php echo e(url('/')); ?>/labelprint/management">
              <i class="icon icon-print"></i> <span>Label Print</span>
          </a>
        </li>            
        <li>
          <a href="<?php echo e(url('/')); ?>/barcode/scan">
              <i class="icon icon-barcode"></i> <span>Barcode Scan</span>
          </a>
        </li>       
        <li>
          <a href="<?php echo e(url('/')); ?>/dnview/management">
              <i class="icon icon-truck"></i> <span>Delivery Note</span>
          </a>
        </li>       
        <li>
          <a href="<?php echo e(url('/')); ?>/utility/changepassword">
              <i class="icon icon-key"></i> <span>Change Password</span>
          </a>
        </li>    
        <li>
            <a href="javascript:logoutApp();">
                <i class="fa fa-lock"></i> <span>Logout</span>
            </a>
        </li>
    </ul>
  </section>
<div id="content">
  <?php echo $__env->yieldContent('page_heading'); ?>       

  <?php echo $__env->yieldContent('add_button'); ?>         
  <?php echo $__env->yieldContent('content'); ?>
</div>


<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo e(csrf_field()); ?>

</form>
<script>
var public = "<?php echo e(asset('public')); ?>";
</script>
<script src="<?php echo e(asset('public')); ?>/js/bootstrap.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/matrix.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/sidebarmenu/dist/sidebar-menu.js"></script>
<script src="<?php echo e(asset('public')); ?>/js/jquery.idle.js"></script>
<script>
$(document).idle({
  onIdle: function(){
    window.location="<?php echo e(url('/')); ?>/utility/logoutapp";
    //alert('You have no activity more than 5 minutes ago, the system will logout');
  },
  idle: 300000
})


<?php if(Session::has('notif')): ?> 
    $.bootstrapGrowl("<?php echo e(Session::get('notif')['notification']); ?>", {
        type: "<?php echo e(Session::get('notif')['type']); ?>",offset: {from: 'top', amount: 250},align: 'center'
    });
<?php endif; ?>   

function menuTrigger(){
    $('body').addClass('animate-menu-push');
    $('body').toggleClass('animate-menu-push-right')
    $('.animate-menu-left').toggleClass('animate-menu-open')
}




function logoutApp(){
  bootbox.confirm({
		title: "Confirmation",
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
          //document.getElementById('logout-form').submit();	        
          window.location="<?php echo e(url('/')); ?>/utility/logoutapp";
       }			
			
		}
  });
}



$.sidebarMenu($('.sidebar-menu'));



</script>
<script>
  var public = "<?php echo e(asset('public')); ?>";
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
