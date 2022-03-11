<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class BarcodeScanController extends Controller
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
        return view('grid.gridBarcodeScan');
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
        
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ScanDetail', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_SDATE = '".$startDate."', @P_EDATE = '".$endDate."', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_PO_NO = '".$poNumber."', @P_O_NO = '".$orderNumber."'";
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }
	
	public function detailBarcodeSize($poNumber, $poSequence)
    {	
        
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ScanSize', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$poSequence."'";
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }

    public function barcodeScan()
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        return view('form.formBarcodeScan');
    }
    
    public function getScannedData()
    {	
        
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $outDate = date("Ymd");
        
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ScanView', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_DATE = '".$outDate."', @P_CST_CD = '".session('pwiscm_supplier_id')."'";
        $data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }

    public function scanInsert()
    {	        
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'ScanInsert', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_LBL_ID = ".request('label_id').", @P_USER_ID = '".session('pwiscm_user_id')."'";
        $data = DB::select(DB::raw($sqlStmt))[0];
		
		$records = array("draw" => 0, "data" => $data);        
        return response()->json($records);   
    }

    public function scanDelete()
    {	
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'ScanDelete', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_LBL_ID = ".request('label_id').", @P_LINK_NO = '".request('link_no')."'";
        $data = DB::select(DB::raw($sqlStmt))[0];
		
		$records = array("draw" => 0, "data" => $data);        
        return response()->json($records);   
    }



}
