@extends('template.headerform')
@section('page_heading')

<style>
 /**
.loading {display:none; position:absolute; top:-10px; left:0; z-index:99; width:100%; height: 100vh;text-align: center;
			line-height: 100vh; background:rgba(0, 0, 0, 0); }
.loading strong {display:block; position:relative; top: 35%; left:30% width:50px; height:50px; padding:0 30px; text-align: center;
			line-height: 50px;   }
			**/
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
.control-group {
    margin-bottom: 0px !important;
}
#detailInsert{
	opacity: 1;
	position: relative;
}
#blocker{
	position: absolute;
	display: none;
	width:100%;
	height:100%;
	top: 0;
    z-index: 999;
}
</style>
<!--Content Title -->
<div id="content-header">
</div>
<!-- End Content Title -->
@endsection

@section('content')
<div class="container-fluid">
	<form  name="formEntry" id="formEntry"  novalidate="novalidate" style="	padding-top: 20px !important">
			{{ csrf_field() }}
		<div class="row-fluid">
			<div class="span12">
			<div class="widget-box">


				<div class="widget-content">

					<div style="display: inline-block">
						<div class="span3">

							<div class="control-group">
								<label class="control-label">Out Date *</label>
								<div class="controls">
									<input type="date" value="@if(isset ($edit)){{$out_date}}@else{{date("Y-m-d")}}@endif" name="out_date" id="out_date">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">GRN No</label>
								<div class="controls">
									<input type="text" value="@if(isset ($edit)){{$edit->OUT_NO}}@endif"  name="out_no" id="out_no" readonly >
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">PPN</label>
								<div class="controls">
									<select name="ppn" id="ppn" style="width:120px">
										@foreach ($ppn as $dt)
											<option value="{{$dt->NAME}}" @if(isset($edit) && $edit->VAT_RATE == $dt->NAME) selected @endif>{{$dt->CODE}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="span3">

							<div class="control-group">
								<label class="control-label">Class</label>
								@php
									$IdClass = "";
									$nameClass = "";
									@endphp
									@foreach ($class as $dt)

										@php
											if($dt->NAME == "Goods Issue Note")
											{
												$IdClass = $dt->CODE;
												$nameClass = $dt->NAME;
											}
										@endphp
									@endforeach

								<div class="controls">
									<input type="text" value="{{$nameClass}}"  name="class_name" id="class_name" readonly >

									<input type="hidden" name="class" id="class" value="{{$IdClass}}">
								</div>


							</div>

							<div class="control-group">
								<label class="control-label">PO Type</label>
								<select name="po_type" id="po_type">
									@foreach ($poType as $dt)
										<option value="{{$dt->CODE}}" @if(isset($edit) && $edit->POMDOYN == $dt->CODE) selected @endif>{{$dt->NAME}}</option>
									@endforeach
								</select>
							</div>

							<div class="control-group">
								<label class="control-label">W/H</label>
								<div class="controls">
									<select name="wh" id="wh">
										@foreach ($wh as $dt)
											<option value="{{$dt->CODE}}" @if(isset($edit) && $edit->ST_CD == $dt->CODE) selected @endif	>{{$dt->NAME}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="span3">
							<div class="control-group">
								<label class="control-label">Invoice No</label>
								<div class="controls">
									<input type="text" name="inv_no" id="inv_no" value="@if(isset ($edit)){{$edit->INV_NO}}@endif">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Container No</label>
								<div class="controls">
									<input type="text" name="contain_no" id="contain_no" value="@if(isset ($edit)){{ $edit->CONTAIN_NO }}@endif">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Deli Order No</label>
								<div class="controls">
									<input type="text" name="deli_order_no" id="deli_order_no" value="@if(isset ($edit)){{ $edit->DELI_ORD_NO }}@endif">
								</div>
							</div>

						</div>

						<div class="span3">
							<div class="control-group">
								<label class="control-label">Mobil No</label>
								<div class="controls">
									<input type="text" name="mobil_no" id="mobil_no" value="@if(isset ($edit)){{ $edit->MOBIL_NO }}@endif">
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Remarks</label>
								<div class="controls">
									<textarea name="remark" id="remark" style="height:81px; width:220px">{{ isset($edit) ? $edit->REMARK : old('REMARK') }}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="control-group">
						<button type="submit" value="Save" class="btn-small search_btn" style="margin-right: 10px;"><i class="icon-save"></i> Save</button>
						<button type="button" value="Save" class="btn-small search_btn" style="margin-right: 10px;" id="pintDN" onclick="printDN()"><i class="icon-print"></i> Print</button>
					</div>

				</div>

			</div>
			</div>
		</div>
	</form>
</div>


<div id="detailInsert">
	<div id="blocker"></div>





</div>
<div class="container-fluid">


	<div class="row-fluid">
		<div class="widget-box">
			<div class="widget-title widget_title_white">
				<h5>Search PO</h5>
				<div class='export_table'>

					<input type="text" name="po_no" id="po_no" placeholder="PO Number" style="width:200px">
					<input type="text" name="o_no" id="o_no" placeholder="Order Number" style="width:100px; margin-left:10px">
					<button type="button" value="Save" onclick="searchPO();" class="btn-small btn-mini btn_pwi" style="margin-bottom: 10px;"><i class="icon-zoom-in"></i> Search</button>
					<button class="btn-small btn-mini btn_pwi" onclick="addChecked()" style="margin-bottom: 10px" ><i class="icon icon-plus"></i> Add</button>
				</div>
			</div>

			<div class="widget-content nopadding">
				<table id="gridPO" class="table table-bordered data-table" style="width: 100%">
					<thead>
						<tr>
							<th style="text-align:center;"><input type="checkbox" id="check_all" name="check_all" onclick="checkAll($(this))" style="width:inherit !important;"></th>
							<th>Barcode</th>
							<th>PO No</th>
							<th>PO Seq</th>
							<th>Buyer</th>
							<th>Order No</th>
							<th>Order Seq</th>
							<th>Model</th>
							<th>Article</th>
							<th>Size</th>
							<th>Qty</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<br/>
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
								<button class="btn-small btn-mini btn_pwi" onclick="deleteInserted()" ><i class="icon icon-trash"></i> Delete</button>
							</div>
						</div>

						<div class="widget-content nopadding">
							<table id="gridDetail" class="table table-bordered data-table" style="width: 100%">
								<thead>
									<tr>
										<th>Seq</th>
										<th>PO No</th>
										<th>PO Seq</th>
										<th>Buyer</th>
										<th>Order No</th>
										<th>Order  Seq</th>
										<th>Article No</th>
										<th>Model</th>
										<th>Buyer</th>
										<th>Gender</th>
										<th>Job Desc</th>
										<th>Component</th>
										<th>Color</th>
										<th>Unit</th>
										<th>Size Y/N</th>
										<th>PO Qty</th>
										<th>Currency</th>
										<th>Exc Rate</th>
										<th>Unit Price</th>
										<th>Amount</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>

					<br/>
			  </div>

		</li>
		<li  style="list-style-type: none;">


			<div class="row-fluid" style="width:19% !important;  position:relative; float:right">
				<div class="widget-box">
					<div class="widget-title widget_title_white">
						<h5>Size Info</h5>
					</div>

					<div class="widget-content nopadding">
						<table id="gridSize" class="table table-bordered data-table" style="width: 100%">
							<thead>
								<tr>
									<th>Size</th>
									<th>Order</th>
									<th>Delivered</th>
									<th>Balance</th>
									<th>Note</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<br/>
			  </div>



		</li>
	</ul>
	<div class="loading-container" id="loading">
			<div class="loading" ></div>
			<div class="loading-text">loading</div>
	</div>
</div>

<!-- <div class="loading" id="loading"><strong><img src="http://192.168.40.194:8899/pwiscm/public/css/images/please_wait.gif" alt="Loading..." width="100" height="100"/></strong></div> -->

<!-- End Content -->
<script src="{{ asset('public') }}//js/select2.min.js"></script>
<script src="{{ asset('public') }}//js/jquery.validate.js"></script>
<script type="text/javascript" src="{{ asset('public') }}/js/jquery.dataTables.js"></script>

<script>
$(document).ajaxStart(function(){
    $('#loading').show();
 }).ajaxStop(function(){
    $('#loading').hide();
 });

	var obj = new Object();
	obj.SelectedPO = "0";
	obj.y = 0;
	obj.w = -1;

	$("#formEntry").validate({
		rules:{
            out_date: {
                required: true
            }
						/*
						,
            inv_no: {
                required: true
            }
						*/
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
				type: "POST",
				url: "{{ url('/') }}/dncreate/savemaster",
				data: $(form).serialize(),
				success: function (json)
				{

					if(json.data.ERR_FLAG == "S")
					{
						var textType = "created";
						if($("#out_no").val() !== "")
						{
							textType = "updated";
						}

						$.bootstrapGrowl("GRN Number "+textType+", you can continue to insert the DN Detail in below form!", {
							type: "success",offset: {from: 'top', amount: 250},align: 'center'
						});

						$("#out_no").val(json.data.OUT_NO);
						filterDetail();
						window.parent.filterMaster();
						//searchPO();

						/*
						$("#detailInsert").animate({
							opacity:1
						}, 500);
						*/
						//$("#blocker").hide();
						//$("#blocker").css("z-index",0);
						//$("#pintDN").show();

					}
					else{
						$.bootstrapGrowl("Failed to create GN Number: "+json.data.ERR_MSG, {
							type: "error",offset: {from: 'top', amount: 250},align: 'center'
						});
					}
				}
			});
			return false;
        }
	});


	var gridDetail = $('#gridDetail').DataTable( {
        ajax: {
            type: "GET",
        },
        select: true,
		columns: [
            { data: "OUT_SEQ", "width": "70px", className: "text-center" },
            { data: "PO_NO", "width": "150px", className: "text-center" },
            { data: "PO_SEQ", "width": "70px", className: "text-center" },
            { data: "BUYER", "width": "70px", className: "text-center" },
            { data: "O_NO", "width": "70px", className: "text-center" },
            { data: "O_SEQ", "width": "70px", className: "text-center" },
			{ data: "ARTNO", "width": "70px", className: "text-center" },
            { data: "ARTICLEDESC", "width": "70px" },
            { data: "BUYER", "width": "70px", className: "text-center" },
            { data: "GENDER_CD", "width": "70px", className: "text-center" },
            { data: "JOB_DESC", "width": "350px" },
			{ data: "PART_NM", "width": "150px" },
            { data: "COL_NM", "width": "70px", className: "text-center" },
			{ data: "UNIT", "width": "80px", className: "text-center" },
            { data: "SIZE_YN", "width": "70px", className: "text-center" },
            { data: "OUT_QTY", "width": "70px", render: $.fn.dataTable.render.number('0', '.', 0, ''), className: "text-right" },
            { data: "EXC_NM", "width": "70px", className: "text-center" },
			{ data: "EXC_RATE", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
			{ data: "UNIT_PRICE", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 5, ''), className: "text-right" },
			{ data: "OUT_AMT", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 2, ''), className: "text-right" }
        ],
        "scrollX": true,
        "order": [[ 1, "asc" ]],
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

	function filterDetail()
    {
		var out_date =  $("#out_date").val().replace(/-/g,"");
		var out_no = $("#out_no").val();
		gridDetail.ajax.url("{{url('/')}}/dncreate/detailcreatelist/"+out_date+"/"+out_no).load(null, false);
		$("#span-type").html("Request");
    }

	$(".exportDetail").on("click", function() {
		gridDetail.button('.buttons-excel').trigger();
    });

	obj.InsertedPO = "0";
	obj.InsertedPOSeq = "";

	$('#gridDetail tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridDetail.row(this).selector.rows).addClass("hightLight");

		var data = gridDetail.row(this).data();

		obj.InsertedPO = $("#out_no").val();
		obj.InsertedPOSeq = data.OUT_SEQ;

		//filterSize(data.PO_NO, data.PO_SEQ);

		var out_date =  $("#out_date").val().replace(/-/g,"");
		var out_no = $("#out_no").val();

		filterSize(data.PO_NO, data.PO_SEQ, out_date, out_no, data.O_SEQ, data.BUYER, data.GENDER_CD);
	});

	var gridSize = $('#gridSize').DataTable( {
        ajax: {
            type: "GET",
        },
        columns: [
            { data: "UKSIZE" },
            { data: "PO_QTY", render: $.fn.dataTable.render.number('0', '.', 0, ''), className: "text-right", "width": "70px"  },
            { data: "DELIVERED_QTY", render: $.fn.dataTable.render.number('0', '.', 0, ''), className: "text-right", "width": "60px"  },
            { data: "BAL_QTY", render: $.fn.dataTable.render.number('0', '.', 0, ''), className: "text-right", "width": "60px"  },
            { data: "NOTE_QTY", render: $.fn.dataTable.render.number('0', '.', 0, ''), className: "text-right", "width": "60px"  },
		],
		"scrollX": true,
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
	/*
	function filterSize(po_number, seq_number)
    {
		//"/dncreate/listsize/{po_number}/{po_seq}/{out_date}/{out_number}/{out_seq}/{buyer}/{gender}";
		gridSize.ajax.url("{{url('/')}}/po/sizelist/"+po_number+"/"+seq_number).load();
		$("#span-type").html("Request");
	}
	*/

	function filterSize(po_number, po_seq, out_date, out_number, out_seq, buyer, gender)
    {
		//"/dncreate/listsize/{po_number}/{po_seq}/{out_date}/{out_number}/{out_seq}/{buyer}/{gender}";
		gridSize.ajax.url("{{url('/')}}/dncreate/listsize/"+po_number+"/"+po_seq+"/"+out_date+"/"+out_number+"/"+out_seq+"/"+buyer+"/"+gender).load();
		$("#span-type").html("Request");
	}

	var x = 0;
	var y = 0;
	var w = -1;
	var gridPO = $('#gridPO').DataTable( {
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
					return "<div style='text-align:center;'><input type='checkbox' class='checkit' name='label_id"+x+"' id='label_id"+x+"' value='"+row.LBL_ID+"'></div>";
                }
			}
        ],
        columns: [
            { data: "LBL_ID", "width": "10px", className: "text-center"},
            { data: "LBL_ID", "width": "100px", className: "text-center" },
            { data: "PO_NO", "width": "150px", className: "text-center" },
            { data: "PO_SEQ", "width": "70px", className: "text-center" },
            { data: "BUYER", "width": "70px", className: "text-center" },
            { data: "O_NO", "width": "70px", className: "text-center" },
            { data: "O_SEQ", "width": "70px", className: "text-center" },
            { data: "ARTICLEDESC", "width": "150px" },
            { data: "ARTNO", "width": "100px", className: "text-center" },
            { data: "UKSIZE", "width": "50px", className: "text-center" },
            { data: "QTY", "width": "100px", className: "text-right"}
		],
        "scrollX": true,
        "order": [[ 1, "asc" ]],
        "bSortCellsTop": true,
        "pageLength" : 5,
        "searching": false,
        "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
        "bJQueryUI": true,
        "fnDrawCallback": function( oSettings ) {
			obj.y = 0;
			obj.w = -1;
			$('.dt-buttons').css("display", "none");
            $('.data-table tbody tr').each( function() {
				obj.y++;

				this.setAttribute('style', "cursor:pointer");
				if ($(this).find('td:eq(0) :input').attr('id') !== undefined){

					var id = $(this).find('td:eq(0) :input').attr('id');
					$("#"+id).attr('id', "label_id" + obj.y);
					$("#"+id).attr('name', "label_id" + obj.y);
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

	function searchPO()
    {


		var po_no = $("#po_no").val();
		var o_no = $("#o_no").val();
		if(po_no == "") {
			po_no = 0;
		}

		if(o_no == "") {
			o_no = 0;
		}


		gridPO.ajax.url("{{url('/')}}/dncreate/searchpo/"+po_no+"/"+o_no).load(null, false);
		$("#span-type").html("Request");

		setTimeout(function(){
			$("#check_all").attr("checked", false);
		}, 500)
		/*
		if(po_no !== "")
		{
			gridPO.ajax.url("{{url('/')}}/dncreate/searchpo/"+po_no).load();
			$("#span-type").html("Request");

		}
		else{
			$.bootstrapGrowl("Please enter the PO Number ", {
				type: "error"
			});
		}
		*/

		var currentPage = gridPO.page();
		gridPO.page(0).draw( 'page' );

	}

	function checkAll(obj){
		var totalRow = gridPO.data().count();
		if(obj.is(':checked'))
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

	function addChecked()
	{
		//var out_no = '23234234';
		var out_no = $("#out_no").val();
		if(out_no !== "")
		{
			var totalRow = gridPO.data().count();
			var selectedLabel = "";
			var totalSelected = 0
			for(var x = 1; x <= totalRow; x++)
			{
				console.log($("#label_id" + x).val());
				if($("#label_id" + x).is(':checked'))
				{
					console.log(x);
					totalSelected++;
					selectedLabel+= $("#label_id" + x).val()+"|";
				}
			}

			if(totalSelected > 0)
			{
				var out_date_v =  $("#out_date").val().replace(/-/g,"");
				var labels_v = selectedLabel.substring(0, selectedLabel.length - 1);

				var wh_v = $("#wh").val();
				var out_no_v = $("#out_no").val();


				$.ajax({
					type: "POST",
					url: "{{ url('/') }}/dncreate/adddetail",
					headers: {
						'X-CSRF-TOKEN': "{{ csrf_token() }}"
					},
					data : {
						out_date: out_date_v,
						out_no: out_no_v,
						wh: wh_v,
						labels: labels_v,
					},
					success: function (json) {
						if(json.data.ERR_FLAG == "S")
						{
							$.bootstrapGrowl("Label(s) Added to detail Delivery Note", {
								type: "success",offset: {from: 'top', amount: 250},align: 'center'
							});
							filterDetail();
							obj.y = 0;
							obj.w = -1;
							searchPO();
						}
						else{
							$.bootstrapGrowl("Failed to add PO: "+json.data.ERR_MSG, {
								type: "error",offset: {from: 'top', amount: 250},align: 'center'
							});
						}
					}
				});

			}
			else{
				$.bootstrapGrowl("No selected data!", {
					type: "error",offset: {from: 'top', amount: 250},align: 'center'
				});
			}
		}
		else{
			$.bootstrapGrowl("You need to create GRN Number, please complete the master entry!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
		}

	}

	function deleteInserted()
	{
		//var out_no = '23234234';
		var out_no = $("#out_no").val();
		if(out_no !== "")
		{
			if(obj.InsertedPO != 0)
			{
				confirmCallback("Are you sure want to delete this data?", function(){
					var out_date_v =  $("#out_date").val().replace(/-/g,"");
					var out_no_v = obj.InsertedPO;
					var sequence_v = obj.InsertedPOSeq;
					console.log("seeq" + sequence_v);

					$.ajax({
						type: "POST",
						url: "{{ url('/') }}/dncreate/deleteinserted",
						headers: {
							'X-CSRF-TOKEN': "{{ csrf_token() }}"
						},
						data : {
							out_date: out_date_v,
							out_no: out_no_v,
							sequence: sequence_v
						},
						success: function (json) {
							if(json.data.ERR_FLAG == "S")
							{
								$.bootstrapGrowl("data Deleted!", {
									type: "success",offset: {from: 'top', amount: 250},align: 'center'
								});
								filterDetail();
								//filterSize(0, 0);
								filterSize(0, 0, 0, 0, 0, 0, 0);
								obj.y = 0;
								obj.w = -1;
								searchPO();
							}
							else{
								$.bootstrapGrowl("Failed to Delete PO: "+json.data.ERR_MSG, {
									type: "error",offset: {from: 'top', amount: 250},align: 'center'
								});
							}
						}
					});

				});
			}
			else{
				$.bootstrapGrowl("No selected data!", {
					type: "error",offset: {from: 'top', amount: 250},align: 'center'
				});
			}
		}
		else{
			$.bootstrapGrowl("You need to create GRN Number, please complete the master entry!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
		}

	}

	function printDN()
	{
		var out_no = $("#out_no").val();
		var out_date =  $("#out_date").val().replace(/-/g,"");

		if(out_no !== "")
		{
            popUp("{{url('/')}}/dncreate/dnprint/"+out_no+"/"+out_date, '1250px', '650px', 'Print Preview')
		}
		else{
			$.bootstrapGrowl("Please complete the DN master!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
		}

	}

	$(document).ready(function(){
		//

		@if(isset ($edit))
		//searchPO();
		filterDetail();
		@endif
	});


    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }
</script>
@endsection
