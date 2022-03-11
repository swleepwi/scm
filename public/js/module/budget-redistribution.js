function openStructure() {
    popUp(baseUrl + "/reference/orgstructure/ors/orgtree", '60%', '350px');
}

function orgStrSelect(code, name)
{
    $("#org_to_name").val(name);
    $("#org_to").val(code);
}

function openCoa() {
    if($("#org_code").val() == "") {
        $.bootstrapGrowl("Organization left blank!", {
            type: "error"
        });
    }
    else{
        var org = $("#org_code").val();
        popUp(baseUrl + "/finance/accounting/coa/coabudgetselect/"+org, '60%', '450px');
    }
    
}

function coaDataSelected(code, name)
{
    $("#coa_destination").val(code);
    $("#coa_name").val(code+" - "+name);
}

function monthSelected(value)
{
    $("#month_hide").val(value); 
}


function selectComplete(val, num)
{

    if (val.indexOf(' - ') > -1)
    {        
        var coaDom = '#coa' + num;
        var coaNameDom = '#coa_name' + num;
        var remainDom = '#budget_remain' + num;
        var remainHideDom = '#budget_remain_hide' + num;
        var totalDom = '#total' + num;

        var text = val.split(" - ");

        var LastNum = parseFloat($("#last_id").val());     
        var empty = false; 
        for(var x = 1; x <= LastNum; x++) {
            if($("#coa"+x).val() == text[0])
            {
                empty = true;
            }
        }

        if(empty)
        {

            $.bootstrapGrowl("Selected account has taken, please choose another!", {
                type: "error"
            });
            $(coaDom).val("");
            $(coaNameDom).val("");
            $(remainDom).val("");
            $(remainHideDom).val("");
            $(totalDom).val("");
            $(coaDom).focus();
        }
        else{

            var text_remain = text[1].split(", Remain: ");
            $(coaDom).val(text[0]);
            $(coaNameDom).val(text_remain[0]);
            $(remainDom).val(text_remain[1]);
            $(remainHideDom).val(text_remain[1]);
            $(totalDom).focus();
            
        }
    }    
}

function addItem() {
    var count = parseFloat($("#last_id").val());
    
    if($("#coa"+count).val() !=="" && $("#total"+count).val() !=="") 
    {        
        var next = count + 1
        var clone = $("#rowCopy"+count).clone().attr('id', 'rowCopy'+next).appendTo(".bodyClone");
        
        clone.find("#rowCopy"+count).attr("id","rowCopy"+next);
        
        clone.find("#no_urut"+count).attr("id","no_urut"+next);
        $("#no_urut"+next).html(next+".&nbsp;"); 
        
        clone.find("#coa"+count).attr("id","coa"+next).attr("name","coa"+next).attr("onfocus","coaAutoCompleteBind("+next+")");                
        $("#coa"+next).val(""); 
        $("#coa"+next).focus();
        
        clone.find("#coa_name"+count).attr("id","coa_name"+next).attr("name","coa_name"+next);
        $("#coa_name"+next).val("");         

        clone.find("#budget_remain_hide"+count).attr("id","budget_remain_hide"+next).attr("name","budget_remain_hide"+next);
        $("#budget_remain_hide"+next).val("");
        $("#budget_remain_hide"+next).mask('#.##0', {reverse: true});   
        
        clone.find("#budget_remain"+count).attr("id","budget_remain"+next).attr("name","budget_remain"+next);
        $("#budget_remain"+next).val("");
        $("#budget_remain"+next).mask('#.##0', {reverse: true});   

        clone.find("#total"+count).attr("id","total"+next).attr("name","total"+next).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'description"+next+"', false); }");
        $("#total"+next).val("");
        $("#total"+next).mask('#.##0', {reverse: true});        

        clone.find("#description"+count).attr("id","description"+next).attr("name","description"+next).attr("onkeydown","if(event.keyCode=='13'){ calcSubTotal($(this).val(), 1); }");
        $("#description"+next).val("");

        clone.find("#delete_row"+count).attr("id","delete_row"+next).attr("name","delete_row"+next).attr("onclick","removeThis("+next+")");       

        $("#last_id").val(next);
        count++;
    }
    
}

