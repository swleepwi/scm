<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/uniform.css" />
<link rel="stylesheet" href="<?php echo e(asset('public')); ?>/css/select2.css" />
<script src="<?php echo e(asset('public')); ?>/plugins/barcode128/JsBarcode.all.min.js"></script>
<script src="<?php echo e(asset('public')); ?>/plugins/barcode128/barcode128.js"></script>
<style>
    body{
        width:100%; 
        background-color: #fff;
    }

    .labelPrint{
        width:100%;
        
    }
    .labelPrint tr td{
        border: solid 1px #000;
        padding:2px;
        text-align: center;
        font-weight:bold;
    }

    .fieldColumn{
        background-color: #ccc;
            font-weight:bold;
    }

    .valueColumn{
        font-weight:normal !important;
            font-weight:bold  !important;
    }
    .bigNumber{
        font-size: 20px  !important;
        font-weight:bold  !important;
    }

    @media  print {
        body{
            width:100%;
            height: auto !important;
        }

        .labelPrint{
            width:100%;
        }
        .labelPrint tr td{
            border: solid 1px #000;
            padding:2px;
            text-align: center;
            font-weight:bold;
        }

        .fieldColumn{
            background-color: #ccc;
            font-weight:bold;
        }

        .valueColumn{
            font-weight:normal !important;
            font-weight:bold  !important;
        }

        .bigNumber{
            font-size: 20px !important;
            font-weight:bold  !important;
        }

    }
    .dnCotent{
        margin:70px;
    }
</style>
<div class="dnCotent">
    <div style="margin-bottom:15px" id="printControl">
        <button class="btn-small btn-mini btn_pwi" type="button" onclick="$('#printControl').hide(); print(document); $('#printControl').show();"><i class="icon icon-print"></i> Print</button>
    
    </div>
    <table style="width:100%;" id="dnPrint">
        <tr>
            <td >
                <div style="widt:100%;">
                    <h5 style="font-size:26px;">Delivery Note</h5>
                </div>
            </td>
            <td style="width:280px; text-align:right;">
                <table class="labelPrint" style="width:280px; float: right;">
                    <tr>
                        <td style="width:70px; text-align: center;">Send</td>
                        <td style="width:70px; text-align: center;">QC</td>
                        <td style="width:70px; text-align: center;">Receive</td>                        
                        <td style="width:70px; text-align: center;">Receive</td>
                    </tr>                    
                    <tr>
                        <td style="height:60px;">&nbsp;</td>
                        <td style="height:60px;">&nbsp;</td>
                        <td style="height:60px;">&nbsp;</td>                        
                        <td style="height:60px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Supplier</td>
                        <td>PWJ</td>
                        <td>Supplier</td>                        
                        <td>PWJ</td>
                    </tr> 
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%">
        <tr>
            <td style="vertical-align:top;">
               <span style="font-weight:bold; font-size: 16px;"><?php echo e(session('pwiscm_company_name')); ?></span> 
               <div>
                <?php echo e($edit->CST_ADDRESS1); ?><br>
                <?php echo e($edit->CST_ADDRESS2); ?><br>
                <?php echo e($edit->CST_ADDRESS3); ?><br>
                Phone : <?php echo e($edit->TEL_NO); ?><br>
                Fax : <?php echo e($edit->FAX_NO); ?><br>
                email : <?php echo e($edit->EMAIL); ?>

               </div>
            </td>
            <td style="width:280px; vertical-align:top;">
                <span style="font-weight:bold; font-size: 16px;">PT. Parkland World Indonesia</span> 
                <div>
                    Jl. Raya Jepara-Kudus, Pelang - Mayong, Jepara<br>
                    <br>
                    <br>
                    Date: <?php echo e(substr($out_date, 0, 4)."-".substr($out_date,4, 2)."-".substr($out_date, 6, 2)); ?><br>
                    Delivery Note No: <?php echo e($out_no); ?><br>
                    Invoice No:  <?php echo e($edit->INV_NO); ?>

                   </div>
            </td>
        </tr>
    </table>
    <br>
    <table class="labelPrint" style="width:100%">
        <tr>
            <td rowspan="2" style="background-color:#ccc; font-weight:bold;"> Seq</td>
            <td style="background-color:#ccc; font-weight:bold;">Model</td>
            <td style="background-color:#ccc; font-weight:bold;">Article</td>                
            <td style="background-color:#ccc; font-weight:bold;">Brand Order</td>                
            <td style="background-color:#ccc; font-weight:bold;">Buyer P/O No</td>                
            <td rowspan="2" style="background-color:#ccc; font-weight:bold;">Total</td>  
        </tr>
        <tr>
            <td style="background-color:#ccc; font-weight:bold;">Component</td>
            <td style="text-align: center; background-color:#ccc;  font-weight:bold;" colspan="3">Size Qty</td> 
        </tr>
        <?php  $x = 11;  ?>
        <?php $__currentLoopData = $detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php  $x++  ?>   
        <tr>
            <td rowspan="2"><?php echo e($dt->OUT_SEQ); ?> </td>
            <td><?php echo e($dt->ARTICLEDESC); ?></td>
            <td><?php echo e($dt->ARTNO); ?></td>                
            <td><?php echo e($dt->O_NO); ?>/<?php echo e(number_format($dt->ORDER_QTY,0)); ?></td>                
            <td><?php echo e($dt->PO_NO); ?></td>                
            <td><?php echo e($dt->PACK_QTY); ?></td>  
        </tr>
        
        <tr>
            <td><?php echo e($dt->PART_NM); ?></td>
            <td style="text-align: center" colspan="3"><?php echo e($dt->SIZE_RUN); ?></td>              
            <td><?php echo e($dt->SCAN_QTY); ?></td>  
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td style="padding:5px; height:50px; text-align: left; vertical-align:top;" colspan="6">Remarks
            <br/>
            <?php echo e($edit->REMARK); ?>

            </td> 
        </tr>
    </table>
    
    <div style="page-break-after: always;"></div>
</div>


<script src="<?php echo e(asset('public')); ?>//js/select2.min.js"></script> 
<script src="<?php echo e(asset('public')); ?>//js/jquery.validate.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>




<script type="text/javascript">


var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {
    doc.fromHTML($('#content').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');
});


function getPDF(){
    //alert(tPage)

    var HTML_Width = $("#dnPrint").width();
    var HTML_Height = $("#dnPrint").height();
    var top_left_margin = 22;
    var PDF_Width = HTML_Width+(top_left_margin*2);
    var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;
    
    //var canvas_image_height = PDF_Height_kertas * 10;

    var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


    html2canvas($("#dnPrint")[0],{allowTaint:true}).then(function(canvas) {
        canvas.getContext('2d');
        
        console.log(canvas.height+"  "+canvas.width);
        
        
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
        
        for (var i = 1; i <= totalPDFPages; i++) { 

        //for (var i = 1; i <= tPage; i++) { 
            
            pdf.addPage(PDF_Width, PDF_Height);
            //pdf.addImage(imgData, 'JPG', top_left_margin, - (PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            pdf.addImage(imgData, 'JPG', top_left_margin, - (PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        
        pdf.save("HTML-Document.pdf");
    });
};

$('#pdfto').click(function () {
    getPDF();
});

$(document).ready(function(){
    /* 
    setTimeout(function(){
        print(document);
    }, 1000);
    */
});
    
    
</script> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.headerblanklight', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>