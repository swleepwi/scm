@extends('template.headerblanklight')
@section('content')
<link rel="stylesheet" href="{{ asset('public') }}/css/uniform.css" />
<link rel="stylesheet" href="{{ asset('public') }}/css/select2.css" />
<script src="{{ asset('public') }}/plugins/barcode128/JsBarcode.all.min.js"></script>
<script src="{{ asset('public') }}/plugins/barcode128/barcode128.js"></script>
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
    @media print {
        body{
            width:100%; 
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .labelPrint{
        width:88%;
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
<!-- onclick="tableToExcel('barcode', 'barcode_label', 'barcode_label')" -->
<div style="margin-bottom:15px" id="printControl">
    <button class="btn-small btn-mini btn_pwi" type="button" onclick="printBarcode();"><i class="icon icon-print"></i> Print</button>
    <button class="btn-small btn-mini btn_pwi" type="button" id="pdfto"><i class="icon icon-file"></i> PDF</button>
</div>
<div id="barcode">
    @php $x = 0; @endphp
    @foreach ($data as $row)
    @php $x++; @endphp
    
    @if ($x > 1)
    <div style="page-break-before: always;">&nbsp;</div>
    @endif
    
    <br/>
    <table class="labelPrint">
        <tr>
            <td style='width:100px' class='fieldColumn'>P/O</td>
            <td colspan="3">{{ $row->PO_NO }}</td>
        </tr>
        <tr>
            <td class='fieldColumn'>ADIDAS PO</td>
            <td colspan="3">{{ $row->O_NO }}</td>
        </tr>
        <tr>
            <td class='fieldColumn'>SUPPLIER</td>
            <td colspan="3" class='valueColumn'>{{ $row->CST_NM }}</td>
        </tr>
        <tr>
            <td class='fieldColumn'>MODEL</td>
            <td colspan="3" class='valueColumn'>{{ $row->ARTICLEDESC }}</td>
        </tr>    
        <tr>
            <td class='fieldColumn'>GENDER</td>
            <td class='valueColumn' style="width:50px">{{ $row->GENDER_CD }}</td>
            <td class='fieldColumn' style="font-size: 8px !important; padding-left:10px; padding-right:10px;">ART_NO</td>
            <td class='valueColumn' style="width:70px">{{ $row->ARTNO }}</td>
        </tr>
        <tr>
            <td class='fieldColumn'>COLOR</td>
            <td colspan="3" class='valueColumn'>{{ $row->COL_NM }}</td>
        </tr>
        <tr>
            <td class='fieldColumn bigNumber' style="font-size:14px !important; font-weight:bold !important;">{{ $row->UKSIZE }}</td>
            <td class='valueColumn' colspan='3' rowspan="2" style="padding-top:5px !important; vertical-align: bottom !important;  font-weight:bold !important;">
                <svg id="barcode{{$x}}"></svg>
                <img id="image_barcode{{$x}}" class="img_barcode">
                <input type="hidden" name="label_id{{$x}}" id="label_id{{$x}}" value="{{ $row->LBL_ID }}">
            </td>
        </tr>
        <tr>
            <td class='fieldColumn bigNumber' style="font-size:14px !important; font-weight:bold !important;">{{ number_format($row->LABEL_QTY) }}</td>
        </tr>
    </table>
    <script>
        JsBarcode("#barcode{{$x}}", "{{ $row->LBL_ID }}", {
            lineColor: "#000",
            width:2,
            height:40,
            fontSize: 12
        });   
        
        
        JsBarcode("#image_barcode{{$x}}", "{{ $row->LBL_ID }}", {
            lineColor: "#000",
            width:2,
            height:40,
            fontSize: 12
        });   
    </script>
    @endforeach

    <input type="hidden" name="jumlah" id="jumlah" value="{{$x}}">
    <br/><br/>
</div>





<script src="{{ asset('public') }}//js/select2.min.js"></script> 
<script src="{{ asset('public') }}//js/jquery.validate.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>




<script type="text/javascript">

function getPDF(tPage){
   
    var HTML_Width = $("#barcode").width();
    var HTML_Height = $("#barcode").height();
    var top_left_margin = 0;
    var PDF_Width = HTML_Width+(top_left_margin*2);
    var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
    var PDF_Height_kertas = $(".labelPrint").height();
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;
    var tambahan = PDF_Height - PDF_Height_kertas;
    
    //var canvas_image_height = PDF_Height_kertas * 10;

    var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


    html2canvas($("#barcode")[0],{allowTaint:true, dpi:600, scale:3}).then(function(canvas) {
        canvas.getContext('2d');
        
        
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt',  [HTML_Width, HTML_Height]);
        //var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height + 20);
        pdf.save("BarcodeList.pdf");
        
        
        //for (var i = 1; i <= totalPDFPages; i++) { 
        /*
        for (var i = 1; i <= tPage; i++) { 
            
            pdf.addPage(PDF_Width, PDF_Height);
            //pdf.addImage(imgData, 'JPG', top_left_margin, - (PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            pdf.addImage(imgData, 'JPG', top_left_margin, - (PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        */
        //pdf.save("HTML-Document.pdf");
    });
};
$('#pdfto').click(function () {
    getPDF();
    //window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#barcode').html()));
    //e.preventDefault();
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
        url: "{{ url('/') }}/label/export",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data : {
            img: imgs,
            name: names
        },
        success: function (json) {
            $("#"+image_barcode_id).prop("src", "{{ asset('public') }}/barcodes/"+names+".png");
            $("#"+image_barcode_id).show();
            $("#"+canvas_barcode_id).hide();
        }
    });
}
</script>
@endsection
