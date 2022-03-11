var obj = new Object();

function openStructure() {
    popUp(baseUrl + "/reference/orgstructure/ors/orgtree", '60%', '350px');
}

function orgStrSelect(code, name)
{
    $("#org_name").val(name);
    $("#org_code").val(code);
}

function openCoa() {
    if($("#org_code").val() == "" || $("#trans_date").val() == "" ) {
        $.bootstrapGrowl("Organization and date cannot left blank!", {
            type: "error"
        });
    }
    else{
        popUp(baseUrl + "/finance/accounting/coa/coaselect/13", '60%', '450px');
    }    
}

function coaDataSelected(code, name)
{
    $("#coa_to").val(code);
    $("#coa_name").val(code+" - "+name);
}

function addItem() {
    var count = parseFloat($("#last_id").val());
    
    if($("#invoice_number"+count).val() !=="" && $("#sub_total"+count).val() !=="") 
    {        
        var next = count + 1
        var clone = $("#rowCopy"+count).clone().attr('id', 'rowCopy'+next).appendTo(".bodyClone");
        
        clone.find("#rowCopy"+count).attr("id","rowCopy"+next);
        
        clone.find("#no_urut"+count).attr("id","no_urut"+next);
        $("#no_urut"+next).html(next+".&nbsp;"); 
        
        clone.find("#invoice_number"+count).attr("id","invoice_number"+next).attr("name","invoice_number"+next).attr("onfocus","itemAutoCompleteBind("+next+");").attr("onkeydown","if(event.keyCode=='13'){ goToNext($(this).val(), 'sub_total"+next+"'); }");                
        $("#invoice_number"+next).val(""); 
        $("#invoice_number"+next).focus();
        
        clone.find("#amount"+count).attr("id","amount"+next).attr("name","amount"+next);
        $("#amount"+next).val("");   
        
        clone.find("#remain"+count).attr("id","remain"+next).attr("name","remain"+next);
        $("#remain"+next).val("");   
        
        clone.find("#sub_total"+count).attr("id","sub_total"+next).attr("name","sub_total"+next).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'memo"+next+"', false); }");
        $("#sub_total"+next).val("");  
        $("#sub_total"+next).mask('#.##0', {reverse: true});

        clone.find("#memo"+count).attr("id","memo"+next).attr("name","memo"+next).attr("onkeydown","if(event.keyCode=='13'){ calcTotal("+next+", 1);  }");
        $("#memo"+next).val("");

        clone.find("#delete_row"+count).attr("id","delete_row"+next).attr("name","delete_row"+next).attr("onclick","removeThis("+next+")");       

        $("#last_id").val(next);
        count++;
    }    
}

function newRow()
{
    var count = parseFloat($("#last_id").val());
    if($("#invoice_number"+count).val() !=="" && $("#sub_total"+count).val()) 
    { 
        addItem();
    }
    else
    {
        $.bootstrapGrowl("you can add if the last row is complete!", {
            type: "error"
        });
    }
}

$("#new_item").click(function(){ 
    var count = parseFloat($("#last_id").val());
    if($("#invoice_number"+count).val() !=="" && $("#sub_total"+count).val()) 
    { 
        calcTotal(count, 1);
    }
    else{
         $.bootstrapGrowl("you can add if the last row has completed!", {
            type: "error"
        });
    }
});

