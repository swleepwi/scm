
<?php $__env->startSection('page_heading'); ?>

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
        <a href="#"  class="tip-bottom content_title">Barcode Scan</a>
    </div>
</div>
<!-- End Content Title -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="container-fluid">
	<div class="row-fluid">
            <div class="widget-box">
                <div class="widget-content search_input_div">
                    <ul class="searh_input">
                        <li>
                            <label for="start_date">Date From :</label><input value="<?php echo e(date("Y-m-d", strtotime("-29 day", strtotime(date("Y-M-d"))))); ?>" type="date" style="width:120px" name="start_date" id="start_date">
                        </li>
                        <li>
                            <label for="end_date">Date To :</label><input  value="<?php echo e(date('Y-m-d')); ?>" type="date" style="width:120px" name="end_date" id="end_date">
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


<input type="hidden" name="selected_label" id="selected_label" value="">
<input type="hidden" name="selected_linkno" id="selected_linkno" value="">


<input type="hidden" name="selectedPONo" id="selectedPONo" value="">
<input type="hidden" name="selectedPOSeq" id="selectedPOSeq" value="">

<div class="container-fluid">

    <ul style="margin:0; padding:0; width:100%; position:relative">
        <li style="list-style-type: none;">
            <div class="row-fluid" style="width:79% !important;  position:relative; float:left">
            <div class="widget-box">
                        <div class="widget-title widget_title_white">
                            <h5>P/O Info</h5>
                            <div class='export_table'>
                                <button class="btn-small btn-mini btn_pwi" onclick="newScan()"><i class="icon icon-plus"></i> New Scan</button>
                                <button class='btn-small btn-mini btn_pwi exportMaster'><i class="icon icon-file-alt"></i> Export Excel</button>
                            </div>                
                        </div>
            
                        <div class="widget-content nopadding"> 
                            <table id="gridMaster" class="table table-bordered data-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Scan Date</th>
                                        <th>PO No</th>                           
                                        <th>PO Seq</th>                               
                                        <th>Buyer</th>  
				             <th>Order No</th>
                                        <th>Order  Seq</th>                            
                                        <th>Model</th>                           
                                        <th>Article</th>                          
                                        <th>Scan Qty</th>                            
                                        <th>Size Desc</th>
                                    </tr>
                                </thead>               
                            </table>
                        </div>
                    </div>
            </div>
        </li>
        <li style="list-style-type: none;">
            <div class="row-fluid" style="width:19% !important;  position:relative; float:right">
                <div class="widget-box">
                    <div class="widget-title widget_title_white">
                        <h5>Barcode Info</h5>
                        <div class='export_table'>
                            <button class="btn-small btn-mini btn_pwi" onclick="deleteLabel();"><i class="icon icon-trash"></i> Delete</button>
                        </div> 
                    </div>

                    <div class="widget-content nopadding"> 
                        <table id="gridSize" class="table table-bordered data-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Size</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>               
                        </table>
                    </div>
                </div>
            </div>



        </li>
    </ul>
</div>

<!-- End Content -->
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/jquery.dataTables.js"></script>

<script>
	
	var obj = new Object();
    obj.SelectedOutNo = "0";
    obj.SelectedOutDate = "";
    
	
	var start_date =  $("#start_date").val().replace(/-/g,"");
	var end_date =  $("#start_date").val().replace(/-/g,"");

    var gridMaster = $('#gridMaster').DataTable( {
        select: true,
		columnDefs: [         
            { 
                "targets": 0, 
                "data": 'creator', 
                "render": function (dt, type, row ) {
					
                    return row.IN_DATE.substr(0, 4)+'-'+row.IN_DATE.substr(4, 2)+'-'+row.IN_DATE.substr(6, 2); 
                }
            }
        ],		
        columns: [               
            { data: "IN_DATE", "width": "100px", className: "text-center"  },
            { data: "PO_NO", "width": "150px", className: "text-center"  },
            { data: "PO_SEQ", "width": "100px", className: "text-center" },
            { data: "BUYER", "width": "70px", className: "text-center" },
            { data: "O_NO", "width": "70px", className: "text-center"  },
            { data: "O_SEQ", "width": "60px", className: "text-center" },
            { data: "ARTICLEDESC", "width": "100px" },
            { data: "ARTNO", "width": "100px", className: "text-center"  },
            { data: "SCAN_QTY", "width": "60px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
            { data: "SIZE_RUN", "width": "250px" },
        ],		
        "scrollX": true,
        "order": [[ 0, "desc" ]],
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
			
			
			gridMaster.ajax.url("<?php echo e(url('/')); ?>/barcode/datalist/"+start_date+"/"+end_date+"/"+po_number+"/"+order_number).load();
			$("#span-type").html("Request");
		}
    }
	
	$('#gridMaster tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridMaster.row(this).selector.rows).addClass("hightLight");
		
        var data = gridMaster.row(this).data();
        filterSize(data.PO_NO, data.PO_SEQ);

        $("#selectedPONo").val(data.PO_NO);
        $("#selectedPOSeq").val(data.PO_SEQ);
        
        
        
	});
	
	var gridSize = $('#gridSize').DataTable( {
        ajax: {
            type: "GET",
        },
        columns: [               
            { data: "LBL_ID", className: "text-center"  },
            { data: "UKSIZE", className: "text-center"  },
            { data: "QTY", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"  },
        ],		
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
		gridSize.ajax.url("<?php echo e(url('/')); ?>/barcode/detailbarcode/"+po_number+"/"+seq_number).load();
		$("#span-type").html("Request");
    }

    $('#gridSize tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridSize.row(this).selector.rows).addClass("hightLight");		
        var data = gridSize.row(this).data();

        $("#selected_label").val(data.LBL_ID);
        $("#selected_linkno").val(data.LINK_NO);        
    });

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
                    url: "<?php echo e(url('/')); ?>/barcode/scandelete",
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                    },
                    data : {
                        label_id: $("#selected_label").val(),
                        link_no: $("#selected_linkno").val()
                    },
                    success: function (json) {
                        if(json.data.ERR_FLAG == "S")
                        {
                            filterSize($("#selectedPONo").val(), $("#selectedPOSeq").val());
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

    function newScan()
    {
        popUp("<?php echo e(url('/')); ?>/barcode/barcodescan", '1280px', '700px', 'New Barcode Scan')
    }
	
</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>