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
</style>
<!--Content Title -->
<div id="content-header">
    <div id="breadcrumb">
        <a href="#"  class="tip-bottom content_title">Label Print</a>
    </div>
</div>
<!-- End Content Title -->
@endsection

@section('content')

<div class="container-fluid">
	<div class="row-fluid">
		<div class="widget-box">


			<div class="widget-content search_input_div">
				<ul class="searh_input">
					<li>
						<label for="start_date">Date From :</label><input value="{{ date("Y-m-d", strtotime("-29 day", strtotime(date("Y-M-d")))) }}" type="date" style="width:120px" name="start_date" id="start_date">
					</li>
					<li>
						<label for="end_date">Date To :</label><input  value="{{date('Y-m-d')}}" type="date" style="width:120px" name="end_date" id="end_date">
					</li>
					<li>
						<label for="order_number">Order Number :</label><input type="text" name="order_number" id="order_number" style="width:120px">
					</li>
					<li>
						<label for="po_number">PO Number :</label><input type="text" name="po_number" id="po_number">
					</li>
					<li>
						<label for="button_save">&nbsp;</label>
						<button onclick="filterMaster();" type="button" id="button_save" value="Save" class="btn-small btn-mini search_btn bottom10"><i class="icon-zoom-in"></i> Search</button>
					</li>
				</ul>
			</div>

		</div>
	</div>
</div>

<div class="container-fluid">
  <div class="row-fluid">
  	<div class="widget-box">
            <div class="widget-title widget_title_white">
                <h5>Label Info</h5>
				<div class='export_table'>
					<button class='btn-small btn-mini btn_pwi exportMaster'><i class="icon icon-file-alt"></i> Export Excel</button>
					<button class="btn-small btn-mini btn_pwi" onclick="makeLabel()" ><i class="icon icon-barcode"></i> Make Label</button>
				</div>
            </div>

            <div class="widget-content nopadding">
                <table id="gridMaster" class="table table-bordered data-table" style="width: 100%">
                    <thead>
                        <tr>
							<th>Label Y/N</th>
							<th>PO No</th>
							<th>PO Seq</th>
                           				<th>Buyer</th>
							<th>Order No</th>
							<th>Order  Seq</th>
							<th>PO Date</th>
							<th>Delivery Date</th>
							<th>Article</th>
							<th>Model</th>
							<th>Gender</th>
							<th>Color</th>
							<th>PO Qty</th>
							<th>Scan Qty</th>
							<th>Balance Qty</th>
							<th>Delivered Qty</th>
              <th>PWJ In Qty</th>
							<th>Pack Size</th>
							<th>Job Description</th>
							<th>Component</th>
							<th>Modify Date</th>
						</tr>
                    </thead>
                </table>
            </div>
        </div>
  </div>
  {{ csrf_field() }}


</div>


<input type="hidden" id="selectedPO" name="selectedPO">
<input type="hidden" id="selectedPOSequence" name="selectedPOSequence">
<input type="hidden" id="selectedLabel" name="selectedLabel">
<div class="container-fluid">

<ul style="margin:0; padding:0; width:100%; position:relative">
	<li style="list-style-type: none;">

		<div class="row-fluid" style="width:49% !important;  position:relative; float:left">
				<div class="widget-box">
					<div class="widget-title widget_title_white">
						<h5>Size Info</h5>
						<div class='export_table'>
							<button class="btn-small btn-mini btn_pwi" onclick="printChecked()" ><i class="icon icon-check"></i> Print</button>
						</div>

					</div>

					<div class="widget-content nopadding">
						<table id="gridDetailLabel" class="table table-bordered data-table" style="width: 100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="check_all" name="check_all" onclick="checkAll($(this))"></th>
									<th>Size</th>
									<th>Qty</th>
									<th>Scan Qty</th>
									<th>Delivered Qty</th>
                  <th>PWJ In Qty</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
		  </div>

	</li>
	<li  style="list-style-type: none;">

		<div class="row-fluid" style="width:49% !important; position:relative; float:right">
			<div class="widget-box">
				<div class="widget-title  widget_title_white">
					<h5>Barcode Info</h5>
					<div class='export_table'>
						<button class='btn-small btn-mini btn_pwi exportDetail'><i class="icon icon-file-alt"></i> Export Excel</button>
						<button class="btn-small btn-mini btn_pwi" onclick="printCheckedBarcode();"><i class="icon icon-check"></i> Print</button>
					</div>
				</div>

				<div class="widget-content nopadding">
					<table id="gridDetailSize" class="table table-bordered data-table" style="width: 100%">
						<thead>
							<tr>
								<th><input type="checkbox" id="check_all_barcode" name="check_all_barcode" onclick="checkAllBarcode($(this))"></th>
								<th>Barcode</th>
								<th>Qty</th>
								<th>Scan Date</th>
								<th>Created Date</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>

	</li>
