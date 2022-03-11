<?php $__env->startSection('page_heading'); ?>
<!--Content Title -->
<div id="content-header">
    <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#" class="current">Sales Order</a>
    </div>
</div>
<!-- End Content Title -->
<?php $__env->stopSection(); ?>

<!-- Start Content -->
<?php $__env->startSection('add_button'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <button class="btn-success btn-mini excelBtn" id="modal" ><i class="icon icon-file icon-white"></i> <span> Get CSV File</span></button>
    </div> 
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row-fluid">
  <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-desktop"></i> </span>
                <h5>Sales Order Data</h5>                
            </div>

            <div class="widget-content nopadding"> 
                <table class="table table-bordered data-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Order Date</th>
                            <th>Total Order Value</th>
                            <th>Average Unit Price</th>
                            <th>Distinct Unit Count</th>
                            <th>Total Unit Count</th>
                            <th>Customer State</th>
                        </tr>
                    </thead>               
                </table>
            </div>
        </div>
  </div>
</div>
<!-- End Content -->
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/datatables.checkboxes.js"></script>

<script>

    var table = $('.data-table').DataTable( {
        ajax: {
            type: "POST",
            url: "<?php echo e(url('/')); ?>/order/ajaxdata",
            headers: {
                'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
            }
        },
        columnDefs: [ 
        { 
            "targets": 2, 
            "data": 'creator', 
            "render": function (dt, type, row ) { 
                return '$'+row.total_order_value; 
            },
            className: 'text-right'
        }],

        buttons: [
            'copyHtml5',
            {
                extend: 'csvHtml5',
                title: 'out',
                customize: function (csv) {
                    var csvRows = csv.split('\n');
                    csvRows[0] = csvRows[0].replace('"Order Id"', '"order_id"');
                    csvRows[0] = csvRows[0].replace('"Order Date"', '"order_date"');
                    csvRows[0] = csvRows[0].replace('"Total Order Value"', '"total_order_value"');
                    csvRows[0] = csvRows[0].replace('"Average Unit Price"', '"average_unit_price"');
                    csvRows[0] = csvRows[0].replace('"Distinct Unit Count"', '"distinct_unit_count"');
                    csvRows[0] = csvRows[0].replace('"Total Unit Count"', '"total_unit_count"');
                    csvRows[0] = csvRows[0].replace('"Customer State"', '"customer_state"');
                    for(var x=1; x < csvRows.length; x++) {
                        csvRows[x] = csvRows[x].replace('$', '');
                    }
                    return csvRows.join('\n');
                }
            }                      
        ],

        columns: [               
            { data: "order_id" },
            { data: "order_date" },
            { data: "total_order_value" },
            { data: "average_unit_price" },
            { data: "distinct_unit_count" },
            { data: "total_units_count" },
            { data: "customer_state" },
        ],
        
        "order": [[ 0, "asc" ]],
        "bSortCellsTop": true,
        "pageLength" : 50,
        "searching": true,
        "aLengthMenu": [[50, 100, 300, -1], [50, 100, 300, "All"]],
        "bJQueryUI": true
    });

    $('.data-table tbody').on('click', 'modify', function () {
        var data = table.row($(this).parents('tr')).data();
        //var data = table.api().row($(this).parents('tr')).data();
    });

    $('.data-table tbody').on('click', 'remove', function () {
        var data = table.row($(this).parents('tr')).data();
        //Confirm("Are you sure want to delete this data?", "/category/delete/"+data.id);
    });

    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }


    $(".excelBtn").on("click", function() {
        table.button( '.buttons-csv' ).trigger();
    });

</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>