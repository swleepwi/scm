function setFull(num, obj)
{   
    
    if(obj.attr("checked"))
    {
        var pengurang = (parseFloat($("#qty_order"+num).val()) - parseFloat($("#qty_sisa_asli"+num).val()));
        var receive = parseFloat($("#qty_order"+num).val()) - pengurang;
        $("#qty_receive"+num).val(receive);
        $("#qty_receive"+num).attr("readonly", true);
    }
    else{
        $("#qty_receive"+num).val(0); 
        $("#qty_receive"+num).attr("readonly", false);
    }

    $("#qty_sisa"+num).val(parseFloat($("#qty_sisa_asli"+num).val()) - parseFloat($("#qty_receive"+num).val())); 
    
}

function openStructure() {
    popUp(baseUrl + "/reference/orgstructure/ors/orgtree", '60%', '350px');
}

function orgStrSelect(code, name)
{
    $("#org_name").val(name);
    $("#org_code").val(code);
}

function openPurchaseOrder() {
    popUp(baseUrl + "/finance/accounting/purchaseorder/select", '90%', '400px');
}

function purchaseOrderSelect(po_number)
{
    window.location = baseUrl + "/finance/accounting/purchasereceive/form/frompo/"+po_number;
}

function removeThis(num)
{
    removeItem(num);
};

function checkIsNum(value, nextObj, newLine) 
{
    //moneyUnMaskForm();
    if(value != "") {
        nextFocus(nextObj, newLine);
        
    }
    else{
        $.bootstrapGrowl("this field cannot empty!", {
            type: "warning"
        });
    }
    
    //moneyMaskForm();
}

function goToNext(value, nextObj)
{
    if(value != "") {
        nextFocus(nextObj, false);
    }
    else
    {
        $.bootstrapGrowl("this field cannot empty!", {
            type: "warning"
        });
        
    }
}

function nextFocus(obj, newLine) 
{
    $("#"+obj).focus();
    if(newLine) {
        if($("#id").val() =="") {                
            addItem();
        }
    }        
}

function calcTotal(num, newRowAllowed)
{   
    
    //moneyUnMaskForm();
    var LastNum = parseFloat($("#last_id").val()); 
    //var LastNum = num;
    var total = 0;
    $("#total").unmask();
    $("#grand_total").unmask();
    $("#discount_value").unmask();
    $("#dp").unmask();
    $("#after_dp").unmask();
    for(var x = 1; x <= LastNum; x++) {
        $("#unit_price"+x).unmask();
        var unit_price = $("#unit_price"+x).val();
        var qty = $("#qty"+x).val();
        
        if(unit_price !="") {
            var subtotal = parseFloat(unit_price) * parseFloat(qty);
            $("#subtotal"+x).val(subtotal);
            
            
            total = parseFloat(subtotal) + total;
        }

        $("#unit_price"+x).mask('#.##0', {reverse: true});   
        $("#subtotal"+x).mask('#.##0', {reverse: true});
    }

    var ppn_precent = parseFloat($("#ppn_precent").val());
    var dp = parseFloat($("#dp").val());
    var discount_precent = parseFloat($("#discount_precent").val());
    
    var discount_value = total * discount_precent / 100;
    var after_discount = total - discount_value;
    var after_dp = after_discount - dp;    
    
    var ppn = after_discount * ppn_precent / 100;
    var grand_total = after_discount + ppn;

    var ppn_dp = dp * ppn_precent / 100;
    var grand_dp = dp + ppn_dp

    $("#total_afterdisc").val(after_discount);
    $("#after_dp").val(after_dp);
    
    $("#discount_value").val(discount_value);
    $("#ppn").val(ppn);
    $("#total").val(total);

    $("#total").mask('#.##0', {reverse: true});
    $("#grand_total").val(grand_total);
    $("#grand_total").mask('#.##0', {reverse: true});
    $("#discount_value").mask('#.##0', {reverse: true});
    $("#after_dp").mask('#.##0', {reverse: true});
    $("#dp").mask('#.##0', {reverse: true});

    $("#ppn_dp").val(ppn_dp);
    $("#grand_dp").val(grand_dp);

    if(newRowAllowed == 1) {
        newRow();
    }
    
    //moneyMaskForm();
}



function moneyMaskForm()
{
    $("#total").mask('#.##0', {reverse: true});
    $("#grand_total").mask('#.##0', {reverse: true});
    $("#discount_value").mask('#.##0', {reverse: true});
    $("#dp").mask('#.##0', {reverse: true});
    $("#after_dp").mask('#.##0', {reverse: true});
    
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var unit_price = "#unit_price" + x;
        var subtotal = "#subtotal" + x;
        $(unit_price).mask('#.##0', {reverse: true});
        $(subtotal).mask('#.##0', {reverse: true});
    }
}

function moneyUnMaskForm()
{

    $("#total").unmask();
    $("#grand_total").unmask();
    $("#discount_value").unmask();
    $("#dp").unmask();
    $("#after_dp").unmask();
    
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var unit_price = "#unit_price" + x;
        var subtotal = "#subtotal" + x;
        $(unit_price).unmask();
        $(subtotal).unmask();
    }


}