</ul>


</div>
<div class="loading-container" id="loading">
    <div class="loading" ></div>
    <div class="loading-text">loading</div>
</div>

<!-- End Content -->
<script type="text/javascript" src="{{ asset('public') }}/js/jquery.dataTables.js"></script>

<script>
$(document).ajaxStart(function(){
    $('#loading').show();
 }).ajaxStop(function(){
    $('#loading').hide();
 });
	var obj = new Object();
	obj.SelectedPO = "0";
	obj.SelectedPOSequence = "0";
	obj.hasLabel = "";

	$(document).ready(function(){
		$('.data-table th').css('white-space','initial');
		$('.data-table td').css('white-space','initial');
	});

	var start_date =  $("#start_date").val().replace(/-/g,"");
	var end_date =  $("#start_date").val().replace(/-/g,"");

    var gridMaster = $('#gridMaster').DataTable( {
        ajax: {
            type: "GET",
            //url: "{{url('/')}}/labelprint/datalist/"+start_date+"/"+end_date+"/0/0",
        },
        select: true,
		columnDefs: [
			{
                "targets": 5,
                "data": 'creator',
                "render": function (dt, type, row ) {

                    return row.PO_DATE.substr(0, 4)+'-'+row.PO_DATE.substr(4, 2)+'-'+row.PO_DATE.substr(6, 2);
                }
			},
			{
                "targets": 6,
                "data": 'creator',
                "render": function (dt, type, row ) {

                    return row.PO_RTA.substr(0, 4)+'-'+row.PO_RTA.substr(4, 2)+'-'+row.PO_RTA.substr(6, 2);
                }
            },
			{
                "targets": -1,
                "data": 'creator',
                "render": function (dt, type, row ) {

                    return row.MODIFY_DATE.substr(0, 4)+'-'+row.MODIFY_DATE.substr(4, 2)+'-'+row.MODIFY_DATE.substr(6, 2);
                }
            }
        ],
        columns: [
            { data: "LBL_YN", "width": "70px", className: "text-center" },
            { data: "PO_NO", "width": "150px", className: "text-center"},
            { data: "PO_SEQ", "width": "50px", className: "text-center"},
            { data: "BUYER", "width": "70px", className: "text-center"},
            { data: "O_NO", "width": "70px", className: "text-center" },
            { data: "O_SEQ", "width": "70px", className: "text-center" },
            { data: "PO_DATE", "width": "100px", className: "text-center"},
            { data: "PO_RTA", "width": "100px", className: "text-center" },
            { data: "ARTICLEDESC", "width": "100px", className: "text-center"},
            { data: "PART_NM", "width": "100px" },
            { data: "GENDER_CD", "width": "50px", className: "text-center"},
            { data: "COL_NM", "width": "150px", className: "text-center" },
            { data: "PO_QTY", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
            { data: "SCAN_QTY", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"  },
            { data: "BALANCE_QTY", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"  },
            { data: "DELEVERED_QTY", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"  },
            { data: "PWJ_IN_QTY", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"  },
            { data: "PACK_SIZE", "width": "80px", render: $.fn.dataTable.render.number('.', '.', 0, '') , className: "text-right" },
            { data: "JOB_DESC", "width": "350px" },
            { data: "PART_NM", "width": "150px" },
            { data: "MODIFY_DATE", "width": "80px", className: "text-center"  }
        ],
        "scrollX": true,
        "order": [[ 1, 'desc' ], [ 2, 'asc' ]],
        "bSortCellsTop": true,
        "pageLength" : 5,
        "searching": false,
        "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
        "bJQueryUI": true,
        "fnDrawCallback": function( oSettings ) {

			$('.dt-buttons').css("display", "none");
            $('.data-table tbody tr').each( function() {
                this.setAttribute('style', "cursor:pointer");
            });
		},
		dom: '<"top"i>Bfrtip<"bottom"flp><"clear">',
		buttons: [
            'excel'
        ],
		language: {
			paginate: {
				next: '>>', // or '→'
				previous: '<<', // or '←'

			},
			"sLengthMenu": "_MENU_",
			select: {
				rows: ""
			},
			"emptyTable": "No data"

		},
		"infoCallback": function( settings, start, end, max, total, pre ) {
			var mulai = start;
			if(end == 0) {
				mulai = 0;
			}
			return mulai +" - "+ end +" of " + total;
		}
    });



    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }



	$(".exportMaster").on("click", function() {
        gridMaster.button('.buttons-excel').trigger();
    });

	function filterMaster()
    {

		var start_date =  $("#start_date").val().replace(/-/g,"");
		var end_date =  $("#end_date").val().replace(/-/g,"");
		var po_number =  $("#po_number").val();
		var order_number =  $("#order_number").val();
		if(start_date == "" || end_date == "" )
		{
			$.bootstrapGrowl("Date from and Date To cannot empty!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
		}
		else{
			if(po_number == "")
			{
				po_number = 0;
			}

			if(order_number == "")
			{
				order_number = 0;
			}


			gridMaster.ajax.url("{{url('/')}}/labelprint/datalist/"+start_date+"/"+end_date+"/"+po_number+"/"+order_number).load(null, false);
			$("#span-type").html("Request");
		}
    }

	$('#gridMaster tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridMaster.row(this).selector.rows).addClass("hightLight");

		var data = gridMaster.row(this).data();
		filterGetSize(data.PO_NO, data.PO_SEQ);
		obj.SelectedPO = data.PO_NO;
		obj.SelectedPOSequence = data.PO_SEQ;
		obj.hasLabel = data.LBL_YN;

		$("#selectedPO").val(data.PO_NO);
		$("#selectedPOSequence").val(data.PO_SEQ);
		$("#selectedLabel").val("");

	});

	var x = 0;
	var gridDetailLabel = $('#gridDetailLabel').DataTable( {
        ajax: {
            type: "GET",
        },
        select: true,

		columnDefs: [
			{
                "targets": 0,
                "data": 'creator',
                "render": function (dt, type, row ) {
					x++;
					return "<div style='text-align:center;'><input type='checkbox' name='shoe_size"+x+"' id='shoe_size"+x+"' value='"+row.UKSIZE+"'></div>";
                }
			}
        ],
        columns: [
			      { data: "UKSIZE", "width": "10px", className: "text-center"  },
            { data: "UKSIZE", "width": "70px", className: "text-center"  },
            { data: "PO_QTY", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
            { data: "SCAN_QTY", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"},
            { data: "DELEVERED_QTY", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
            { data: "PWJ_IN_QTY", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" }
        ],
        "scrollX": true,
        "order": [[ 1, "asc" ]],
        "bSortCellsTop": true,
        "pageLength" : 5,
        "searching": false,
        "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
        "bJQueryUI": true,
        "fnDrawCallback": function( oSettings ) {

			var y = 0;
			var w = -1;

			$('.dt-buttons').css("display", "none");
            $('.data-table tbody tr').each( function() {


				this.setAttribute('style', "cursor:pointer");
				if ($(this).find('td:eq(0) :input').attr('id') !== undefined){
					y++;
					//console.log( $(this).attr("id"));
					var ids = $(this).find('td:eq(0) :input').attr('id');

					var idInput = ids.replace(/[0-9]/g, '');
					if(idInput == "shoe_size")
					{
						$("#"+ids).attr('id', "shoe_size" + y);
						$("#"+ids).attr('name', "shoe_size" + y);
					}

				}

			});



		},
		dom: '<"top"i>Bfrtip<"bottom"flp><"clear">',
		buttons: [
            'excel'
        ],
		language: {
			paginate: {
				next: '>>', // or '→'
				previous: '<<', // or '←'

			},
			"sLengthMenu": "_MENU_",
			select: {
				rows: ""
			}

		},
		"infoCallback": function( settings, start, end, max, total, pre ) {
			var mulai = start;
			if(end == 0) {
				mulai = 0;
			}
			return mulai +" - "+ end +" of " + total;
		}
    });

	function filterGetSize(po_number, seq_number)
    {
		gridDetailLabel.ajax.url("{{url('/')}}/labelprint/labeldatalist/"+po_number+"/"+seq_number).load();
		$("#span-type").html("Request");

		$("#check_all").attr("checked", false);
    }

	$('#gridDetailLabel tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridDetailLabel.row(this).selector.rows).addClass("hightLight");

		var data = gridDetailLabel.row(this).data();
		filterGetLabel(obj.SelectedPO, obj.SelectedPOSequence, data.UKSIZE);
	});


	var gridDetailSize = $('#gridDetailSize').DataTable( {
        ajax: {
            type: "GET",
        },
		select: true,
		columnDefs: [
			{
                "targets": 0,
                "data": 'creator',
                "render": function (dt, type, row ) {
					x++;
					return "<div style='text-align:center;'><input type='checkbox' name='label_id"+x+"' id='label_id"+x+"' value='"+row.LBL_ID+"'></div>";
                }
			}
        ],
        columns: [
			{ data: "LBL_ID", "width": "10px", className: "text-center" },
            { data: "LBL_ID", "width": "70px", className: "text-center"  },
            { data: "LABEL_QTY", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"  },
            { data: "SCAN_DATE", "width": "70px", className: "text-center"  },
            { data: "CREATE_DATE", "width": "70px", className: "text-center"  }
        ],
        "scrollX": true,
        "order": [[ 1, "asc" ]],
        "bSortCellsTop": true,
        "pageLength" : 5,
        "searching": false,
        "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
        "bJQueryUI": true,
        "fnDrawCallback": function( oSettings ) {

			var r = 0;

			$('.dt-buttons').css("display", "none");
            $('#gridDetailSize tbody tr').each( function() {

				this.setAttribute('style', "cursor:pointer");
				if ($(this).find('td:eq(0) :input').attr('id') !== undefined){
					r++;

					var id = $(this).find('td:eq(0) :input').attr('id');
					$("#"+id).attr('id', "label_id" + r);
					$("#"+id).attr('name', "label_id" + r);
				}

			});


		},
		dom: '<"top"i>Bfrtip<"bottom"flp><"clear">',
		buttons: [
            'excel'
        ],
		language: {
			paginate: {
				next: '>>', // or '→'
				previous: '<<', // or '←'

			},
			"sLengthMenu": "_MENU_",
			select: {
				rows: ""
			}

		},
		"infoCallback": function( settings, start, end, max, total, pre ) {
			var mulai = start;
			if(end == 0) {
				mulai = 0;
			}
			return mulai +" - "+ end +" of " + total;
		}
    });

	function filterGetLabel(po_number, seq_number, uk_size)
    {
		gridDetailSize.ajax.url("{{url('/')}}/labelprint/sizedatalist/"+po_number+"/"+seq_number+"/"+uk_size).load();
		$("#span-type").html("Request");
		$("#check_all_barcode").attr("checked", false)
    }


	$(".exportDetail").on("click", function() {
		gridDetailSize.button( '.buttons-excel' ).trigger();
    });

	$('#gridDetailSize tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridDetailSize.row(this).selector.rows).addClass("hightLight");

		var data = gridDetailSize.row(this).data();
		$("#selectedLabel").val(data.LBL_ID);
	});

	function makeLabel()
	{
		if(obj.SelectedPO == "0")
		{
			$.bootstrapGrowl("You need to select the PO first", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
		}
		else{
			if(obj.hasLabel == "Y")
			{
				$.bootstrapGrowl("Label existed!", {
					type: "error",offset: {from: 'top', amount: 250},align: 'center'
				});
			}
			else{
				$.ajax({
					type: "GET",
					url: "{{url('/')}}/labelprint/makelabel/"+obj.SelectedPO+"/"+obj.SelectedPOSequence,
					success: function (json) {

						if(json.result == "Ok")
						{
							$.bootstrapGrowl("Make Label Success", {
								type: "success",offset: {from: 'top', amount: 250},align: 'center'
							});

							filterMaster();

						}
						else{
							$.bootstrapGrowl("Make Label failed!", {
								type: "error",offset: {from: 'top', amount: 250},align: 'center'
							});
						}
					}
				});
			}


		}
	}

	function checkAll(obj){
		var totalRowS = gridDetailLabel.data().count();
		if($("#check_all").is(':checked'))
		{
			for(var x = 1; x <= totalRowS; x++)
			{
				$("#shoe_size" + x).prop("checked", true);
			}
		}
		else{
			for(var x = 1; x <= totalRowS; x++)
			{
				$("#shoe_size" + x).prop("checked", false);
			}
		}
	}

	function checkAllBarcode(obj){
		var totalRow = gridDetailSize.data().count();
		if($("#check_all_barcode").is(':checked'))
		{
			for(var x = 1; x <= totalRow; x++)
			{
				$("#label_id" + x).prop("checked", true);
			}
		}
		else{
			for(var x = 1; x <= totalRow; x++)
			{
				$("#label_id" + x).prop("checked", false);
			}
		}
	}

	function printCheckedBarcode(){
		var totalRow = gridDetailSize.data().count();
		var selectedLabel = "";
		var totalSelected = 0;
		for(var x = 1; x <= totalRow; x++)
		{
			if($("#label_id" + x).is(':checked'))
			{
				totalSelected++;
				selectedLabel+= $("#label_id" + x).val()+"|";
			}
		}

		if(totalSelected > 0)
		{
			var labels = selectedLabel.substring(0, selectedLabel.length - 1);
			var po =  $("#selectedPO").val();
			var po_sequence = $("#selectedPOSequence").val();
			popUp("{{url('/')}}/labelprint/printbylabels/"+po+"/"+po_sequence+"/"+labels, '450px', '500px', 'Print Preview')
		}
		else{
			$.bootstrapGrowl("No selected data!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});

			return false;
		}
	}

	function printChecked(obj){
		var totalRow = gridDetailLabel.data().count();
		var selectedSize = "";
		var totalSelected = 0;
		for(var x = 1; x <= totalRow; x++)
		{
			if($("#shoe_size" + x).is(':checked'))
			{
				totalSelected++;
				selectedSize+= $("#shoe_size" + x).val()+"|";
			}
		}

		if(totalSelected > 0)
		{
			var sizes = selectedSize.substring(0, selectedSize.length - 1);
			var po =  $("#selectedPO").val();
			var po_sequence = $("#selectedPOSequence").val();
			popUp("{{url('/')}}/labelprint/printbysizes/"+po+"/"+po_sequence+"/"+sizes, '450px', '500px', 'Print Preview')
		}
		else{
			$.bootstrapGrowl("No selected data!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});

			return false;
		}
	}

	function printAll(){
		var totalRow = gridDetailLabel.data().count();
		if(totalRow > 0){
			var po =  $("#selectedPO").val();
			var po_sequence = $("#selectedPOSequence").val();
			popUp("{{url('/')}}/labelprint/printall/"+po+"/"+po_sequence, '450px', '500px', 'Print Preview');
		}
		else{
			$.bootstrapGrowl("No selected data!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
		}
	}

	function printSingle(){
		var label = $("#selectedLabel").val();
		if(label !== ""){
			var po =  $("#selectedPO").val();
			var po_sequence = $("#selectedPOSequence").val();

			popUp("{{url('/')}}/labelprint/printsingle/"+po+"/"+po_sequence+"/"+label, '450px', '500px', 'Print Preview');
		}
		else{
			$.bootstrapGrowl("No selected data!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
		}
	}





    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }



</script>
@endsection
