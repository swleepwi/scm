@extends('template.headerform')
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

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}


</style>
<!--Content Title -->
<div id="content-header">

</div>
<!-- End Content Title -->
@endsection

@section('content')


<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
		<div class="widget-box">


			<div class="widget-content">
				<div style="display: inline-block">


                    <div class="control-group">
                        <label class="control-label">Barcode </label>
                        <div class="controls">
                            <input type="number" onkeydown="barcodeScan(event, $(this));" name="label_scan" maxlength="8" id="label_scan" style="width: 200px; height: 30px; font-size: 26px !important; background-color: #cef1f3;">
                        </div>
                    </div>
                </div>
			</div>

		</div>
		</div>
	</div>
</div>

<input type="hidden" name="selected_label" id="selected_label" value="">
<input type="hidden" name="selected_linkno" id="selected_linkno" value="">

<div class="container-fluid">
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title widget_title_white">
                <h5>Barcode Info</h5>
                <div class='export_table'>
                    <button class="btn-small btn-mini btn_pwi" onclick="deleteLabel()"><i class="icon icon-trash"></i> Delete</button>
                </div>
            </div>

            <div class="widget-content nopadding">
                <table id="gridMaster" class="table table-bordered data-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>PO No</th>
                            <th>PO Seq</th>
                            <th>Buyer</th>
                            <th>Order No</th>
                            <th>Order Seq</th>
                            <th>Article</th>
                            <th>Model</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Scan Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
<div class="loading-container" id="loading">
    <div class="loading" ></div>
    <div class="loading-text">loading</div>
</div>
<script type="text/javascript" src="{{ asset('public') }}/js/jquery.dataTables.js"></script>

<script>
$(document).ajaxStart(function(){
    $('#loading').show();
 }).ajaxStop(function(){
    $('#loading').hide();
 });
    $(document).ready(function(){
        $("#label_scan").focus();
    });

    $('input[type=number]').on('mousewheel', function(e) {
        $(e.target).blur();
    });

    $(document).on('input', ':input[type="number"][maxlength]', function () {
        if (this.value.length > this.maxLength) {
            this.value = this.value.slice(0, this.maxLength);
        }
    });

    var gridMaster = $('#gridMaster').DataTable( {
        ajax: {
            type: "GET",
            url: "{{url('/')}}/barcode/scanneddata",
        },
        select: true,
		columns: [
            { data: "LBL_ID", "width": "100px", className: "text-center"  },
            { data: "PO_NO", "width": "150px", className: "text-center"  },
            { data: "PO_SEQ", "width": "70px", className: "text-center" },
            { data: "BUYER", "width": "70px", className: "text-center" },
            { data: "O_NO", "width": "100px", className: "text-center"  },
            { data: "O_SEQ", "width": "70px", className: "text-center"  },
            { data: "ARTNO", "width": "50px", className: "text-center"  },
            { data: "ARTICLEDESC", "width": "150px", className: "text-center"  },
            { data: "UKSIZE", "width": "70px", className: "text-center"  },
            { data: "QTY", "width": "70px", render: $.fn.dataTable.render.number('0', '.', 0, ''), className: "text-right" },
            { data: "MODIFY_DATE", "width": "150px", className: "text-center"  },
        ],
        "scrollX": true,
        "order": [[ 9, "desc" ]],
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
        gridMaster.button( '.buttons-excel' ).trigger();
    });

	function filterMaster()
    {
		gridMaster.ajax.url("{{url('/')}}/barcode/scanneddata").load();
        $("#span-type").html("Request");

        $("#selected_label").val('');
        $("#selected_linkno").val('');
    }

	$('#gridMaster tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridMaster.row(this).selector.rows).addClass("hightLight");
        var data = gridMaster.row(this).data();

        $("#selected_label").val(data.LBL_ID);
        $("#selected_linkno").val(data.LINK_NO);
    });

    function barcodeScan(event, obj) {
        var x = event.which || event.keyCode;
        if(x === 13)
        {
            var value = obj.val();

            $.ajax({
				type: "POST",
				url: "{{ url('/') }}/barcode/scaninsert",
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				},
				data : {
					label_id: value
				},
				success: function (json) {
                    console.log(json)
					if(json.data.ERR_FLAG == "S")
					{
                        filterMaster();

					}
					else{
						$.bootstrapGrowl("Scan failed: "+json.data.ERR_MSG, {
							type: "error",offset: {from: 'top', amount: 250},align: 'center'
						});
					}
				}
            });

            obj.val("");
            obj.focus();
        }

    }

    function deleteLabel()
    {
        if($("#selected_label").val() == "")
        {
            $.bootstrapGrowl("No data selected", {
                type: "error",offset: {from: 'top', amount: 250},align: 'center'
            });
        }
        else{
            confirmCallback("Are you sure want to delete this data?", function(){
                $.ajax({
                    type: "POST",
                    url: "{{ url('/') }}/barcode/scandelete",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data : {
                        label_id: $("#selected_label").val(),
                        link_no: $("#selected_linkno").val()
                    },
                    success: function (json) {
                        console.log(json)
                        if(json.data.ERR_FLAG == "S")
                        {
                            filterMaster();
                            $("#selected_label").val('');
                            $("#selected_linkno").val('');
                            $("#label_scan").focus();
                        }
                        else{
                            $.bootstrapGrowl("Delete failed: "+json.data.ERR_MSG, {
                                type: "error",offset: {from: 'top', amount: 250},align: 'center'
                            });
                        }
                    }
                });
            });
        }

    }


    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }

</script>
@endsection
