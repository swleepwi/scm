
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/uniform.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/select2.css" />
<script src="<?php echo e(asset('public')); ?>/plugins/barcode128/JsBarcode.all.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/barcode128/barcode128.js"></script>
<style>
    body{
        width:100%; 
    }

    .labelPrint{
        width:80%;
        margin-left: auto;
        margin-right: auto;
        border-right:solid 1px #000 !important;
        border-bottom:solid 1px #000 !important;
        
    }
    .labelPrint tr td{
        border: solid 1px #000;
        padding: 2px;
        text-align: center;
        font-weight:normal;
        line-height: 15px;
        font-size: 12px !important;
        border-width:1px 0 0 1px !important;
    }

    .fieldColumn{
        background-color: #ccc;
            font-weight:normal;
            font-family: 'OpenSans-normal' !important,
    }

    .valueColumn{
        font-weight:normal !important;
            font-weight:normal  !important;
            font-family: 'OpenSans-normal' !important,
    }
    .bigNumber{
        font-size: 20px  !important;
        font-weight:normal  !important;
    }
    .img_barcode{
        display: none;
        height: 60px !important;
    }
    @media  print {
        body{
            width:94%; 
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .labelPrint{
        width:95%;
        margin-left: auto;
        margin-right: auto;
        border-right:solid 1px #000 !important;
        border-bottom:solid 1px #000 !important;
            
        }
        .labelPrint tr td{
            border: solid 1px #000 !important;
            padding: 2px;
            text-align: center;
            font-weight:normal;
            line-height: 10px;
            font-size: 8px !important;
            
             border-width:1px 0 0 1px !important;
        }

        .fieldColumn{
            background-color: #ccc;
            font-weight:normal;
        }

        .valueColumn{
            font-weight:normal !important;
            font-weight:normal  !important;
        }

        .bigNumber{
            font-size: 20px !important;
            font-weight:normal  !important;
        }

    }
</style>
<br/>
<div style="margin-bottom:15px" id="printControl">
    <button class="btn-small btn-mini btn_pwi" type="button" onclick="printBarcode();"><i class="icon icon-print"></i> Print</button>
    <button class="btn-small btn-mini btn_pwi" type="button" id="pdfto"><i class="icon icon-file"></i> PDF</button>
</div>
<div id="barcode">
    <?php  
    $x = 0;
     
     ?>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php  $x++;  ?>
    <?php if($x == 1): ?>
    <div class="br" style="display: none;">        
        <br/><br/>
    </div>
    <?php endif; ?>
    <table class="labelPrint" style="margin-top:10px !important;">
        <tr>
            <td style='width:100px' class='fieldColumn'>P/O</td>
            <td colspan="3"><?php echo e($row->PO_NO); ?></td>
        </tr>
        <tr>
            <td class='fieldColumn'>BREND PO</td>
            <td colspan="3"><?php echo e($row->O_NO); ?></td>
        </tr>
        <tr>
            <td class='fieldColumn'>SUPPLIER</td>
            <td colspan="3" class='valueColumn'><?php echo e($row->CST_NM); ?></td>
        </tr>
        <tr>
            <td class='fieldColumn'>MODEL</td>
            <td colspan="3" class='valueColumn'><?php echo e($row->ARTICLEDESC); ?></td>
        </tr>    
        <tr>
            <td class='fieldColumn'>GENDER</td>
            <td class='valueColumn' style="width:50px"><?php echo e($row->GENDER_CD); ?></td>
            <td class='fieldColumn' style="font-size: 8px !important; padding-left:10px; padding-right:10px;">ART_NO</td>
            <td class='valueColumn' style="width:70px"><?php echo e($row->ARTNO); ?></td>
        </tr>
        <tr>
            <td class='fieldColumn'>COLOR</td>
            <td colspan="3" class='valueColumn'><?php echo e($row->COL_NM); ?></td>
        </tr>
        <tr>
            <td class='fieldColumn bigNumber' style="font-size:14px !important; font-weight:bold !important;"><?php echo e($row->UKSIZE); ?></td>
            <td class='valueColumn' colspan='3' rowspan="2" style="!important; vertical-align: bottom !important;  font-weight:bold !important;">
                <svg id="barcode<?php echo e($x); ?>"></svg>
                <input type="hidden" name="label_id<?php echo e($x); ?>" id="label_id<?php echo e($x); ?>" value="<?php echo e($row->LBL_ID); ?>">
            </td>
        </tr>
        <tr>
            <td class='fieldColumn bigNumber' style="font-size:14px !important; font-weight:bold !important;"><?php echo e(number_format($row->LABEL_QTY)); ?></td>
        </tr>
    </table>

    <?php if(count($data) > 1 && $x < count($data)): ?>
    <div style="page-break-after: always;"></div>
    <?php endif; ?>

    <script>
        JsBarcode("#barcode<?php echo e($x); ?>", "<?php echo e($row->LBL_ID); ?>", {
            lineColor: "#000",
            width:2,
            height:40,
            fontSize: 12
        });           
        
    </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <input type="hidden" name="jumlah" id="jumlah" value="<?php echo e($x); ?>">
    
    <?php if($x == 1): ?>
    <div class="br">        
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    </div>
    <?php endif; ?>

    <div class="br" style="display: none;">        
        <br/><br/>
    </div>
</div>


<script src="<?php echo e(asset('public')); ?>//js/select2.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>//js/jquery.validate.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<script type="text/javascript">

function getPDF(tPage){
   
    var HTML_Width = $("#barcode").width();
    var HTML_Height = $("#barcode").height();
    var top_left_margin = 0;
    var PDF_Width = HTML_Width+(top_left_margin*2);

    /*
    var jumlah = $("#jumlah").val();
    if(jumlah == "1")
    {
        
        HTML_Width =  $("#barcode").width();    
        HTML_Height = 400;        
        PDF_Width = HTML_Width+(top_left_margin*2);
    }
    */
    
    var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
    var PDF_Height_kertas = $(".labelPrint").height();
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;
    
    //alert(HTML_Height);


    html2canvas($("#barcode")[0],{allowTaint:true, dpi:600, scale:3}).then(function(canvas) {
        canvas.getContext('2d');       
        
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt',  [HTML_Width, HTML_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height + 20);
        pdf.save("BarcodeList.pdf");
        
    });
};
$('#pdfto').click(function () {

    if( $('.br').length)
    {
        $(".br").show();        
    }

    getPDF();
});


function setToExcel(){
    
    for(var x = 1; x <= $("#jumlah").val(); x++)
    {
        saveToImage($("#image_barcode"+x).attr("src"), $("#label_id"+x).val(), "image_barcode"+x, "barcode"+x);
    }   

    setTimeout(function(event){
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#barcode').html()));
        event.preventDefault();
    },1000);
}

function printBarcode(){
    if( $('.br').length)
    {
        $(".br").hide();        
    }

    for(var x = 1; x <= $("#jumlah").val(); x++)
    {
        $("#image_barcode"+x).hide();
        $("#barcode"+x).show();
    }   
    $('#printControl').hide(); print(document); $('#printControl').show();


    

}


function saveToImage(imgs, names, image_barcode_id, canvas_barcode_id){
    $.ajax({
        type: "POST",
        url: "<?php echo e(url('/')); ?>/label/export",
        headers: {
            'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
        },
        data : {
            img: imgs,
            name: names
        },
        success: function (json) {
            $("#"+image_barcode_id).prop("src", "<?php echo e(asset('public')); ?>/barcodes/"+names+".png");
            $("#"+image_barcode_id).show();
            $("#"+canvas_barcode_id).hide();
        }
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.headerblanklight', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>