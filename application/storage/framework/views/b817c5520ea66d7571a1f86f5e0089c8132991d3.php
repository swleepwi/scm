<?php $__env->startSection('page_heading'); ?>
<!--Content Title -->
<div id="content-header">
    <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">Data Master</a>
        <a href="#" class="current">Customer</a>
    </div>
</div>
<!-- End Content Title -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('add_button'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <button class="btn-success btn-mini btn-inverse" id="modal" ><i class="icon icon-plus icon-white"></i> New Customer</button>
    </div> 
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row-fluid">
  <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-desktop"></i> </span>
                <h5>Customer Data</h5>                
            </div>

            <div class="widget-content nopadding"> 
                <table class="table table-bordered data-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>                            
                            <th>Married</th>                           
                            <th>Address</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>               
                </table>
            </div>
        </div>
  </div>
  <?php echo e(csrf_field()); ?>

</div>
<!-- End Content -->
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo e(asset('public')); ?>/js/datatables.checkboxes.js"></script>

<script>
    var table = $('.data-table').DataTable( {
        ajax: {
            url: "<?php echo e(url('/')); ?>/api/customer/listdata",
            "dataSrc": function (json) {
                return json.result.data;
            }
        },
        columnDefs: [         
            { 
                "targets": 1, 
                "data": 'creator', 
                "render": function (dt, type, row ) { 
                    return "<a href=\"mailto:"+row.email+"\">"+row.email+"</span></a>"; 
                }
            },
            {
                "targets": 3, 
                "data": 'creator', 
                "render": function (dt, type, row ) { 
                    let output = "no";

                    if(row.is_married == "1")
                    {
                        output = "yes"
                    }

                    return output;
                }
            },
            {
                "targets": 5, 
                "data": 'creator', 
                "render": function (dt, type, row ) { 
                    let output = "<div class=\"text-center\"><button class='btn btn-small btn-mini edit-row'><i class='icon icon-pencil'></i></button>&nbsp;<button class='btn btn-small btn-mini delete-row'><i class='icon icon-trash'></i></button></div>";
                    return output;
                }
            }
        ],

        columns: [               
            { data: "name" },
            { data: "email" },
            { data: "gender" },
            { data: "email" },
            { data: "address" },
            { data: "id" }
        ],
        "scrollX": true,
        "order": [[ 0, "asc" ]],
        "bSortCellsTop": true,
        "pageLength" : 50,
        "searching": true,
        "aLengthMenu": [[50, 100, 300, -1], [50, 100, 300, "All"]],
        "bJQueryUI": true
    });

   
    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }

    $('.data-table tbody').on('click', '.edit-row', function () {
        var data = table.row($(this).parents('tr')).data();
        popUp("<?php echo e(url('/')); ?>/form/"+data.id, '50%', '490px')
    });

    $('.data-table tbody').on('click', '.delete-row', function () {
        var data = table.row($(this).parents('tr')).data();

        if(confirm("Are you sure?"))
        {
            $.ajax({
                 type: "delete",
                 url: "<?php echo e(url('/')); ?>/api/customer/"+data.id,
                 success: function (json) {
                    if(json.status.code == "200")
                    {
                        $.bootstrapGrowl(json.status.message, {
                            type: "success"
                        });   

                        $('.data-table').DataTable().ajax.reload();
                                                
                    }
                    else{
                        $.bootstrapGrowl(json.status.message, {
                            type: "error"
                        });
                    }
                 }
             });
        }
        else{
            return false;
        }
       
    });
    

    $("#modal").click(function(){
        popUp("<?php echo e(url('/')); ?>/form", '50%', '490px')
    })

</script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>