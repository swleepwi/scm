
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
        <a href="javascript:void();" class="tip-bottom content_title">Delivery Note</a>
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
						<button onclick="$('#is_search').val('1'); filterMaster();" type="button" id="button_save" value="Save" class="btn-small btn-mini search_btn bottom10"><i class="icon-zoom-in"></i> Search</button>
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
                    <button class="btn-small btn-mini btn_pwi" onclick="newDN('<?php echo e(url('/')); ?>/dncreate/new')"><i class="icon icon-plus"></i> New</button>
                    <button class="btn-small btn-mini btn_pwi" onclick="modifyThis();"><i class="icon icon-pencil"></i> Modify</button>
                    <button class="btn-small btn-mini btn_pwi" onclick="deleteMaster();"><i class="icon icon-trash"></i> Delete</button>
                    <button class="btn-small btn-mini btn_pwi" onclick="printDN();"><i class="icon icon-print"></i> Print</button>
                    <button class='btn-small btn-mini btn_pwi exportMaster'><i class="icon icon-file-alt"></i> Export Excel</button>
                    
                </div>                
            </div>

            <div class="widget-content nopadding"> 
                <table id="gridMaster" class="table table-bordered data-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>OUT Date</th>
                            <th>GRN</th>
                            <th>P/O or NPO</th>                            
                            <th>Delivery Man</th>                           
                            <th>Container No</th>                            
                            <th>Invoice No</th>                            
                            <th>PPN</th>                            
                            <th>Mobil No</th>                            
                            <th>Deli Order No</th>
							<th>Remark</th>
							<th>Buyer In Date</th>
                            <th>Modify Date</th>
                        </tr>
                    </thead>               
                </table>
            </div>
        </div>
  </div>
  <?php echo e(csrf_field()); ?>

