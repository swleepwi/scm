function Confirm(msg, actionReff) {
	bootbox.confirm({
		title: "Confirmation",
		message: msg,
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
				window.location=actionReff;
			}			
			
		}
	});
}

function confirmCallback(msg, callback) {
	bootbox.confirm({
		title: "Confirmation",
		message: msg,
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
				callback();	
			}	
					
			
		}
	});
}



function deleteData(msg, actionReff, reloadTable){
	bootbox.confirm({
		title: "Confirmation",
		message: msg,
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

				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open("GET", actionReff, true);
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						$.bootstrapGrowl("Data deleted!", {
							type: "success"
						});

						if(reloadTable) {
							$('.data-table').DataTable().ajax.reload();
						}
					}
				}
				xmlhttp.send(null);

			}			
			
		}
	});	
}

function popUp(url, widthSize, height, pageTitle){
	$('#modal-iframe').iziModal('destroy');
	$("#modal-iframe").iziModal({
		iframe: true,
		width: widthSize,
		iframeHeight: height,
		iframeURL: url,
		fullscreen: false,
		closeButton: true,
		radius: 0,
		headerColor: '#2f3a57',
		background 	:'#fff',
		padding: '10px',
		focusInput: true,
		arrowKeys : true,
		navigateCaption: true,
		transitionIn: 'fadeInDown',
		transitionOut: 'fadeOutDown',
		title: "<span style='color:#fff'>" + pageTitle + "</span>",
	});
	$('#modal-iframe').iziModal('open');
}


function populatePrintDiv(e, pos)
{
	if($("#print_div").length)
	{ 
		e.preventDefault();
		$('#print_div').css( 'position', 'absolute' );
		$('#print_div').css( 'top', e.pageY - 50 );
		$('#print_div').css( 'left', pos.left - 100); //e.pageX - 350 );
		$('#print_div').slideDown("medium");
	}
}
function number_format(number, decimals, decPoint, thousandsSep) { 
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
	var n = !isFinite(+number) ? 0 : +number
	var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
	var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
	var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
	var s = ''

	var toFixedFix = function (n, prec) {
		var k = Math.pow(10, prec)
		return '' + (Math.round(n * k) / k)
		.toFixed(prec)
	}

	// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || ''
		s[1] += new Array(prec - s[1].length + 1).join('0')
	}

	return s.join(dec)
}