function removeItem(num)
{
    var LastNum = parseFloat($("#last_id").val()); 
    if(LastNum > 1) {
        //$(this).closest('tr').remove();
        $("#rowCopy"+num).closest('tr').remove();
        var newNum = LastNum - 1;
        $("#last_id").val(newNum);
        
        if(num < LastNum) {
            var next = num;
            var to = num-1;

            for(var i = num; i < LastNum; i++){
                next++;
                to++;

                $("#rowCopy"+next).attr("id","rowCopy"+to);
                $("#rowCopy"+to).find("#no_urut"+next).attr("id","no_urut"+to).html(to+".&nbsp;");
                $("#rowCopy"+to).find("#invoice_number"+next).attr("id","invoice_number"+to).attr("name","invoice_number"+to).attr("onfocus","itemAutoCompleteBind("+to+")").attr("onkeydown","if(event.keyCode=='13'){ goToNext($(this).val(), 'sub_total"+next+"'); }"); 
                $("#rowCopy"+to).find("#amount"+next).attr("id","amount"+to).attr("name","amount"+to);
                $("#rowCopy"+to).find("#remain"+next).attr("id","remain"+to).attr("name","remain"+to);
                $("#rowCopy"+to).find("#sub_total"+next).attr("id","sub_total"+to).attr("name","sub_total"+to).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'memo"+to+"', false); }");
                $("#rowCopy"+to).find("#memo"+next).attr("id","memo"+to).attr("name","memo"+to).attr("onkeydown","if(event.keyCode=='13'){ calcTotal("+to+", 1); }");
                $("#rowCopy"+to).find("#delete_row"+next).attr("id","delete_row"+to).attr("name","delete_row"+to).attr("onclick","removeThis("+to+")");
            }
            
        }

        calcTotal(newNum, 0);
    }
    else{
        $.bootstrapGrowl("You cannot delete all row, at least 1 row to complete the transaction!", {
            type: "error"
        });
    }
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
            type: "error"
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
            type: "error"
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
    
    $("#sub_total"+num).unmask();
    $("#remain"+num).unmask();
    
    if(parseFloat($("#sub_total"+num).val()) > parseFloat($("#remain"+num).val()))
    {
        $.bootstrapGrowl("You cannot pay more than total remain", {
            type: "error"
        });

        $("#sub_total"+num).val('');
        $("#sub_total"+num).focus();
        $("#sub_total"+num).mask('#.##0', {reverse: true});
        $("#remain"+num).mask('#.##0', {reverse: true});
    }
    else{
        $("#total").unmask();
        for(var x = 1; x <= LastNum; x++) {
            $("#sub_total"+x).unmask();
            var sub_total = $("#sub_total"+x).val();      
            
            if(parseFloat(sub_total) > 0) {
                total = parseFloat(sub_total) + total;
            }
    
            $("#sub_total"+x).mask('#.##0', {reverse: true});
        }
    
        $("#total").val(total);
        $("#total").mask('#.##0', {reverse: true});
        if(newRowAllowed == 1)
        {
            newRow();
        }


        $("#customer_id").unbind();
        $("#customer_id").change(function()
        {
           
            $.bootstrapGrowl("you cannot change the customer after you proceed 1 or more invoice number!", {
                type: "error"
            });
            $("#customer_id").val($("#customer_id_hide").val());
        });
    }
   
    
    //moneyMaskForm();
}


function itemAutoCompleteBind(num)
{
    
    var invoiceDom = '#invoice_number' + num;
    var amountDom = '#amount' +num; 
    var remainDom = '#remain' +num;
    

    $(invoiceDom).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: baseUrl + "/finance/accounting/salesinvoice/rawdata?term=" + $(invoiceDom).val() + "&customer_id=" + $("#customer_id").val(),
                dataType: "json",
                success: function(json) {
                    var data = new Array();
                    for(var x = 0; x < json.length; x++) {
                        var remain = parseFloat(json[x].total.replace('.00','')) - parseFloat(json[x].paid);
                        data[x] = json[x].invoice_number + " (total: " + json[x].total.replace('.00','') + ", sisa: " + remain +")";
                    }
                    response(data);  
                }
            });
        },
        minLength: 0,
    });

    //alert(num);
    
    $(invoiceDom).change(function()
    {   
        selectComplete(this.value, num);
    });

    $(invoiceDom).blur(function()
    {   
        selectComplete(this.value, num);
    });
}

function selectComplete(val, num)
{
    if (val.indexOf(' (total: ') > -1)
    {        
        var invoiceDom = '#invoice_number' + num;
        var amountDom = '#amount' +num; 
        var remainDom = '#remain' +num;
        var subtotalDom = '#sub_total' +num;

        $(amountDom).unmask();
        $(remainDom).unmask();


        var text = val.split(" (total: ");

        var LastNum = parseFloat($("#last_id").val());     
        var empty = false; 
        for(var x = 1; x <= LastNum; x++) {
            if($("#invoice_number"+x).val() == text[0])
            {
                empty = true;
            }
        }

        if(empty)
        {

            $.bootstrapGrowl("Selected item has taken, please choose another!", {
                type: "error"
            });
            $(invoiceDom).val("");
            $(amountDom).val("");
            $(amountDom).mask('#.##0', {reverse: true});
            $(remainDom).val("");
            $(remainDom).mask('#.##0', {reverse: true});
            $(invoiceDom).focus();
        }
        else{
            var info = text[1].split(", sisa: ");
            var info2 = info[1].split(")");

            $(invoiceDom).val(text[0]);

            $(amountDom).val(info[0]);
            $(amountDom).mask('#.##0', {reverse: true});

            $(remainDom).val(info2[0]);
            $(remainDom).mask('#.##0', {reverse: true});

            $(subtotalDom).focus();
        }
    }    
}


function moneyMaskForm()
{
    $("#total").mask('#.##0', {reverse: true});    
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var sub_total = "#sub_total" + x;
        $(sub_total).mask('#.##0', {reverse: true});
    }
}

function moneyUnMaskForm()
{

    $("#total").unmask();    
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var sub_total = "#sub_total" + x;
        $(sub_total).unmask();
    }

}

function checkPaymentMethod(value)
{
    if(value == "cheque")
    {
        $("#cheque_number").attr("readonly", false);
        $("#cheque_number").focus();
    }
    else{
        $("#cheque_number").attr("readonly", true);
    }
}

function customerSelected(value)
{
    $("#customer_id_hide").val(value); 
}