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
    $("#coa_from").val(code);
    $("#coa_name").val(code+" - "+name);
}


function selectComplete(val, num)
{

    if (val.indexOf(' - ') > -1)
    {        
        var coaDom = '#coa' + num;
        var coaNameDom = '#coa_name' + num;
        var amountDom = '#amount' + num;
        var remainDom = '#remain' + num;
        var existDom = '#exist' + num;

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
            $(amountDom).val("");
            $(coaDom).focus();
        }
        else{

            var ahay = text[1].split(", Remain: ");            
            var uhuy = ahay[1].split(", Allocated: ");
            $(coaDom).val(text[0]);
            $(coaNameDom).val(ahay[0]);            
            $(remainDom).val(uhuy[0]);            
            $(existDom).val(uhuy[1]);
            $(amountDom).focus();            
        }
    }    
}
/*
function getBudgetRemain(code)
{
    
    var coa_from = code;
    var org_code = $("#org_code").val();
    var trans_date = $("#trans_date").val();

    console.log(baseUrl + "/finance/accounting/coa/coaremain/" + coa_from + "/" + org_code + "/" + trans_date);

    $.ajax({
        url: baseUrl + "/finance/accounting/coa/coaremain/" + coa_from + "/" + org_code + "/" + trans_date,
        dataType: "json",
        success: function(json) {

            return json;
            
        }
    });
}
*/

function addItem() {
    var count = parseFloat($("#last_id").val());
    
    if($("#coa"+count).val() !=="" && $("#amount"+count).val() !=="") 
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

        clone.find("#amount"+count).attr("id","amount"+next).attr("name","amount"+next).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'memo"+next+"', false); }");
        $("#amount"+next).val("");
        $("#amount"+next).mask('#.##0', {reverse: true});
        
        clone.find("#memo"+count).attr("id","memo"+next).attr("name","memo"+next).attr("onkeydown","if(event.keyCode=='13'){ calcSubTotal($(this).val(), 1); }");
        $("#memo"+next).val("");

        clone.find("#remain"+count).attr("id","remain"+next).attr("name","remain"+next);
        $("#remain"+next).val(""); 
        
        clone.find("#exist"+count).attr("id","exist"+next).attr("name","exist"+next);
        $("#exist"+next).val(""); 

        clone.find("#delete_row"+count).attr("id","delete_row"+next).attr("name","delete_row"+next).attr("onclick","removeThis("+next+")");       

        $("#last_id").val(next);
        count++;
    }
    
}

function newRow()
{
    var count = parseFloat($("#last_id").val());
    if($("#coa"+count).val() !=="" && $("#amount"+count).val() !=="") 
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
    if($("#coa"+count).val() !=="" && $("#amount"+count).val() !=="") 
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
                $("#rowCopy"+to).find("#amount"+next).attr("id","amount"+to).attr("name","amount"+to).attr("onkeydown","if(event.keyCode=='13'){ checkIsNum($(this).val(), 'memo"+to+"', false); }");
                $("#rowCopy"+to).find("#memo"+next).attr("id","memo"+to).attr("name","memo"+to).attr("onkeydown","if(event.keyCode=='13'){ calcSubTotal($(this).val(), 1); }");
                $("#rowCopy"+to).find("#remain"+next).attr("id","remain"+to).attr("name","remain"+to);
                $("#rowCopy"+to).find("#exist"+next).attr("id","exist"+to).attr("name","exist"+to);
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
    var stopNumber = 0
    var good = true;
    $("#total").unmask();
    for(var x = 1; x <= LastNum; x++) {
        $("#amount"+x).unmask();
        var amount = $("#amount"+x).val();
        var exist = $("#exist"+x).val();
        var remain = $("#remain"+x).val();

        if(amount !="") 
        {
            if(exist > 0)
            {
                var sisa = parseFloat(remain) - parseFloat(amount);
                if(sisa >= 0)
                {
                    totalTrans = parseFloat(amount) + totalTrans;
                }
                else{
                    stopNumber = x;
                    good = false;
                }
            }
            else{
                totalTrans = parseFloat(amount) + totalTrans;
            }
            
        }

        $("#amount"+x).mask('#.##0', {reverse: true});   
    }

    if(good)
    {
        $("#total").val(totalTrans);
        $("#new_item").attr("disabled", false);
        $("#button_save").show();       

        if(newRowAllowed == 1) {
            newRow();
        }

        return true;
    }
    else{
        $.bootstrapGrowl("Some Cash out amount is more then remain budget, process cannot be continue! ", {
            type: "warning"
        });
        $("#amount"+stopNumber).val("");        
        $("#amount"+stopNumber).focus();

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
    
    if($("#org_code").val() == "")
    {
        $.bootstrapGrowl("You have to choose Organization first!", {
            type: "warning"
        });
        openStructure();
    }
    else if($("#refference").val() == "")
    {
        $.bootstrapGrowl("You have to entry Refference number first", {
            type: "warning"
        });
        $("#refference").focus();
    }
    else if($("#trans_date").val() == "")
    {
        $.bootstrapGrowl("You have to fill transaction date first!", {
            type: "warning"
        });
        $("#trans_date").focus();
    }
    else{
        var dateArr = $("#trans_date").val().split("-");
        var year = dateArr[0];
        var month = dateArr[1];
        var org = $("#org_code").val();
        var coaDom = '#coa' + num;
        
        $(coaDom).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: baseUrl + "/finance/accounting/coa/rawdatabudget2?term=" + $(coaDom).val() +"&year=" + year + "&month=" + month + "&org=" + org,
                    dataType: "json",
                    success: function(json) {
                        var data = new Array();
                        for(var x = 0; x < json.length; x++) {                           
                            data[x] = json[x].code + " - " + json[x].name+ ", Remain: " + json[x].remain+ ", Allocated: " + json[x].exist;
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
    
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var amount = "#amount" + x;
        $(amount).mask('#.##0', {reverse: true});
    }
}

function moneyUnMaskForm()
{

    $("#total").unmask();
    
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var amount = "#amount" + x;
        $(amount).unmask();
    }


}