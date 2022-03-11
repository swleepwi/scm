<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class StatusController extends Controller
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
        return view('grid.gridStatus');
    }

    public function data()
    {

		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }


		$sqlStmt = "
    select CST_CD,sum(STAT2) as STAT2 ,sum(STAT3) as STAT3,sum(STAT4) as STAT4
    from
      (select CST_CD,
	       (case when LBL_STAT='2' then sum(ULI.QTY) end)as STAT2,
	       (case when LBL_STAT='3' then sum(ULI.QTY) end)as STAT3,
	       (case when LBL_STAT='4' and ULL.CREATE_DATE >= GETDATE() then sum(ULI.QTY) end)as STAT4
      from PWIFMS.DBO.UMS_LBL_ID ULI with(NOLOCK)
left outer join PWIFMS.DBO.UMS_LBL_LOG ULL with(NOLOCK) on (ULI.LBL_ID = ULL.LBL_ID and ULL.LOG_TYPE='4')
where ULI.CST_CD='".session('pwiscm_supplier_id')."'
group by CST_CD,LBL_STAT,ULL.CREATE_DATE
)A
group by CST_CD
    ";



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
