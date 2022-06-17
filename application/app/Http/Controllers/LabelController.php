<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class LabelController extends Controller
{
    public function __construct()
    {
        if(!session('pwiscm_logged')) {
            return redirect(url('/'));
        }        
         
    }
    
    public function index()
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        return view('grid.gridLabelPrint');
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
        $sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'LabelMaster', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_SDATE = '".$startDate."', @P_EDATE = '".$endDate."', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_PO_NO = '".$poNumber."', @P_O_NO = '".$orderNumber."'";
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }
	
	public function detailByLabel($poNumber, $seqNumber)
    {	
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
		
		$sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'LabelDetail', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."'";
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);   
    }
	
	public function detailBySize($poNumber, $seqNumber, $ukSize)
    {	
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
		
		$sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'LabelSize', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."', @P_UKSIZE = '".$ukSize."'";
		$data = DB::select(DB::raw($sqlStmt));
		
		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);        
        return response()->json($records);     
    }

    public function prinLabel()
    {   
        $edit = null;
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        
        return view('labelTemplate', compact("edit")); 
    }

    public function makeLabel($poNumber, $seqNumber)
    {	
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        $sqlStmt = "EXEC SP_PO_VIEW  @iFlag = 'MakeLabel', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."', @P_USER_ID = '".session('pwiscm_user_id')."'";
		$data = DB::statement(DB::raw($sqlStmt));
		
		$records = array("result" => "Ok");        
        return response()->json($records);   
    }

    public function printBySizes($poNumber, $seqNumber, $size)
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
                
        $sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'PrintLabel', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."', @P_UKSIZE = '".$size."'";
        $data = DB::select(DB::raw($sqlStmt));   

        return view('labelBySizesQR', compact("data")); 
    }

    public function printAll($poNumber, $seqNumber)
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        $sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'LabelDetail', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."'";
        $list = DB::select(DB::raw($sqlStmt));   

        $arrSize = "";
        foreach($list as $dt)
        {
            $arrSize.= $dt->UKSIZE."|";
        }
        $arrSize = substr($arrSize, 0, strlen($arrSize) - 1);

        $sqlStmt2 = "EXEC SP_PO_VIEW @iFlag = 'PrintLabel', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."', @P_UKSIZE = '".$arrSize."'";
        $data = DB::select(DB::raw($sqlStmt2));   

        return view('labelBySizesQR', compact("data")); 
    }

    public function printBySingle($poNumber, $seqNumber, $label)
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
                       
        $sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'PrintLabel', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."', @P_LBL_ID = '".$label."'";
        $data = DB::select(DB::raw($sqlStmt));   

        return view('labelBySizesQR', compact("data")); 
    }

    public function printByLabels($poNumber, $seqNumber, $label)
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
                
        $sqlStmt = "EXEC SP_PO_VIEW @iFlag = 'PrintLabel', @P_PO_NO = '".$poNumber."', @P_PO_SEQ = '".$seqNumber."', @P_LBL_ID = '".$label."'";
        $data = DB::select(DB::raw($sqlStmt));   

        return view('labelBySizesQR', compact("data")); 
    }

    public function generateImage()
    {

        $img = request("img");
        $name = request("name");
        $folderPath =   str_replace("application","public",base_path())."\barcodes/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . $name. '.png';

        file_put_contents($file, $image_base64);
        $output = array("image_link" => $name. '.png');
        //echo str_replace("application","public",base_path());
        //return response()->json($output); 
    }

}
