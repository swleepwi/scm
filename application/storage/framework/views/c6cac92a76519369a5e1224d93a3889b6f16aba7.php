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
    <a href="javascript:void()" onclick="menuTrigger()" class="menu_toggle"><i class="fa fa-bars"></i></a>

    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">          
          <li class=""><a title="" href="<?php echo e(url('/')); ?>" class="module_name"><?php echo e(session('pwiscm_company_name')); ?></span></a></li>
          <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user putih"></i> <?php echo e(session('pwiscm_supplier_name')); ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
              
              <li><a href="javascript:logoutApp();"><i class="fa fa-lock"></i> Log Out</a></li>
            </ul>
          </li>
          <li class=""><img src="<?php echo e(asset('public')); ?>/img/scmsys.png" class="scmsys" /></li>
          
        </ul>  
      </div>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->


<!-- Modal structure -->
<div id="modal-iframe"> <!-- data-iziModal-fullscreen="true"  data-iziModal-title="Welcome"  data-iziModal-subtitle="Subtitle"  data-iziModal-icon="icon-home" -->
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
        <a href="<?php echo e(url('/')); ?>/dnview/management">
            <i class="icon icon-truck"></i> <span>Delivery Note</span>
        </a>
        </li>               
        <li>
        <a href="<?php echo e(url('/')); ?>/barcode/scan">
            <i class="icon icon-barcode"></i> <span>Barcode Scan</span>
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

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; PT. Korea Telecom Indonesia, licensed to PT. Parkland World Indonesia</div>
</div>
<!--end-Footer-part-->
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo e(csrf_field()); ?>

</form>
<script>
var public = "<?php echo e(asset('public')); ?>";
</script>
<script src="<?php echo e(asset('public')); ?>/js/bootstrap.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>/js/matrix.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/sidebarmenu/dist/sidebar-menu.js"></script>
<script>


function menuTrigger(){
    $('body').addClass('animate-menu-push');
    $('body').toggleClass('animate-menu-push-right')
    $('.animate-menu-left').toggleClass('animate-menu-open')
}




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

<?php if(Session::has('notif')): ?> 
    $.bootstrapGrowl("<?php echo e(Session::get('notif')['notification']); ?>", {
        type: "<?php echo e(Session::get('notif')['type']); ?>",offset: {from: 'top', amount: 40},align: 'center'
    });
<?php endif; ?>   

$.sidebarMenu($('.sidebar-menu'));

$(document).ready(function(){
    setTimeout(function(){
       // $('body').addClass('animate-menu-push');
       // $('body').toggleClass('animate-menu-push-right')
       // $('.animate-menu-left').toggleClass('animate-menu-open')
    }, 100)
    
});

</script>

</body>
</html>
