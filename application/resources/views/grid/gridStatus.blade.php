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
        <a href="#"  class="tip-bottom content_title">Purchase Order Management</a>
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
						<button onclick="filterMaster();" type="button" id="button_save" value="Save" class="btn-small btn-mini bottom10 search_btn"><i class="icon-zoom-in"></i> Search</button>
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
                <h5>Master Info</h5>
				<div class='export_table'>
                    <button class='btn-small btn-mini btn_pwi exportMaster'><i class="icon icon-file-alt"></i> Export Excel</button>
                </div>
            </div>
						<canvas id="myChart" height="100"></canvas>

            <!-- <div class="widget-content nopadding">
                <table id="gridMaster" class="table table-bordered data-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>PO Date</th>
                            <th>PO Count</th>
                            <th>Factory</th>
                            <th>Delivery Factory</th>
                            <th>Bill Factory</th>
                            <th>Currency</th>
                            <th>Exchange Rate</th>
                            <th>Payment Method</th>
			      <th>Incoterms</th>
			      <th>Pay Terms</th>
                            <th>Remark</th>
                            <th>Modify Date</th>
                        </tr>
                    </thead>
                </table>
            </div> -->
        </div>
  </div>
</div>

<div class="container-fluid">

<ul style="margin:0; padding:0; width:100%; position:relative">
	<li style="list-style-type: none;">

		 <div class="row-fluid" style="width:79% !important;  position:relative; float:left">
				<div class="widget-box">
					<div class="widget-title widget_title_white">
						<h5>Detail Info</h5>
						<div class='export_table'>
							<button class='btn-small btn-mini btn_pwi exportDetail'><i class="icon icon-file-alt"></i> Export Excel</button>
						</div>
					</div>

					<!-- <div class="widget-content nopadding">
						<table id="gridDetail" class="table table-bordered data-table" style="width: 100%">
							<thead>
								<tr>
									<th>Seq</th>
  									<th>Buyer</th>
									<th>Order No</th>
									<th>Order  Seq</th>
									<th>Article No</th>
									<th>Model</th>
									<th>Gender</th>
									<th>Color</th>
									<th>Mat Description</th>
									<th>Job Description</th>
									<th>Unit</th>
									<th>PO Qty</th>
									<th>Scan Qty</th>
									<th>Delivered Qty</th>
									<th>Delivery Date</th>
									<th>Exc Rate</th>
									<th>Currency</th>
									<th>Unit Price</th>
									<th>PO Amount</th>
									<th>VAT Y/N</th>
									<th>PPH23 Y/N</th>
								</tr>
							</thead>
						</table>
					</div> -->
				</div>
		  </div>

	</li>
	<li  style="list-style-type: none;">
		<div class="row-fluid" style="width:19% !important;  position:relative; float:right">
			<div class="widget-box">
				<div class="widget-title widget_title_white">
					<h5>Size Info</h5>
				</div>

				<!-- <div class="widget-content nopadding">
					<table id="gridSize" class="table table-bordered data-table" style="width: 100%">
						<thead>
							<tr>
								<th>Size</th>
								<th>PO Qty</th>
							</tr>
						</thead>
					</table>
				</div> -->
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
$(document).ajaxStart(function(){
    $('#loading').show();
 }).ajaxStop(function(){
    $('#loading').hide();
 });
	var obj = new Object();
	obj.SelectedPO = "0";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$.ajax({
url: '{{url('/')}}/status/data',
success: function(data) {
	console.log(data);
		var lbl_stat = ["Barcode Scan","Delivery Note","PWJ IN SCAN"];
		var stat2 = [];var stat3 = [];var stat4 = [];
    stat2.push(data.data[0].STAT2);
		stat3.push(data.data[0].STAT3);
		stat4.push(data.data[0].STAT4);



var chartdata = {
        labels: lbl_stat,
        datasets : [
          {
            label: 'QTY',
            backgroundColor: [ 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
            borderColor: [ 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
            data: [stat2,stat3,stat4]
          }
        ]
      };
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx,
	{ type: 'bar',
	data: chartdata,
	options: {
		scales: { yAxes: [{
			ticks: { beginAtZero: true } }] } }
	});

}});
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$(document).ready(function(){
		$('.data-table th').css('white-space','initial');
		$('.data-table td').css('white-space','initial');
	});




	var start_date =  $("#start_date").val().replace(/-/g,"");
	var end_date =  $("#start_date").val().replace(/-/g,"");
///////////////////////
    var gridMaster = $('#gridMaster').DataTable( {
        ajax: {
            type: "GET"
        },
        select: true,
		columnDefs: [
            {
                "targets": 1,
                "data": 'creator',
                "render": function (dt, type, row ) {

                    return row.PO_DATE.substr(0, 4)+'-'+row.PO_DATE.substr(4, 2)+'-'+row.PO_DATE.substr(6, 2);
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
            { data: "PO_NO", "width": "150px", className: "text-center" },
            { data: "PO_DATE", "width": "70px", className: "text-center" },
            { data: "CNT", "width": "70px", className: "text-right" },
            { data: "FAC_NM", "width": "50px", className: "text-center" },
            { data: "DELI_FAC_NM", "width": "100px", className: "text-center" },
            { data: "BILL_FAC_NM", "width": "100px", className: "text-center" },
            { data: "EXC_NM", "width": "50px", className: "text-center" },
            { data: "EXC_RATE", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
            { data: "PAY_METHOD_NM", "width": "100px", className: "text-center" },
            { data: "INCOTERMS_NM", "width": "70px"},
            { data: "PAY_TERM_NM", "width": "150px"},
            { data: "REMARK", "width": "250px" },
            { data: "MODIFY_DATE", "width": "80", className: "text-center" }
        ],
        "scrollX": true,
        "order": [[ 2, "desc" ]],
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
//////////////////////////////////
    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }


    $("#modal").click(function(){
        popUp("{{url('/')}}/form", '50%', '490px')
    });



	$(".exportMaster").on("click", function() {
		gridMaster.button( '.buttons-excel' ).trigger();
		//tableToExcel('gridMaster', 'report', 'report.xls')
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

			gridMaster.ajax.url("{{url('/')}}/po/datalist/"+start_date+"/"+end_date+"/"+po_number+"/"+order_number).load();
			$("#span-type").html("Request");
			gridDetail.clear().draw();
		}
    }

	$('#gridMaster tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridMaster.row(this).selector.rows).addClass("hightLight");

		var data = gridMaster.row(this).data();

		var order_number =  $("#order_number").val();
		if(order_number == "")
		{
			order_number =  "0";
		}


		filterDetail(data.PO_NO, order_number);
		obj.SelectedPO = data.PO_NO;
	});

	var gridDetail = $('#gridDetail').DataTable( {
        ajax: {
            type: "GET",
        },
        select: true,
		columnDefs: [

			{
                "targets": 13,
                "data": 'creator',
                "render": function (dt, type, row ) {

                    return row.PO_RTA.substr(0, 4)+'-'+row.PO_RTA.substr(4, 2)+'-'+row.PO_RTA.substr(6, 2);
                }
            }
        ],
        columns: [
            { data: "PO_SEQ", "width": "70px", className: "text-center" },
            { data: "BUYER", "width": "70px", className: "text-center" },
            { data: "O_NO", "width": "70px", className: "text-center" },
            { data: "O_SEQ", "width": "70px", className: "text-center" },
            { data: "ARTNO", "width": "70px", className: "text-center" },
            { data: "ARTICLEDESC", "width": "100px", className: "text-center" },
            { data: "GENDER_CD", "width": "70px", className: "text-center" },
            { data: "COL_NM", "width": "100px", className: "text-center" },
            { data: "MAT_CD", "width": "100px" },
            { data: "JOB_DESC", "width": "350px" },
            { data: "UNIT", "width": "50px", className: "text-center" },
            { data: "PO_QTY", "width": "60px", render: $.fn.dataTable.render.number(',', '.', 0, ''), className: "text-right" },
            { data: "SCAN_QTY", "width": "80px", render: $.fn.dataTable.render.number(',', '.', 0, ''), className: "text-right" },
            { data: "DELEVERED_QTY", "width": "80px", render: $.fn.dataTable.render.number(',', '.', 0, ''), className: "text-right" },
            { data: "PO_RTA", "width": "80px", className: "text-center" },
            { data: "EXC_RATE", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"  },
            { data: "EXC_NM", "width": "70px", className: "text-center" },
            { data: "UNIT_PRICE", "width": "100px", render: $.fn.dataTable.render.number(',', '.', 5, ''), className: "text-right" },
            { data: "PO_AMT", "width": "70px", render: $.fn.dataTable.render.number('.', '.', 2, ''), className: "text-right" },
            { data: "VAT_YN", "width": "50px", className: "text-center" },
            { data: "PPH23_YN", "width": "65px", className: "text-center" }
        ],
        "scrollX": true,
        "order": [[ 0, "asc" ]],
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
				previous: '<<' // or '←'
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



	function filterDetail(po_number, order_number)
    {

		gridDetail.ajax.url("{{url('/')}}/po/detaildatalist/"+po_number+"/"+order_number).load();
		$("#span-type").html("Request");
    }

	$(".exportDetail").on("click", function() {
		gridDetail.button('.buttons-excel').trigger();
		//tableToExcel('gridDetail', 'report', 'report.xls')
    });

	$('#gridDetail tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridDetail.row(this).selector.rows).addClass("hightLight");

		var data = gridDetail.row(this).data();
		filterSize(obj.SelectedPO, data.PO_SEQ);
	});

	var gridSize = $('#gridSize').DataTable( {
        ajax: {
            type: "GET",
        },
        columns: [
            { data: "UKSIZE"},
            { data: "PO_QTY_SIZE", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
        ],
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

	function filterSize(po_number, seq_number)
    {
		gridSize.ajax.url("{{url('/')}}/po/sizelist/"+po_number+"/"+seq_number).load();
		$("#span-type").html("Request");
    }


    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }


</script>
@endsection
