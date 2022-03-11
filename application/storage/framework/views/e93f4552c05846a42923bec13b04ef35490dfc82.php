
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/uniform.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/select2.css" />
<style>
    body{
        width:100%; 
    }

    .labelPrint{
        width:90%;
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
        line-height: 18px;
        font-size: 14px !important;
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
            width:100%; 
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .labelPrint{
            width:94%;
            margin-left: auto;
            margin-right: auto;
            border-right:solid 1px #000 !important;
            border-bottom:solid 1px #000 !important;
            
        }
        .labelPrint tr td{
            border: solid 1px #000 !important;
            padding: 0px;
            text-align: center;
            font-weight:normal;
            line-height: 12px;
            font-size: 11px !important;
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
            font-size: 18px !important;
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
    <div  id='tableLabel<?php echo e($x); ?>' class='buatPdf'>
        <table class="labelPrint" style="margin-top:5px !important;">
        
            <tr>
                <td class='fieldColumn'>BREND PO</td>
                <td colspan="3"><?php echo e($row->O_NO); ?></td>
            </tr>
            
            <tr>
                <td class='fieldColumn'>MODEL</td>
                <td colspan="3" class='valueColumn'><?php echo e($row->ARTICLEDESC); ?></td>
            </tr>  
            
            <tr>
                <td class='fieldColumn'>GENDER</td>
                <td class='valueColumn' style="width:80px"><?php echo e($row->GENDER_CD); ?></td>
                <td class='fieldColumn' style="padding-left:10px; padding-right:10px;">ART_NO</td>
                <td class='valueColumn' style="width:70px"><?php echo e($row->ARTNO); ?></td>
            </tr>  
            <tr>
                <td style='width:100px' class='fieldColumn'>P/O</td>
                <td colspan="3"><?php echo e($row->PO_NO); ?></td>
            </tr>
            <tr>
                <td class='fieldColumn'>SUPPLIER</td>
                <td colspan="3" class='valueColumn'><?php echo e($row->CST_NM); ?></td>
            </tr>
            <tr>
                <td class='fieldColumn bigNumber' >SIZE</td>
                <td class='fieldColumn bigNumber' style="font-weight:bold !important;  font-size: 16px !important;"><?php echo e($row->UKSIZE); ?></td>
                <td class='valueColumn' colspan='2' rowspan="2" style="!important; vertical-align: bottom !important;  font-weight:bold !important; text-align: center !important;">
                    <div id="barcode<?php echo e($x); ?>" style="width:55px; margin:auto; left:0; right:0; margin-top:5px; margin-bottom:4px;"></div>
                    <div id="barcode_text<?php echo e($x); ?>" style="width:55px; margin:auto; left:0; right:0; margin-bottom:0px;"><?php echo e($row->LBL_ID); ?></div>
                    <input type="hidden" name="label_id<?php echo e($x); ?>" id="label_id<?php echo e($x); ?>" value="<?php echo e($row->LBL_ID); ?>">
                </td>
    
            </tr>
            <tr>
                <td class='fieldColumn bigNumber' >QTY</td>
                <td class='fieldColumn bigNumber' style="font-weight:bold !important; font-size: 16px !important;"><?php echo e(number_format($row->LABEL_QTY)); ?></td>
            </tr>
        </table>
    </div>
   

    <?php if(count($data) > 1 && $x < count($data)): ?>
    <div style="page-break-after: always;"></div>
    <?php endif; ?>

    <script>
       
        var qrcode = new QRCode("barcode<?php echo e($x); ?>", {
            text: "<?php echo e($row->LBL_ID); ?>",
            width: 55,
            height: 55,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
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


function saveToPdf(tPage){
    
    var y = 0
    var pdf = "";
    var heightPdf = 200 * tPage;
    for(var x = 1; x <= tPage; x++)
    {
        y++

        if(y == 1)
        {
            html2canvas($("#tableLabel" + y)[0],{allowTaint:true, dpi:600, scale:3}).then(function(canvas) {    
                var imgData = canvas.toDataURL("image/png", 1.0);
                pdf = new jsPDF('l', 'pt', [395, 205]);
                pdf.addImage(imgData, 'JPG', -2, 10, 387, 180);

                if(tPage == 1)
                {
                    pdf.save("QR_Code_List.pdf");
                }
            });
        }
        else if(y >= 1 && y < tPage){

            html2canvas($("#tableLabel" + y)[0],{allowTaint:true, dpi:600, scale:3}).then(function(canvas) {    
                var imgData = canvas.toDataURL("image/png", 1.0);
                pdf.addPage(395, 205);
                pdf.addImage(imgData, 'JPG', -2, 10, 387, 180);
            });
        }
        else{
            html2canvas($("#tableLabel" + y)[0],{allowTaint:true, dpi:600, scale:3}).then(function(canvas) {          
               var imgData = canvas.toDataURL("image/png", 1.0);
                pdf.addPage(395, 205);
                pdf.addImage(imgData, 'JPG', -2, 10, 387, 180);
                pdf.save("QR_Code_List.pdf");
            });
        }

        
    }
  
};
$('#pdfto').click(function () {
    //setToExcel();
    saveToPdf(<?php echo e($x); ?>)
});


function setToExcel(){
    /*
    for(var x = 1; x <= $("#jumlah").val(); x++)
    {
        saveToImage($("#image_barcode"+x).attr("src"), $("#label_id"+x).val(), "image_barcode"+x, "barcode"+x);
    }   
*/
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