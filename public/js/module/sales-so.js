function openStructure() {
    popUp(baseUrl + "/reference/orgstructure/ors/orgtree", '60%', '350px');
}

function orgStrSelect(code, name)
{
    $("#org_name").val(name);
    $("#org_code").val(code);
}

function addItem() {
    var count = parseFloat($("#last_id").val());
    
    if($("#item_code"+count).val() !=="" && $("#qty"+count).val() !==""  && $("#unit_price"+count).val() !=="") 
    {        
        var next = count + 1
        var clone = $("#rowCopy"+count).clone().attr('id', 'rowCopy'+next).appendTo(".bodyClone");
        
        clone.find("#rowCopy"+count).attr("id","rowCopy"+next);
        
        clone.find("#no_urut"+count).attr("id","no_urut"+next);
        $("#no_urut"+next).html(next+".&nbsp;"); 
        
        clone.find("#item_code"+count).attr("id","item_code"+next).attr("name","item_code"+next).attr("onfocus","itemAutoCompleteBind("+next+")");                
        $("#item_code"+next).val(""); 
        $("#item_code"+next).focus();
        
        clone.find("#item_name"+count).attr("id","item_name"+next).attr("name","item_name"+next);
        $("#item_name"+next).val("");   
        
        clone.find("#qty"+count).attr("id","qty"+next).attr("name","qty"+next).attr("onkeydown","if(event.keyCode=='13'){ goToNext($(this).val(), 'uom"+next+"');  }");
        $("#qty"+next).val("");        
        
        clone.find("#uom"+count).attr("id","uom"+next).attr("name","uom"+next).attr("onkeydown","if(event.keyCode=='13'){ goToNext($(this).val(), 'unit_price"+next+"');  }");
        $("#uom"+next).val("");  
        
        clone.find("#unit_price"+count).attr("id","unit_price"+next).attr("name","unit_price"+next).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'remarks"+next+"', false); }");
        $("#unit_price"+next).val("");  
        $("#unit_price"+next).mask('#.##0', {reverse: true});

        clone.find("#subtotal"+count).attr("id","subtotal"+next).attr("name","subtotal"+next);
        $("#subtotal"+next).val("");
        $("#subtotal"+next).mask('#.##0', {reverse: true});
        
        clone.find("#remarks"+count).attr("id","remarks"+next).attr("name","remarks"+next).attr("onkeydown","if(event.keyCode=='13'){ calcTotal("+next+", 1);  }");
        $("#remarks"+next).val("");

        clone.find("#delete_row"+count).attr("id","delete_row"+next).attr("name","delete_row"+next).attr("onclick","removeThis("+next+")");       

        $("#last_id").val(next);
        count++;
    }
    
}

function newRow()
{
    var count = parseFloat($("#last_id").val());
    if($("#item_code"+count).val() !=="" && $("#unit_price"+count).val() !=="" && $("#qty"+count).val() !=="") 
    { 
        addItem();
    }
    else
    {
        $.bootstrapGrowl("you can add if the last row is complete!", {
            type: "warning"
        });
    }
}