function newRow()
{

    var count = parseFloat($("#last_id").val());
    if($("#coa"+count).val() !=="" && $("#total"+count).val() !=="") 
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
    if($("#coa"+count).val() !=="" && $("#total"+count).val() !=="") 
    { 
        calcTotal(1);
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
        $("#last_id").val(LastNum - 1 );
        
        if(num < LastNum) {
            var next = num;
            var to = num-1;

            for(var i = num; i < LastNum; i++){
                next++;
                to++;

                $("#rowCopy"+next).attr("id","rowCopy"+to);
                $("#rowCopy"+to).find("#no_urut"+next).attr("id","no_urut"+to).html(to+".&nbsp;");
                $("#rowCopy"+to).find("#coa"+next).attr("id","coa"+to).attr("name","coa"+to).attr("onfocus","coaAutoCompleteBind("+to+")"); 
                $("#rowCopy"+to).find("#coa_name"+next).attr("id","coa_name"+to).attr("name","coa_name"+to);
                $("#rowCopy"+to).find("#budget_remain_hide"+next).attr("id","budget_remain_hide"+to).attr("name","budget_remain_hide"+to);
                $("#rowCopy"+to).find("#budget_remain"+next).attr("id","budget_remain"+to).attr("name","budget_remain"+to);
                $("#rowCopy"+to).find("#total"+next).attr("id","total"+to).attr("name","total"+to).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'description"+to+"', false); }");
                $("#rowCopy"+to).find("#description"+next).attr("id","description"+to).attr("name","description"+to).attr("onkeydown","if(event.keyCode=='13'){ calcSubTotal($(this).val(), 1); }");
                $("#rowCopy"+to).find("#delete_row"+next).attr("id","delete_row"+to).attr("name","delete_row"+to).attr("onclick","removeThis("+to+")");
                
            }
            calcTotal(0);
        }
    }
    else{
        $.bootstrapGrowl("You cannot delete all row, at least 1 row to completing the transaction!", {
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
        /*
        if(isNaN(value))
        {
            $.bootstrapGrowl("Not Numeric entry!", {
                type: "warning"
            });
        }
        else
        {
            nextFocus(nextObj, newLine);
        }
        */
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

function calcSubTotal(amount, newRow) {
    calcTotal(newRow);
}

function calcTotal(newRowAllowed)
{   
    
    //moneyUnMaskForm();
    var LastNum = parseFloat($("#last_id").val()); 
    var totalTrans = 0;
    $("#total").unmask();
    $("#proposed_total").unmask();

    var proposed_total = $("#proposed_total").val();

    var allow = false;
    var limit = false;
    for(var x = 1; x <= LastNum; x++) {
        $("#budget_remain"+x).unmask();
        $("#budget_remain_hide"+x).unmask();
        $("#total"+x).unmask();
        var total = $("#total"+x).val();
        var budget_remain = $("#budget_remain"+x).val();
        var budget_remain_hide = $("#budget_remain_hide"+x).val();
        var sisa_budget = parseFloat(budget_remain_hide) - parseFloat(total);
        
        
        if(total != "") {
            if(sisa_budget > 0)
            {
                if(sisa_budget > 0 && sisa_budget <= 100000 )
                {
                    var limit = true;  
                }
                else{
                    var limit = false; 
                }
                totalTrans = parseFloat(total) + totalTrans;
                allow = true;

                if(totalTrans > parseFloat(proposed_total))
                {
                    $("#total"+x).val('');
                    allow = false;
                }
                $("#budget_remain"+x).val(sisa_budget);
            }
            else{
                $("#total"+x).val('');
                allow = false;
            }
            
        }
        
        $("#total"+x).mask('#.##0', {reverse: true});
        $("#budget_remain"+x).mask('#.##0', {reverse: true});   
    }

    
    if(allow)
    {

        if(limit)
        {
            $.bootstrapGrowl("remain budget is near to zero, you need to concern!", {
                type: "warning"
            });
        }
        $("#total").val(totalTrans);
        $("#new_item").attr("disabled", false);
        $("#button_save").show();       

        if(newRowAllowed == 1) {
            newRow();
        }

        $("#month").unbind();
        $("#month").change(function()
        {
            $.bootstrapGrowl("you cannot change month after you proceed 1 or more account line!", {
                type: "error"
            });

            $("#month").val($("#month_hide").val());
        });

        return true;
    }
    else{
        $.bootstrapGrowl("Reallocation more than remain or approved budget more than proposed budget, process cannot continue!", {
            type: "error"
        });
        $("#total"+x).val("");

        return false;
    }
    
    //moneyMaskForm();
}

function setPayTo()
{
    var val = $("#pay_to").val();
    if(val == "miscellaneous")
    {
        $("#vendor_div").hide();
        $("#customer_div").hide();
        $("#payee_div").show();
    }
    else if(val == "vendor")
    {
        $("#vendor_div").show();
        $("#customer_div").hide();
        $("#payee_div").hide();
    }
    else if(val == "customer")
    {
        $("#vendor_div").hide();
        $("#customer_div").show();
        $("#payee_div").hide();
    }

}

function coaAutoCompleteBind(num)
{   
    if($("#org_to").val() == "" )
    {        
        $.bootstrapGrowl("Destination Organization cannot left blank!", {
            type: "error"
        });

        openStructure();
    }
    else{
        var coaDom = '#coa' + num;    
        $(coaDom).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: baseUrl + "/finance/accounting/coa/rawdatabudget?term=" + $(coaDom).val() + "&year="+ $("#year").val() + "&month="+ $("#month").val() +"&org=" + $("#org_to").val() + "&coa_destination=" + $("#coa_destination").val(),
                    dataType: "json",
                    success: function(json) {
                        var data = new Array();
                        for(var x = 0; x < json.length; x++) {
                            data[x] = json[x].code + " - " + json[x].name + ", Remain: "+json[x].budget_remain;
                        }
                        response(data);  
                    }
                });
            },
            minLength: 0,
        });
        
        $(coaDom).change(function()
        {   
            selectComplete(this.value, num);
        });

        $(coaDom).blur(function()
        {   
            selectComplete(this.value, num);
        });
    }
}



function moneyMaskForm()
{
    $("#total").mask('#.##0', {reverse: true});
    $("#proposed_total").mask('#.##0', {reverse: true});
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var total = "#total" + x;
        var budget_remain = "#budget_remain" + x;
        var budget_remain_hide = "#budget_remain_hide" + x;
        $(total).mask('#.##0', {reverse: true});
        $(budget_remain).mask('#.##0', {reverse: true});        
        $(budget_remain_hide).mask('#.##0', {reverse: true});
    }
}

function moneyUnMaskForm()
{

    $("#total").unmask();
    $("#proposed_total").unmask();
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var total = "#total" + x;
        var budget_remain = "#budget_remain" + x;
        var budget_remain_hide = "#budget_remain_hide" + x;
        $(total).unmask();
        $(budget_remain).unmask();
        $(budget_remain_hide).unmask();
    }

}