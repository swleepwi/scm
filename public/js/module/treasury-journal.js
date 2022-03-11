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
        var debitDom = '#debit' + num;
        var creditDom = '#credit' + num;

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
            $(debitDom).val("");
            $(creditDom).val("");
            $(coaDom).focus();
        }
        else{

            $(coaDom).val(text[0]);
            $(coaNameDom).val(text[1]);
            $(debitDom).focus();
            
            
        }
    }    
}


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

        clone.find("#debit"+count).attr("id","debit"+next).attr("name","debit"+next).attr("onkeydown","if(event.keyCode=='13'){ if($(this).val() > 0) { $('#credit"+next+"').val(0); } checkIsNum($(this).val(), 'credit"+next+"', false); }");
        $("#debit"+next).val("");
        $("#debit"+next).mask('#.##0', {reverse: true});
        
        clone.find("#credit"+count).attr("id","credit"+next).attr("name","credit"+next).attr("onkeydown","if(event.keyCode=='13'){ if($(this).val() > 0) {$('#debit"+next+"').val(0); } checkIsNum($(this).val(), 'memo"+next+"', false); }");
        $("#credit"+next).val("");
        $("#credit"+next).mask('#.##0', {reverse: true});
        
        clone.find("#memo"+count).attr("id","memo"+next).attr("name","memo"+next).attr("onkeydown","if(event.keyCode=='13'){ newRow(); }");
        $("#memo"+next).val("");

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
    if($("#debit"+count).val() !=="" || $("#credit"+count).val() !=="") 
    { 
        newRow();
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
                $("#rowCopy"+to).find("#debit"+next).attr("id","debit"+to).attr("name","debit"+to).attr("onkeydown"," if(event.keyCode=='13'){ if(parseFloat($(this).val()) > 0) { $('#credit"+to+"').val(0); } checkIsNum($(this).val(), 'credit"+to+"', false); }");
                $("#rowCopy"+to).find("#credit"+next).attr("id","credit"+to).attr("name","credit"+to).attr("onkeydown"," if(event.keyCode=='13'){ if(parseFloat($(this).val()) > 0) { $('#debit"+to+"').val(0); } checkIsNum($(this).val(), 'memo"+to+"', false); }");
                $("#rowCopy"+to).find("#memo"+next).attr("id","memo"+to).attr("name","memo"+to).attr("onkeydown","if(event.keyCode=='13'){ newRow(); }");
                $("#rowCopy"+to).find("#delete_row"+next).attr("id","delete_row"+to).attr("name","delete_row"+to).attr("onclick","removeThis("+to+")");
                
            }
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
        if(value > 0) {

        }
        else{
            
        }
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

function calcTotal()
{   
    
    var LastNum = parseFloat($("#last_id").val()); 
    var totalDebit = 0;
    var totalCredit = 0;
    var allow = false;
    var errorline;
    for(var x = 1; x <= LastNum; x++) {
        $("#debit"+x).unmask();
        var debit = $("#debit"+x).val();
        
        $("#credit"+x).unmask();
        var credit = $("#credit"+x).val();

        if(debit == 0 && credit > 0) {
            allow = true;
        }
        else if(debit > 0 && credit == 0){
            allow = true;
        }
        else{
            errorline = x;
            break;
        }

        if(debit !="") {
            totalDebit = parseFloat(debit) + totalDebit;
        }

        if(credit !="") {
            totalCredit = parseFloat(credit) + totalCredit;
        }        

        $("#debit"+x).mask('#.##0', {reverse: true}); 
        $("#credit"+x).mask('#.##0', {reverse: true});   
    }

    if(allow) {
        if(parseFloat(totalCredit) == parseFloat(totalDebit)) {
            return true;
        }
        else{
            return false;
        }
    }
    else{
        $.bootstrapGrowl("there's not balance line!", {
            type: "error"
        });

        $("#debit"+errorline).focus();
    }

    
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
    
    var coaDom = '#coa' + num;
    
    $(coaDom).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: baseUrl + "/finance/accounting/coa/rawdata?term=" + $(coaDom).val(),
                dataType: "json",
                success: function(json) {
                    var data = new Array();
                    for(var x = 0; x < json.length; x++) {
                        data[x] = json[x].code + " - " + json[x].name;
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



function moneyMaskForm()
{
    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var debit = "#debit" + x;
        $(debit).mask('#.##0', {reverse: true});

        var credit = "#credit" + x;
        $(credit).mask('#.##0', {reverse: true});
    }
}

function moneyUnMaskForm()
{

    var count = parseFloat($("#last_id").val());
    for(var x = 1; x <= count; x++)
    {
        var debit = "#debit" + x;
        $(debit).unmask();

        var credit = "#credit" + x;
        $(credit).unmask();
    }


}