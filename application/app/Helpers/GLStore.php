<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\GeneralLedger;
use App\BudgetSplit;
use App\CoaSetup;
use App\Currency;
use App\Vendor;
use App\Customer;
use Illuminate\Support\Facades\Session;

class GLStore {
    
    private static function getLastNumber(){
        $sqlStmt = "SELECT IF(MAX(DISTINCT(gl_number)) IS NULL, 0, MAX(DISTINCT(gl_number))) + 1 AS gl_number
                FROM `trans_gl` WHERE company_id='".session('erp_company')->id."'";

        $data = DB::select(DB::raw($sqlStmt));
        $glNumber = $data[0]->gl_number;

        return $glNumber;

    }

    public static function removeGL($transType, $reffNumber) 
    {
        GeneralLedger::where("company_id", session('erp_company')->id)
        ->where("trans_type", $transType)->where("reff_number", $reffNumber)->delete();
    }

    public static function addGL($currency, $coa, $type, $date, $amount = 0, $month = null, $year = null, $transType = null, $reffNumber = null, $memo = null, $glNumber = null, $cheque_number = null, $org_code = null) 
    {
        $numericDate = strtotime($date);
        if(empty($month)) 
        {
            $month  = date("m", $numericDate);
        }

        if(empty($year))
        {
            $year   = date("Y", $numericDate);
        }

        if(empty($glNumber))
        {
            $glNumber = self::getLastNumber();
        }
        
        $ratesToIDR = 0;
        if(!empty($currency))
        {
            $curr = Currency::where("company_id", session('erp_company')->id)->where("code", $currency)->first();
            $ratesToIDR = $curr->rates_to_idr;
        }
        $posting = new GeneralLedger;
        $posting->company_id = session('erp_company')->id;
        $posting->gl_number = $glNumber;
        $posting->trans_date = $date;
        $posting->trans_type = $transType;
        $posting->reff_number = $reffNumber;
        $posting->year = $year;
        $posting->month = $month;
        $posting->currency = $currency;
        $posting->rates_to_idr = $ratesToIDR;
        $posting->org_code = $org_code;
        $posting->cheque_number = $cheque_number;
        $posting->coa = $coa;

        if($type == "debit") {
            $posting->amount = $amount;
            $posting->debit = $amount;
        }
        else{
            $posting->amount = $amount * -1;
            $posting->credit = $amount;
        }
        
        $posting->memo = $memo;
        $output = $posting->save();

        return $glNumber;
    }

    public static function updateBudgetRemain($date, $coa, $amount, $orgCode, $insert = true) 
    {

        $numericDate = strtotime($date);
        $month  = date("m", $numericDate);
        $year   = date("Y", $numericDate);
        
        $remainField = "remain_".$month;
        $saved = false;
        
        $edit = BudgetSplit::where("company_id", session('erp_company')->id)
                    ->where("org_code", $orgCode)
                    ->where("year", $year)
                    ->where("coa", $coa)->first();
       
        if(!empty($edit) > 0)
        {
            if($insert)
            {

                $sqlStmt = "UPDATE trans_budget_split set `".$remainField."` = `".$remainField."` - ".$amount." 
                            WHERE company_id='".session('erp_company')->id."' and org_code = '".$orgCode."' and year = '".$year."' and coa='".$coa."'";

                $saved = DB::statement($sqlStmt);
            }
            else
            {
                $sqlStmt = "UPDATE trans_budget_split set `".$remainField."` = `".$remainField."` + ".$amount." 
                            WHERE company_id='".session('erp_company')->id."' and org_code = '".$orgCode."' and year = '".$year."' and coa='".$coa."'";

                $saved = DB::statement($sqlStmt);
            }
        }        

        return $saved;
    }

    public static function getCoaByType($typeCode, $currency) 
    {
        $data = CoaSetup::where("company_id", session('erp_company')->id)->where("type_code", $typeCode)->where("currency", $currency)->first();
        return $data->coa;
    }

    public static function updateVendorBalance($vendorId, $balance, $type)
    {
        $data = Vendor::where("id", $vendorId)->first();
        if($type === "credit")
        {
            $data->balance = $data->balance + $balance;
        }
        else{
            $data->balance = $data->balance - $balance;
        }
        $saved = $data->save();
        
        return $saved;
    }

    public static function updateCustomerBalance($customerId, $balance, $type)
    {
        $data = customer::where("id", $customerId)->first();
        if($type === "credit")
        {
            $data->balance = $data->balance + $balance;
            //dd($balance);
        }
        else{
            $data->balance = $data->balance - $balance;
        }   
        $saved = $data->save();
        
        return $saved;
    }

    
}