<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\GeneralLedger;
use App\CoaSetup;
use App\Currency;
use App\AccountClassify;
use App\TransAccountClassify;
use App\Helpers\GLStore;
use Illuminate\Support\Facades\Session;

class AccClassifyStore {
    
    public static function addClassify($code, $sql, $writeOn) 
    {
        $delete = TransAccountClassify::where("company_id",  session('erp_company')->id)
                ->where("write_on", $writeOn)
                ->where("class_code", $code)                
                ->where("year", session("erp_config")->year_active)
                ->where("month", session("erp_config")->month_active)
                ->delete(); 
        
        
        $class = AccountClassify::where("company_id",  session('erp_company')->id)->where("code", $code)->first();
        $sqlStmt = "SELECT SUM(a.amount) AS `value` FROM ($sql) AS a";
        
        $data = DB::select(DB::raw($sqlStmt))[0];               
        
        $transAccount = new TransAccountClassify;
        $transAccount->company_id = session('erp_company')->id;
        $transAccount->write_on = $writeOn;
        $transAccount->class_code = $class->code;
        $transAccount->year = session("erp_config")->year_active;
        $transAccount->month = session("erp_config")->month_active;
        $transAccount->value = $data->value;
        $transAccount->add_user = session('erp_userlogin');
        $output = $transAccount->save();

        return $output;
    }
    
    public static function directAddClassify($code, $vals, $writeOn, $date, $orgCode = null, $coa = null) 
    {
        $month = date("m",strtotime($date));
        $year = date("Y",strtotime($date));

        if(empty($orgCode))
        {
            /*
            $sqlStmt = "SELECT * FROM mst_org_structure WHERE company_id='".session("erp_company")->id."' AND parent_code IN 
                        (SELECT `code` FROM `mst_org_structure` WHERE company_id='".session("erp_company")->id."' AND (`parent_code` IS NULL OR `parent_code`=''))";
            $org = DB::select(DB::raw($sqlStmt))[0];

            $orgCode = $org->code;
            */

            $orgCode = "ALL";
        }
        
        $delete = TransAccountClassify::where("company_id",  session('erp_company')->id)
                ->where("org_code", $orgCode)
                ->where("write_on", $writeOn)
                ->where("class_code", $code)                
                ->where("year", $year)
                ->where("month", $month)
                ->delete(); 
        
        
        //$sqldelete = "delete from trans_account_class where company_id='".session('erp_company')->id."' and org_code='".$orgCode."' and write_on='".$writeOn."' and class_code='". $code."' and year='".session("erp_config")->year_active."' and month='".session("erp_config")->month_active."'";
        //dd($sqldelete);
        //$delete = DB::statement(DB::raw($sqldelete));

        
                        
        $sql = "insert into trans_account_class (`company_id`,`org_code`,`write_on`,`class_code`,`year`,`month`,`value`,`add_user`)
                values ('".session('erp_company')->id."', '".$orgCode."', '".$writeOn."','".$code."','".$year."','".$month."','".$vals."','".session('erp_userlogin')."')";
        
        $output = DB::statement(DB::raw($sql));

                        
        return $output;
    }    

