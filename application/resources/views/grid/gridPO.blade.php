@extends('template.header')


@section('page_heading')
<!--Content Title -->
<div id="content-header">
    <div id="breadcrumb">
        <a href="#"  class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="#">PO Management</a>
        <a href="#" class="current">Purchase Order List</a>
    </div>
</div>
<!-- End Content Title -->
@endsection

@section('content')
<div class="container-fluid">
  <div class="row-fluid">
  <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-desktop"></i> </span>
                <h5>Purchase Order</h5>
            </div>

            <div class="widget-content nopadding">
                <table class="table table-bordered data-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>PO Date</th>
                            <th>PO Count</th>
                            <th>Complete</th>
                            <th>Factroy</th>
                            <th>Delivery Factroy</th>
                            <th>Currency</th>
                            <th>Exchange Rate</th>
                            <th>Payment Method</th>
							<th>Incoterms</th>
							<th>Pay Terms</th>
                            <th>Remarks</th>
                            <th>Modify Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
  </div>
  {{ csrf_field() }}
</div>
<div class="loading-container" id="loading">
    <div class="loading" ></div>
    <div class="loading-text">loading</div>
</div>
<!-- End Content -->
<script type="text/javascript" src="{{ asset('public') }}/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{ asset('public') }}/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ asset('public') }}/js/datatables.checkboxes.js"></script>

<script>
$(document).ajaxStart(function(){
    $('#loading').show();
 }).ajaxStop(function(){
    $('#loading').hide();
 });
    var table = $('.data-table').DataTable( {
        ajax: {
            type: "GET",
            url: "{{url('/')}}/po/datalist",
        },
        "bSort": false,
        select: true,
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
        "bJQueryUI": true,
        "fnDrawCallback": function( oSettings ) {
            $('.data-table tbody tr').each( function() {
                this.setAttribute('style', "cursor:pointer");
            });
        }
    });


    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }

    $('.data-table tbody').on('click', '.edit-row', function () {
        var data = table.row($(this).parents('tr')).data();
        popUp("{{url('/')}}/form/"+data.id, '50%', '490px')
    });

    $('.data-table tbody').on('click', '.delete-row', function () {
        var data = table.row($(this).parents('tr')).data();

        if(confirm("Are you sure?"))
        {
            $.ajax({
                 type: "delete",
                 url: "{{url('/')}}/api/customer/"+data.id,
                 success: function (json) {
                    if(json.status.code == "200")
                    {
                        $.bootstrapGrowl(json.status.message, {
                            type: "success",offset: {from: 'top', amount: 250},align: 'center'
                        });

                        $('.data-table').DataTable().ajax.reload();

                    }
                    else{
                        $.bootstrapGrowl(json.status.message, {
                            type: "error",offset: {from: 'top', amount: 250},align: 'center'
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
        popUp("{{url('/')}}/form", '50%', '490px')
    })

</script>
@endsection
