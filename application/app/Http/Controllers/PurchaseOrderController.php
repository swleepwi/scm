<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        if(!session('pwiscm_logged')) {
            //dd("sapi");
			return redirect(url('/'));
        }        
        
    }
    
    public function index()
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        return view('grid.gridPurchaseOrder');
    }

    public function dataList($startDate, $endDate, $poNumber = '0', $orderNumber = '0')
    {
		
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
		
		if($poNumber=="0")
		{
			$poNumber = "";
		}
		
		
		if($orderNumber=="0")
		{
			$orderNumber = "";
		}
        
		$sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'ViewMaster', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_SDATE = '".$startDate."', @P_EDATE = '".$endDate."', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_PO_NO = '".$poNumber."', @P_O_NO = '".$orderNumber."'";
		
		
		
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }
	
	public function detailDataList($poNumber, $orderNumber = "0")
    {	
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'ViewDetail', @P_PO_NO = '".$poNumber."'";
		
		if($orderNumber != "0")
		{
			$sqlStmt.= ", @P_O_NO = '".$orderNumber."'";
		}
		
		
		
		
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }
	
	public function listSize($poNumber, $seqNumber)
    {	
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'ViewSize', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."'";
		
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }


}