$("#new_item").click(function(){ 
    var count = parseFloat($("#last_id").val());
    if($("#item_code"+count).val() !=="" && $("#unit_price"+count).val() !=="" && $("#qty"+count).val() !=="") 
    { 
        calcTotal(count, 1);
    }
    else{
         $.bootstrapGrowl("you can add if the last row has completed!", {
            type: "warning"
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
                $("#rowCopy"+to).find("#item_code"+next).attr("id","item_code"+to).attr("name","item_code"+to).attr("onfocus","itemAutoCompleteBind("+to+")"); 
                $("#rowCopy"+to).find("#item_name"+next).attr("id","item_name"+to).attr("name","item_name"+to);
                $("#rowCopy"+to).find("#qty"+next).attr("id","qty"+to).attr("name","qty"+to).attr("onkeydown","if(event.keyCode=='13'){ goToNext($(this).val(), 'uom"+to+"'); }");
                $("#rowCopy"+to).find("#uom"+next).attr("id","uom"+to).attr("name","uom"+to).attr("onkeydown","if(event.keyCode=='13'){ goToNext($(this).val(), 'unit_price"+to+"'); }");
                $("#rowCopy"+to).find("#unit_price"+next).attr("id","unit_price"+to).attr("name","unit_price"+to).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'remarks"+to+"', false); }");
                $("#rowCopy"+to).find("#subtotal"+next).attr("id","subtotal"+to).attr("name","subtotal"+to);
                $("#rowCopy"+to).find("#remarks"+next).attr("id","remarks"+to).attr("name","remarks"+to).attr("onkeydown","if(event.keyCode=='13'){ calcTotal("+to+", 1); }");
                $("#rowCopy"+to).find("#delete_row"+next).attr("id","delete_row"+to).attr("name","delete_row"+to).attr("onclick","removeThis("+to+")");
                
            }
            
        }

        calcTotal(newNum, 0);
    }
    else{
        $.bootstrapGrowl("You cannot delete all row, at least 1 row to complete the transaction!", {
            type: "warning"
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
    var discount_precent = parseFloat($("#discount_precent").val());
    var discount_value = total * discount_precent / 100;
    var after_discount = total - discount_value;    
    
    var ppn = after_discount * ppn_precent / 100;
    var grand_total = after_discount + ppn;


    $("#total_afterdisc").val(after_discount);
    $("#discount_value").val(discount_value);
    $("#ppn").val(ppn);
    $("#total").val(total);

    $("#total").mask('#.##0', {reverse: true});
    $("#grand_total").val(grand_total);
    $("#grand_total").mask('#.##0', {reverse: true});
    $("#discount_value").mask('#.##0', {reverse: true});
    if(newRowAllowed == 1) {
        newRow();
    }
    
    //moneyMaskForm();
}


function itemAutoCompleteBind(num)
{
    
    var itemDom = '#item_code' + num;
    var itemNameDom = '#item_name' +num; 
    var priceDom = '#unit_price' +num;

    $(itemDom).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: baseUrl + "/finance/inventory/item/rawdata?term=" + $(itemDom).val() +"&trans_type=sales",
                dataType: "json",
                success: function(json) {
                    var data = new Array();
                    for(var x = 0; x < json.length; x++) {
                        data[x] = json[x].code + " _ " + json[x].name;
                    }
                    response(data);  
                }
            });
        },
        minLength: 0,
    });

    //alert(num);
    
    $(itemDom).change(function()
    {   
        selectComplete(this.value, num);
    });

    $(itemDom).blur(function()
    {   
        selectComplete(this.value, num);
    });
}

function selectComplete(val, num)
{
    if (val.indexOf(' _ ') > -1)
    {        
        var itemDom = '#item_code' + num;
        var itemNameDom = '#item_name' +num; 
        var qtyDom = '#qty' +num;
        var priceDom = '#unit_price' +num;

        var text = val.split(" _ ");

        var LastNum = parseFloat($("#last_id").val());     
        var empty = false; 
        for(var x = 1; x <= LastNum; x++) {
            if($("#item_code"+x).val() == text[0])
            {
                empty = true;
            }
        }

        if(empty)
        {

            $.bootstrapGrowl("Selected item has taken, please choose another!", {
                type: "error"
            });
            $(itemDom).val("");
            $(itemNameDom).val("");
            $(itemDom).focus();
        }
        else{
           
            $(itemDom).val(text[0]);
            $(itemNameDom).val(text[1]);
            $(qtyDom).focus();
        }
    }    
}


function moneyMaskForm()
{
    $("#total").mask('#.##0', {reverse: true});
    $("#grand_total").mask('#.##0', {reverse: true});
    $("#discount_value").mask('#.##0', {reverse: true});
    
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
    
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var unit_price = "#unit_price" + x;
        var subtotal = "#subtotal" + x;
        $(unit_price).unmask();
        $(subtotal).unmask();
    }


}