$(document).ready(function(){
	
	if($("#print_div").length)
	{ 
		$("#print_div").hide();	
	}

	if($('.search_menu').length)
	{
		$(".search_menu").on("keyup", function () {
			if (this.value.length > 0) {  
				$(".sidebar-menu ul").show();
				$(".sidebar-menu ul li").hide().filter(function () {
					return $(this).text().toLowerCase().indexOf($(".search_menu").val().toLowerCase()) != -1;
				}).show(); 
			}
			else{
				$(".sidebar-menu ul").hide();
				$(".sidebar-menu ul li").hide().filter(function () {
					return $(this).text().toLowerCase().indexOf("") != -1;
				}).show(); 
			}  
			
		}); 
	}
	/*

	if($('.xls_datatable').length){
		$(".xls_datatable").on("click", function() {
			table.button( '.buttons-excel' ).trigger();
		});
	}

	if($('.print_datatable').length) {
		$(".print_datatable").on("click", function() {
			table.button( '.buttons-print' ).trigger();
		});
	}

    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }
	*/

	// === Sidebar navigation === //
	
	$('.submenu > a').click(function(e)
	{
		e.preventDefault();
		var submenu = $(this).siblings('ul');
		var li = $(this).parents('li');
		var submenus = $('#sidebar li.submenu ul');
		var submenus_parents = $('#sidebar li.submenu');
		if(li.hasClass('open'))
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenu.slideUp();
			} else {
				submenu.fadeOut(250);
			}
			li.removeClass('open');
		} else 
		{
			if(($(window).width() > 768) || ($(window).width() < 479)) {
				submenus.slideUp();			
				submenu.slideDown();
			} else {
				submenus.fadeOut(250);			
				submenu.fadeIn(250);
			}
			submenus_parents.removeClass('open');		
			li.addClass('open');	
		}
	});
	
	var ul = $('#sidebar > ul');
	
	$('#sidebar > a').click(function(e)
	{
		e.preventDefault();
		var sidebar = $('#sidebar');
		if(sidebar.hasClass('open'))
		{
			sidebar.removeClass('open');
			ul.slideUp(250);
		} else 
		{
			sidebar.addClass('open');
			ul.slideDown(250);
		}
	});
	
	// === Resize window related === //
	$(window).resize(function()
	{
		if($(window).width() > 479)
		{
			ul.css({'display':'block'});	
			$('#content-header .btn-group').css({width:'auto'});		
		}
		if($(window).width() < 479)
		{
			ul.css({'display':'none'});
			fix_position();
		}
		if($(window).width() > 768)
		{
			$('#user-nav > ul').css({width:'auto',margin:'0'});
            $('#content-header .btn-group').css({width:'auto'});
		}
	});
	
	if($(window).width() < 468)
	{
		ul.css({'display':'none'});
		fix_position();
	}
	
	if($(window).width() > 479)
	{
	   $('#content-header .btn-group').css({width:'auto'});
		ul.css({'display':'block'});
	}
	
	// === Tooltips === //
	$('.tip').tooltip();	
	$('.tip-left').tooltip({ placement: 'left' });	
	$('.tip-right').tooltip({ placement: 'right' });	
	$('.tip-top').tooltip({ placement: 'top' });	
	$('.tip-bottom').tooltip({ placement: 'bottom' });	
	
	// === Search input typeahead === //
	/*
	$('#search input[type=text]').typeahead({
		source: ['Dashboard','Form elements','Common Elements','Validation','Wizard','Buttons','Icons','Interface elements','Support','Calendar','Gallery','Reports','Charts','Graphs','Widgets'],
		items: 4
	});
	*/
	
	// === Fixes the position of buttons group in content header and top user navigation === //
	function fix_position()
	{
		var uwidth = $('#user-nav > ul').width();
		$('#user-nav > ul').css({width:uwidth,'margin-left':'-' + uwidth / 2 + 'px'});
        
        var cwidth = $('#content-header .btn-group').width();
        $('#content-header .btn-group').css({width:cwidth,'margin-left':'-' + uwidth / 2 + 'px'});
	}
	
	// === Style switcher === //
	$('#style-switcher i').click(function()
	{
		if($(this).hasClass('open'))
		{
			$(this).parent().animate({marginRight:'-=190'});
			$(this).removeClass('open');
		} else 
		{
			$(this).parent().animate({marginRight:'+=190'});
			$(this).addClass('open');
		}
		$(this).toggleClass('icon-arrow-left');
		$(this).toggleClass('icon-arrow-right');
	});
	
	$('#style-switcher a').click(function()
	{
		var style = $(this).attr('href').replace('#','');
		$('.skin-color').attr('href','css/maruti.'+style+'.css');
		$(this).siblings('a').css({'border-color':'transparent'});
		$(this).css({'border-color':'#aaaaaa'});
	});
	
	$('.lightbox_trigger').click(function(e) {
		
		e.preventDefault();
		
		var image_href = $(this).attr("href");
		
		if ($('#lightbox').length > 0) {
			
			$('#imgbox').html('<img src="' + image_href + '" /><p><i class="icon-remove icon-white"></i></p>');
		   	
			$('#lightbox').slideDown(500);
		}
		
		else { 
			var lightbox = 
			'<div id="lightbox" style="display:none;">' +
				'<div id="imgbox"><img src="' + image_href +'" />' + 
					'<p><i class="icon-remove icon-white"></i></p>' +
				'</div>' +	
			'</div>';
				
			$('body').append(lightbox);
			$('#lightbox').slideDown(500);
		}
		
	});
	
	/*
	$('#lightbox').live('click', function() { 
		$('#lightbox').hide(200);
	});
	*/
	
});

