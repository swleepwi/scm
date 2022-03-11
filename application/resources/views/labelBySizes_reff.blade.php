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
        width:70%;
        margin-left: auto;
        margin-right: auto;
        
    }
    .labelPrint tr td{
        border: solid 1px #000;
        padding: 1px;
        text-align: center;
        font-weight:bold;
    }

    .fieldColumn{
        background-color: #ccc;
            font-weight:bold;
            font-family: 'OpenSans-Bold' !important,
    }

    .valueColumn{
        font-weight:normal !important;
            font-weight:bold  !important;
            font-family: 'OpenSans-Bold' !important,
    }
    .bigNumber{
        font-size: 20px  !important;
        font-weight:bold  !important;
    }

    @media print {
        body{
            width:100%; 
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .labelPrint{
            width:70%;
            margin-left: auto;
            margin-right: auto;
            
        }
        .labelPrint tr td{
            border: solid 1px #000;
            padding: 0px !important;
            text-align: center;
            font-weight:bold;
            font-size: 8px !important
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
</style>
<br/>
<div style="margin-bottom:15px" id="printControl">
    <button class="btn-small btn-mini btn_pwi" type="button" onclick="$('#printControl').hide(); print(document); $('#printControl').show();"><i class="icon icon-print"></i> Print</button>
    <button class="btn-small btn-mini btn_pwi" type="button" onclick="tableToExcel('barcode', 'barcode_label', 'barcode_label')" id="pdfto"><i class="icon icon-file"></i> PDF</button>
</div>
<div id="barcode">
    @php $x = 0; @endphp
    @foreach ($data as $row)
    @php $x++; @endphp
    
    <div  style="page-break-before: always;"></div>
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
            <td class='fieldColumn'>COMP</td>
            <td colspan="3" class='valueColumn'>{{ $row->JOB_DESC }}</td>
        </tr>
        <tr>
            <td class='fieldColumn'>MODEL</td>
            <td colspan="3" class='valueColumn'>{{ $row->ARTICLEDESC }}</td>
        </tr>    
        <tr>
            <td class='fieldColumn'>GENDER</td>
            <td class='valueColumn' style="width:50px">{{ $row->GENDER_CD }}</td>
            <td class='fieldColumn' style="font-size: 8px !important">ART_NO</td>
            <td class='valueColumn' style="width:70px">{{ $row->ARTNO }}</td>
        </tr>
        <tr>
            <td class='fieldColumn'>COLOR</td>
            <td colspan="3" class='valueColumn'>{{ $row->COL_NM }}</td>
        </tr>
        <tr>
            <td class='fieldColumn bigNumber'>{{ $row->UKSIZE }}</td>
            <td class='valueColumn' colspan='3' rowspan="2" style="padding-top:5px !important; vertical-align: bottom !important;">
                <svg id="barcode{{$x}}"></svg>
            </td>
        </tr>
        <tr>
            <td class='fieldColumn bigNumber'>{{ number_format($row->LABEL_QTY) }}</td>
        </tr>
    </table>
    
    <script>
        JsBarcode("#barcode{{$x}}", "{{ $row->LBL_ID }}", {
            lineColor: "#000",
            width:1.5,
            height:40,
        });    
    </script>
    @endforeach
</div>





<script src="{{ asset('public') }}//js/select2.min.js"></script> 
<script src="{{ asset('public') }}//js/jquery.validate.js"></script>
<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" integrity="sha256-c9vxcXyAG4paArQG3xk6DjyW/9aHxai2ef9RpMWO44A=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
-->


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>




<script type="text/javascript">

function getPDF(tPage){
    //alert(tPage)

    //$(".batasan").css("height", "320px");
    var HTML_Width = $("#barcode").width();
    var HTML_Height = $("#barcode").height();
    var top_left_margin = 10;
    var PDF_Width = HTML_Width+(top_left_margin*2);
    var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
    var PDF_Height_kertas = $(".labelPrint").height();
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;
    var tambahan = PDF_Height - PDF_Height_kertas;
    
    //var canvas_image_height = PDF_Height_kertas * 10;

    var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


    html2canvas($("#barcode")[0],{allowTaint:true}).then(function(canvas) {
        canvas.getContext('2d');
        
        console.log(canvas.height+"  "+canvas.width);
        
        
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt',  [HTML_Width, HTML_Height]);
        //var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height + 20);
        
        
        //for (var i = 1; i <= totalPDFPages; i++) { 
        /*
        for (var i = 1; i <= tPage; i++) { 
            
            pdf.addPage(PDF_Width, PDF_Height);
            //pdf.addImage(imgData, 'JPG', top_left_margin, - (PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            pdf.addImage(imgData, 'JPG', top_left_margin, - (PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        */
        pdf.save("HTML-Document.pdf");
    });
};
/*
    var doc = new jsPDF();
        var specialElementHandlers = {
            '#editor': function (element, renderer) {
            return true;
        }
    };

    doc.fromHTML($('#brcode').html(), 15, 15, {
            'width': 170,
                'elementHandlers': specialElementHandlers
        });
    doc.save('contoh-file.pdf');
    */


    
$('#pdfto').click(function () {
    getPDF({{$x}});
});
/*
$('#pdfto').click(function () {
    domtoimage.toPng(document.getElementById('barcode'))
        .then(function (blob) {
            var pdf = new jsPDF('l', 'pt', [3500, 3500]);

            pdf.addImage(blob, 'PNG', 0, 0, 3500, 3500);
            pdf.save("test.pdf");

            that.options.api.optionsChanged();
        });
});
*/
/*
$('#pdfto').click(()=>{
    var pdf = new jsPDF('p','pt','a4');
    pdf.addHTML(document.body,function() {
        pdf.save('web.pdf');
    });
})
*/
</script>
@endsection