</div>
<input type="hidden" name="is_search" id="is_search" value="0">
<div class="container-fluid">
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title  widget_title_white">
                <h5>Detail Info</h5>
                <div class='export_table'>
                    <button class='btn-small btn-mini btn_pwi exportMaster'><i class="icon icon-file-alt"></i> Export Excel</button>
                </div>                
            </div>

            <div class="widget-content nopadding"> 
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
                            <th>Job Desc</th>                            
                            <th>Component</th>
                            <th>Color</th>
                            <th>Unit</th>
                            <th>Size Y/N</th>
                            <th>Scan Qty</th>
                            <th>Currency</th>
                            <th>Exc Rate</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th>Size Desc (Size/Qty)</th>
                            <th>Remarks </th>
                            <th>P/O No</th>
                            <th>P/O  Seq</th>
                        </tr>
                    </thead>               
                </table>
            </div>
        </div>
    </div>
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
					
                    return row.OUT_DATE.substr(0, 4)+'-'+row.OUT_DATE.substr(4, 2)+'-'+row.OUT_DATE.substr(6, 2); 
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
            { data: "OUT_DATE", "width": "150px", className: "text-center"  },
            { data: "OUT_NO", "width": "70px", className: "text-center"  },
            { data: "POMDOYN", "width": "70px", className: "text-center"  },
            { data: "DELI_USER", "width": "80px" },
            { data: "CONTAIN_NO", "width": "100px" },
            { data: "INV_NO", "width": "100px" },
            { data: "VAT_RATE", "width": "100px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right"   },
            { data: "MOBIL_NO", "width": "100px" },
            { data: "DELI_ORD_NO", "width": "100px" },
            { data: "REMARK", "width": "150px", className: "text-center"  },
            { data: "BUYER_IN_DATE", "width": "80px", className: "text-center"  },
            { data: "MODIFY_DATE", "width": "80px", className: "text-center"  }
        ],		
        "scrollX": true,
        "order": [[ 0, "desc" ], [ 1, "desc" ]],
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
        
        var is_search = $("#is_search").val();
        if(is_search == "1")
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
                
                
                gridMaster.ajax.url("<?php echo e(url('/')); ?>/dnview/datalist/"+start_date+"/"+end_date+"/"+po_number+"/"+order_number).load(null, false);
                $("#span-type").html("Request");

                gridDetail.clear().draw();
            }
        }
		
    }
	
	$('#gridMaster tbody').on('click', 'tr', function(){
		$(document).find('tr').removeClass("hightLight");
		$(gridMaster.row(this).selector.rows).addClass("hightLight");
		
        var data = gridMaster.row(this).data();
        filterDetail(data.OUT_DATE, data.OUT_NO);

        obj.SelectedOutNo = data.OUT_NO;
        obj.SelectedOutDate = data.OUT_DATE;
        
	});
	
	var gridDetail = $('#gridDetail').DataTable( {
        ajax: {
            type: "GET",
        },
        select: true,		
        columns: [               
            { data: "OUT_SEQ", "width": "70px", className: "text-center"  },
            { data: "BUYER", "width": "70px", className: "text-center"  },
            { data: "O_NO", "width": "70px", className: "text-center"  },
            { data: "O_SEQ", "width": "70px", className: "text-center"  },
            { data: "ARTNO", "width": "70px", className: "text-center"  },
            { data: "ARTICLEDESC", "width": "100px", className: "text-center"  },
            { data: "GENDER_CD", "width": "70px", className: "text-center"  },
            { data: "JOB_DESC", "width": "350px"  },
            { data: "PART_NM", "width": "150px" },
            { data: "COL_NM", "width": "70px", className: "text-center"  },
            { data: "UNIT", "width": "70px", className: "text-center"  },
            { data: "SIZE_YN", "width": "70px", className: "text-center"  },
            { data: "SCAN_QTY", "width": "70px", render: $.fn.dataTable.render.number('0', '.', 0, ''), className: "text-right"  },
            { data: "EXC_NM", "width": "70px", className: "text-center"  },
            { data: "EXC_RATE", "width": "80px", render: $.fn.dataTable.render.number('.', '.', 0, ''), className: "text-right" },
            { data: "UNIT_PRICE", "width": "80px", render: $.fn.dataTable.render.number('.', '.', 5, ''), className: "text-right" },
            { data: "OUT_AMT", "width": "80px", render: $.fn.dataTable.render.number('.', '.', 2, ''), className: "text-right"  },
            { data: "SIZE_RUN", "width": "150px" },
            { data: "REMARK", "width": "100px", className: "text-center"  },
            { data: "PO_NO", "width": "150px", className: "text-center"  },
            { data: "PO_SEQ", "width": "70px", className: "text-center"  },
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
				previous: '<<' // or '←' 
			},
			"sLengthMenu": "_MENU_",
			"emptyTable": "No data"
		} ,
		"infoCallback": function( settings, start, end, max, total, pre ) {
			var mulai = start;
			if(end == 0) {
				mulai = 0;
			}
			return mulai +" - "+ end +" of " + total;
		}
    });
		
		
	function filterDetail(out_date, out_number)
    {        		
        console.log("<?php echo e(url('/')); ?>/dnview/detaildatalist/"+out_date+"/"+out_number);
		gridDetail.ajax.url("<?php echo e(url('/')); ?>/dnview/detaildatalist/"+out_date+"/"+out_number).load();
		$("#span-type").html("Request");
    }
	
	$(".exportDetail").on("click", function() {
		gridDetail.button( '.buttons-excel' ).trigger();		
    });

    function modifyThis()
    {
        
        if(obj.SelectedOutNo == "0")
        {
            $.bootstrapGrowl("No Data selected!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			});
        }
        else{
            var out_no = obj.SelectedOutNo;
            var out_date = obj.SelectedOutDate;
            //window.location = "<?php echo e(url('/')); ?>/dncreate/new/"+out_no+"/"+out_date;

            newDN("<?php echo e(url('/')); ?>/dncreate/new/"+out_no+"/"+out_date);
        }
    }

    function deleteMaster()
	{	
		if(obj.SelectedOutNo !== "0")
		{
			confirmCallback("Are you sure want to delete this data?", function(){
                var out_date_v =  obj.SelectedOutDate;
                var out_no_v =  obj.SelectedOutNo;
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo e(url('/')); ?>/dncreate/deletemaster",
                    headers: {
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                    },
                    data : {
                        out_date: out_date_v,
                        out_no: out_no_v
                    },
                    success: function (json) {
                        filterMaster();
                        filterDetail(out_date_v, out_no_v);
                    }
                });
                
            });
		}
		else{
			$.bootstrapGrowl("No Selected Data!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			}); 
		}
		
    }
    
    function printDN()
	{	
		if(obj.SelectedOutNo !== "0")
		{
            popUp("<?php echo e(url('/')); ?>/dncreate/dnprint/"+obj.SelectedOutNo+"/"+obj.SelectedOutDate, '1280px', '700px', 'Print Preview')
		}
		else{
			$.bootstrapGrowl("No Selected Data!", {
				type: "error",offset: {from: 'top', amount: 250},align: 'center'
			}); 
		}
		
	}
    
    
    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }

    function newDN(url)
    {
        popUp(url, '1280px', '700px', 'Delivery Note Input')
    }
    
	
</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>