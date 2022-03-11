<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\AutoCode;
class TransCode {
    
    public static function defaultPrefix($transType, $orgCode) 
    {
        $prefix = array("budget_request" => "BR_" . substr($orgCode, 0, 1).substr($orgCode, -1).'_', 
                        "budget_approval" => "BA_" .substr($orgCode, 0, 1).substr($orgCode, -1).'_', 
                        "purchase_order" => "PO_" . substr($orgCode, 0, 1).substr($orgCode, -1).'_', 
                        "sales_order" => "SO_" . substr($orgCode, 0, 1).substr($orgCode, -1).'_');   
        return $prefix;
    }

    public static function getCode($transType, $orgCode)
    {
        $exist = AutoCode::where("company_id", session('erp_company')->id)->where("trans_type", $transType)->where("org_code", $orgCode)->first();
        $code = "";
        
        
        if($exist)
        {
            $lastNumber = $exist->last_number + 1;
            $code = $exist->prefix.str_repeat("0", 5 - strlen($lastNumber)).$lastNumber;
            
            $exist->last_number = $lastNumber;
            $exist->last_code = $code;
            $exist->modified_date = date("Y-m-d H:i:s");
            $exist->save();
        }
        else{
            $lastNumber = 1;
            $prefix = self::defaultPrefix($transType, $orgCode)[$transType];
            $code= $prefix.str_repeat("0", 5 - strlen($lastNumber)).$lastNumber;
            
            $newCode = new AutoCode();
            $newCode->company_id = session('erp_company')->id;
            $newCode->trans_type = $transType;
            $newCode->prefix = $prefix;
            $newCode->org_code = $orgCode;
            $newCode->last_number = $lastNumber;
            $newCode->last_code = $code;
            $newCode->add_user = session('erp_userlogin');            
            $newCode->save();
        }
        
        return $code;

    }

    public static function getNumericVoucher($transType)
    {
        if($transType == "payment"){
            $sqlStmt = "SELECT MAX(CAST(`voucher_number` AS UNSIGNED)) AS top FROM trans_payment where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "deposit"){
            $sqlStmt = "SELECT MAX(CAST(`voucher_number` AS UNSIGNED)) AS top FROM trans_deposit where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "salesorder"){
            $sqlStmt = "SELECT MAX(CAST(`trans_number` AS UNSIGNED)) AS top FROM trans_sales_order where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "purchaseorder"){
            $sqlStmt = "SELECT MAX(CAST(`trans_number` AS UNSIGNED)) AS top FROM trans_purchase_order where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }        
        else if($transType == "purchasereceive"){
            $sqlStmt = "SELECT MAX(CAST(`do_number` AS UNSIGNED)) AS top FROM trans_purchase_receive where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "salesinvoice"){
            $sqlStmt = "SELECT MAX(CAST(`invoice_number` AS UNSIGNED)) AS top FROM trans_sales_invoice where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "purchaseinvoice"){
            $sqlStmt = "SELECT MAX(CAST(`invoice_number` AS UNSIGNED)) AS top FROM trans_purchase_invoice where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "salespayment"){
            $sqlStmt = "SELECT MAX(CAST(`payment_number` AS UNSIGNED)) AS top FROM trans_sales_payment where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "purchasepayment"){
            $sqlStmt = "SELECT MAX(CAST(`payment_number` AS UNSIGNED)) AS top FROM trans_purchase_payment where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "journal"){
            $sqlStmt = "SELECT MAX(CAST(`voucher_number` AS UNSIGNED)) AS top FROM trans_journal where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "fixedjournal"){
            $sqlStmt = "SELECT MAX(CAST(`trans_number` AS UNSIGNED)) AS top FROM trans_fixedjournal where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "employee_expenses"){
            $sqlStmt = "SELECT MAX(CAST(`voucher_number` AS UNSIGNED)) AS top FROM trans_emp_expenses where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "employee_returns"){
            $sqlStmt = "SELECT MAX(CAST(`voucher_number` AS UNSIGNED)) AS top FROM trans_emp_returns where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "reconcilation"){
            $sqlStmt = "SELECT MAX(CAST(`trans_number` AS UNSIGNED)) AS top FROM trans_recon where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "budgetreallocation"){
            $sqlStmt = "SELECT MAX(CAST(`trans_number` AS UNSIGNED)) AS top FROM trans_budget_reallocation where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "budgetredistribution"){
            $sqlStmt = "SELECT MAX(CAST(`trans_number` AS UNSIGNED)) AS top FROM trans_budget_redistribution where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        else if($transType == "budgetadditional"){
            $sqlStmt = "SELECT MAX(CAST(`trans_number` AS UNSIGNED)) AS top FROM trans_budget_additional where company_id='".session('erp_company')->id."'";            
            $data = DB::select(DB::raw($sqlStmt))[0];
        }
        
        $lastNum = $data->top + 1;
        $code = "";
        for($x = 1; $x <= 7 - strlen($lastNum); $x++)
        {
            $code.= "0";
        }
        $code.= $lastNum;

        return $code;
    }

    public static function terbilang($angka){
        $angka = (float)$angka;
            
        $bilangan = array(
            '',
            'satu',
            'dua',
            'tiga',
            'empat',
            'lima',
            'enam',
            'tujuh',
            'delapan',
            'sembilan',
            'sepuluh',
            'sebelas'
        );
            
        if ($angka < 12) {
            return $bilangan[$angka];
        } else if ($angka < 20) {
            return $bilangan[$angka - 10] . ' belas';
        } else if ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) {
            return sprintf('seratus %s', self::terbilang($angka - 100));
        } else if ($angka < 1000) {
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s ratus %s', $bilangan[$hasil_bagi], self::terbilang($hasil_mod)));
        } else if ($angka < 2000) {
            return trim(sprintf('seribu %s', self::terbilang($angka - 1000)));
        } else if ($angka < 1000000) {
            $hasil_bagi = (int)($angka / 1000); // karena hasilnya bisa ratusan jadi langsung digunakan rekursif
            $hasil_mod = $angka % 1000;
            return sprintf('%s ribu %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod));
        } else if ($angka < 1000000000) {
            $hasil_bagi = (int)($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s juta %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod)));
        } else if ($angka < 1000000000000) {
            $hasil_bagi = (int)($angka / 1000000000);
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s milyar %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod)));
        } else if ($angka < 1000000000000000) {
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s triliun %s', self::terbilang($hasil_bagi), self::terbilang($hasil_mod)));
        } else {
            return 'Wow...';
        }
    }

}