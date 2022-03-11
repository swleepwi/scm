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
      <a href="#"  class="tip-bottom content_title">Barcode Scan</a>
  </div>
</div>
<!-- End Content Title -->
@endsection

@section('content')
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
		<div class="widget-box">

			<div class="widget-title"> <span class="icon"> <i class="icon-filter"></i> </span>
				<h5>Barcode</h5>
			</div>

			<div class="widget-content">
				<div style="display: inline-block">
					<div class="span6">


						<div class="control-group">
							<label class="control-label">Barcode scan</label>
							<div class="controls">
                            <input type="text" name="scan_input" id="scan_input" style='height:40px; width:120px;' onkeydown="barcodeScan(event, $(this))">
							</div>
                        </div>

                        <div class="control-group">
							<label class="control-label">Scan Result</label>
							<div class="controls">
								<div id="scanResult" style="font-size:20px; font-weight:bold;">

                                </div>
							</div>
						</div>



                    </div>


				</div>
			</div>

		</div>
		</div>
	</div>
</div>
<div class="loading-container" id="loading">
    <div class="loading" ></div>
    <div class="loading-text">loading</div>
</div>
<script>
$(document).ajaxStart(function(){
    $('#loading').show();
 }).ajaxStop(function(){
    $('#loading').hide();
 });
    $(document).ready(function(){
        $("#scan_input").focus();
    });

    function barcodeScan(event, obj) {
        var x = event.which || event.keyCode;


        if(x === 13)
        {
            var value = obj.val();
            $("#scanResult").html(value);
            obj.val("");
            obj.focus();
        }


    }

	$("#modal").click(function(){
    popUp("{{url('/')}}/labelprint/printnow", '400px', '490px')
  })


    if($('.dataTables_empty').length){
        $('.dataTables_empty').html("No data");
    }
</script>
@endsection
