<!DOCTYPE html>
<html lang="en">
<head>
<title>Parkland - SCM System</title>
<link rel="shortcut icon" href="{{ asset('public') }}/img/favicon.png" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap.min.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="{{ asset('public') }}/webfont/webfont.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/matrix-style.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/matrix-media.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/iziModal.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/menu_custom.css" />
<link rel="stylesheet" href="{{ asset('public') }}/plugins/metismenu/metisMenu.css" />

<link href="{{ asset('public') }}/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('public') }}/plugins/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('public') }}/plugins/sidebarmenu/dist/sidebar-menu.css">
<script src="{{ asset('public') }}/js/jquery.min.js"></script>
<script src="{{ asset('public') }}/js/jquery.ui.custom.js"></script>
<script src="{{ asset('public') }}/plugins/bootbox/bootbox.min.js"></script>
<script src="{{ asset('public') }}/plugins/bootbox/bootbox.locales.min.js"></script>
<script src="{{ asset('public') }}/js/iziModal.min.js"></script>
<script src="{{ asset('public') }}/js/jquery.bootstrap-growl.js"></script>
<script src="{{ asset('public') }}/js/jquery-mask.js"></script>
<script src="{{ asset('public') }}/js/jquery-cookies.js"></script>
<script src="{{ asset('public') }}/js/moment.js"></script>
<script src="{{ asset('public') }}/js/moment.locale.js"></script>
<script src="{{ asset('public') }}/js/ddacordion.js"></script>
<script src="{{ asset('public') }}/js/jquery.injectCSS.js"></script>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">&nbsp;</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=""><a title="" href="{{ url('/') }}" class="module_name">{{ session('pwiscm_company_name') }}</span></a></li>
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">{{ session('pwiscm_supplier_name') }}</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li class="divider"></li>
        <li><a href="javascript:logoutApp();"><i class="fa fa-lock"></i> Log Out</a></li>
      </ul>
    </li>
  </ul>
</div>

<div id="sidebar">
  <section>
    <ul class="sidebar-menu">
        <li>
          <a href="{{ url('/') }}/po/management">
              <i class="icon icon-gift"></i> <span>PO Management</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/') }}/labelprint/management">
              <i class="icon icon-print"></i> <span>Label Print</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/') }}/dnview/management">
              <i class="icon icon-truck"></i> <span>Delivery Note</span>
          </a>
        </li>
        <li>
          <a href="{{ url('/') }}/barcode/scan">
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
</div>

<!-- Modal structure -->
<div id="modal-iframe"> <!-- data-iziModal-fullscreen="true"  data-iziModal-title="Welcome"  data-iziModal-subtitle="Subtitle"  data-iziModal-icon="icon-home" -->
  <!-- Modal content -->
</div>

<div id="content">
  @yield('page_heading')
  @yield('add_button')
  @yield('content')
</div>

<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2020 &copy; PT. Korea Telecom Indonesia, licensed to PT. Parkland World Indonesia</div>
</div>
<!--end-Footer-part-->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
<script>
var public = "{{ asset('public') }}";
</script>
<script src="{{ asset('public') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('public') }}/js/matrix.js"></script>
<script src="{{ asset('public') }}/plugins/sidebarmenu/dist/sidebar-menu.js"></script>
<script>
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

@if(Session::has('notif'))
    $.bootstrapGrowl("{{ Session::get('notif')['notification'] }}", {
        type: "{{ Session::get('notif')['type'] }}"
    });
@endif

$.sidebarMenu($('.sidebar-menu'));

$.each(['minlength', 'maxlength'], function() {
    if (rules[this]) {
        rules[this] = Number(rules[this]);
    }
});
</script>
</body>
</html>