    public static function postingLabaRugi($startDate, $endDate) 
    {
        $month = date("m",strtotime($endDate));
        $year = date("Y",strtotime($endDate));

        if($month == session("erp_config")->month_active && $year == session("erp_config")->year_active)
        { 
            $sqlCoa = "SELECT * FROM app_coa_config WHERE `type_code`='L1' AND `currency`='IDR' AND `company_id`='".session('erp_company')->id."'";
            $dataCoa = DB::select(DB::raw($sqlCoa))[0];
            $coaLabaRugi = $dataCoa->coa;

            $delete = GeneralLedger::where("company_id", session("erp_company")->id)
                    ->where("trans_type", "income_statement")
                    ->where("year", $year)
                    ->where("gl_number", 0)
                    ->where("month", $month)        
                    ->where("org_code", "ALL")            
                    ->where("coa", $coaLabaRugi)->delete();

            
            $sqlSelect = "SELECT
                        a.amount AS Pendapatan, 
                        b.amount AS BebanPokok, 
                        c.amount AS BebanUsaha, 
                        d.amount AS PendapatanNonUsaha, 
                        e.amount AS BebanNonUsaha, 
                        f.amount AS BebanPajak
                        FROM (
                            SELECT a.relasi, SUM(a.amount) AS amount FROM (
                                SELECT 1 AS relasi, d.name , IFNULL(ABS(SUM(b.amount * b.rates_to_idr)), 0) AS amount
                                FROM mst_coa a JOIN mst_coa d ON d.`company_id`=a.`company_id` AND d.`code`=a.`coa_header4`
                                LEFT JOIN `trans_gl` b ON b.coa=a.`code` AND b.`company_id`=a.`company_id` AND (b.`trans_date` <= '".$endDate."')
                                WHERE a.`company_id`='".session('erp_company')->id."' AND a.coa_header3='4.06.1' AND a.level_number=5
                                GROUP BY a.coa_header4
                            ) a
                        ) AS a
                        JOIN
                        (	
                            SELECT a.relasi, SUM(a.amount) AS amount FROM (
                                SELECT 1 AS relasi, d.name , IFNULL(ABS(SUM(b.amount * b.rates_to_idr)), 0) AS amount
                                FROM mst_coa a JOIN mst_coa d ON d.`company_id`=a.`company_id` AND d.`code`=a.`coa_header4`
                                LEFT JOIN `trans_gl` b ON b.coa=a.`code` AND b.`company_id`=a.`company_id` AND (b.`trans_date` <= '".$endDate."')
                                WHERE a.`company_id`='".session('erp_company')->id."' AND a.coa_header3='5.07.1' AND a.level_number=5
                                GROUP BY a.coa_header4	
                            ) a
                        ) AS b ON b.relasi=a.relasi
                        JOIN
                        (
                            SELECT a.relasi, SUM(a.amount) AS amount FROM (
                                SELECT 1 AS relasi, d.name , IFNULL(ABS(SUM(b.amount * b.rates_to_idr)), 0) AS amount
                                FROM mst_coa a JOIN mst_coa d ON d.`company_id`=a.`company_id` AND d.`code`=a.`coa_header4`
                                LEFT JOIN `trans_gl` b ON b.coa=a.`code` AND b.`company_id`=a.`company_id` AND (b.`trans_date` <= '".$endDate."')
                                WHERE a.`company_id`='".session('erp_company')->id."' AND a.coa_header3='6.08.1' AND a.level_number=5
                                GROUP BY a.coa_header4
                            ) a
                        ) AS c ON c.relasi=a.relasi
                        JOIN
                        (
                            SELECT a.relasi, SUM(a.amount) AS amount FROM (
                                SELECT 1 AS relasi, d.name , IFNULL(ABS(SUM(b.amount * b.rates_to_idr)), 0) AS amount
                                FROM mst_coa a JOIN mst_coa d ON d.`company_id`=a.`company_id` AND d.`code`=a.`coa_header4`
                                LEFT JOIN `trans_gl` b ON b.coa=a.`code` AND b.`company_id`=a.`company_id` AND (b.`trans_date` <= '".$endDate."')
                                WHERE a.`company_id`='".session('erp_company')->id."' AND a.coa_header3='7.09.1' AND a.level_number=5
                                GROUP BY a.coa_header4
                            ) a
                        ) AS d ON d.relasi=a.relasi
                        JOIN
                        (
                            SELECT a.relasi, SUM(a.amount) AS amount FROM (
                                SELECT 1 AS relasi, d.name , IFNULL(ABS(SUM(b.amount * b.rates_to_idr)), 0) AS amount
                                FROM mst_coa a JOIN mst_coa d ON d.`company_id`=a.`company_id` AND d.`code`=a.`coa_header4`
                                LEFT JOIN `trans_gl` b ON b.coa=a.`code` AND b.`company_id`=a.`company_id` AND (b.`trans_date` <= '".$endDate."')
                                WHERE a.`company_id`='".session('erp_company')->id."' AND a.coa_header3='8.10.1' AND a.level_number=5
                                GROUP BY a.coa_header4
                            ) a
                        ) AS e ON e.relasi=a.relasi
                        JOIN
                        (
                            SELECT a.relasi, SUM(a.amount) AS amount FROM (
                                SELECT 1 AS relasi, d.name , IFNULL(ABS(SUM(b.amount * b.rates_to_idr)), 0) AS amount
                                FROM mst_coa a JOIN mst_coa d ON d.`company_id`=a.`company_id` AND d.`code`=a.`coa_header4`
                                LEFT JOIN `trans_gl` b ON b.coa=a.`code` AND b.`company_id`=a.`company_id` AND (b.`trans_date` <= '".$endDate."')
                                WHERE a.`company_id`='".session('erp_company')->id."' AND a.coa_header3='9.11.1' AND a.level_number=5
                                GROUP BY a.coa_header4
                            ) a
                        ) AS f ON f.relasi=a.relasi";

            $dataLR = DB::select(DB::raw($sqlSelect))[0];

            $laba_kotor = $dataLR->Pendapatan + $dataLR->BebanPokok;
            $laba_sebelum_pajak = ($laba_kotor - $dataLR->BebanUsaha) + ($dataLR->PendapatanNonUsaha - $dataLR->BebanNonUsaha);
            $laba_setelah_pajak = $laba_sebelum_pajak - $dataLR->BebanPajak;
            
            
            $sql = "INSERT into trans_gl (`company_id`,`gl_number`,`trans_date`,`trans_type`,`year`,`month`,`currency`,`rates_to_idr`, `coa`, `org_code`, `amount`, `credit`)
                    values ('".session('erp_company')->id."', 0, '".$startDate."','income_statement','".$year."','".$month."','IDR', '1', '".$coaLabaRugi."', 'ALL', '".$laba_setelah_pajak."', '".$laba_setelah_pajak."')";

            //dd($sql);
            $output = DB::statement(DB::raw($sql));
        }
            
    }
}