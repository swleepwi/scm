<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class DNDeleteController extends Controller
{
    public function __construct()
    {
        if(!session('pwiscm_logged')) {
            //dd("sapi");
			return redirect(url('/'));
        }        
        
    }    
	
	function deleteInserted() {
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'DetailDelete', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_DATE = '".request('out_date')."', @P_OUT_NO = '".request('out_no')."', @P_OUT_SEQ = ".request('sequence')."";
		$data = DB::select(DB::raw($sqlStmt))[0];
		
		$records = array("draw" => 0, "data" => $data);      
        return response()->json($records);   
	}

	function deleteMaster()
	{

		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_SCM_WH_OUT_MST_DELETE @P_OUT_DATE = '".request('out_date')."', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_NO = '".request('out_no')."', @P_USER_CD = '".session('pwiscm_user_id')."'";
		$data = DB::statement(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "data" => null, "query" => $sqlStmt);      
		return response()->json($records); 
		
    }
    
    function deleteMasterGet($outDate, $outNo)
    {


        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $params = ['outDate' => $outDate, 'outNo' => $outNo, 'pwiscm_factory_id' =>session('pwiscm_factory_id'), 'pwiscm_user_id' =>session('pwiscm_user_id')];
        $sqlStmt = "EXEC SP_SCM_WH_OUT_MST_DELETE @P_OUT_DATE = :outDate, @P_FAC_CD = :pwiscm_factory_id, @P_OUT_NO = :outNo, @P_USER_CD = :pwiscm_user_id";
        $sth = db::getPdo()->prepare($sqlStmt);
        $sth->execute($params);
        //$data = $sth->fetchAll(\PDO::FETCH_OBJ);
        $records = array("draw" => 0, "data" => null);      
        return response()->json($records); 

        /*
		$sqlStmt = "EXEC SP_SCM_WH_OUT_MST_DELETE @P_OUT_DATE = :outDate, @P_FAC_CD = :pwiscm_factory_id, @P_OUT_NO = :outNo, @P_USER_CD = :pwiscm_user_id";
		$data = DB::statement(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "data" => null, "query" => $sqlStmt);      
        return response()->json($records); 
        */
    }
	


}
