<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class DeliveryNoteController extends Controller
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
        return view('grid.gridDeliveryNote');
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
		$sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'NoteMaster', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_SDATE = '".$startDate."', @P_EDATE = '".$endDate."', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_PO_NO = '".$poNumber."', @P_O_NO = '".$orderNumber."'";
		$data = DB::select(DB::raw($sqlStmt));

		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);
        return response()->json($records);
    }

	public function detailDataList($outDate, $outNumber)
    {
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'NoteDetail', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_DATE = '".$outDate."', @P_OUT_NO = '".$outNumber."'";
		$data = DB::select(DB::raw($sqlStmt));

		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);
        return response()->json($records);
    }


	public function create($outNo = "0", $outDate = "")
    {
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
		}

		$sqlPPN = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'CodeCommon', @P_COM_CD = 'PPN'";
		$ppn = DB::select(DB::raw($sqlPPN));

		$sqlClass = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'CodeCommon', @P_COM_CD = 'WH_OUT_CLASS'";
		$class = DB::select(DB::raw($sqlClass));

		$sqlPOType = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'CodeCommon', @P_COM_CD = 'POMDOYN'";
		$poType = DB::select(DB::raw($sqlPOType));

		$sqlWH = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'CodeStorage', @P_FAC_CD = '".session('pwiscm_factory_id')."'";
		$wh = DB::select(DB::raw($sqlWH));

		$edit = null;
		$out_date = null;
		if($outNo !="0" )
		{
			$sqlEdit = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewMaster', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_DATE = '".$outDate."', @P_OUT_NO = '".$outNo."'";
			$edit = DB::select(DB::raw($sqlEdit))[0];
			$out_date = trim(substr($edit->OUT_DATE,0,4)."-".substr($edit->OUT_DATE,4,2)."-".substr($edit->OUT_DATE,6,2));
		}

		//dd($out_date);
        return view('form.formDeliveryNote', compact("ppn", "class", "poType", "wh", "edit", "out_date"));
    }

	public function saveMaster(Request $request)
    {
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        $out_date = str_replace("-","",request('out_date'));

		$sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'MstInsert',
		@P_FAC_CD = '".session('pwiscm_factory_id')."',
		@P_OUT_DATE = '".$out_date."',
		@P_CST_CD = '".session('pwiscm_supplier_id')."',
		@P_ST_CD = '".request('wh')."',
		@P_POMDOYN = '".request('po_type')."',
		@P_INV_NO = '".request('inv_no')."',
		@P_CONTAIN_NO = '".request('contain_no')."',
		@P_DELI_ORD_NO = '".request('deli_order_no')."',
		@P_MOBIL_NO = '".request('mobil_no')."',
		@P_OUT_CLASS = '".request('class')."',
		@P_VAT_RATE = '".request('ppn')."',
		@P_REMARK = '".request('remark')."',
		@P_USER_ID = '".session('pwiscm_user_id')."'";

		if(!empty(request('out_no'))){
			$sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'MstInsert',
			@P_FAC_CD = '".session('pwiscm_factory_id')."',
			@P_OUT_DATE = '".$out_date."',
			@P_OUT_NO = '".request('out_no')."',
			@P_CST_CD = '".session('pwiscm_supplier_id')."',
			@P_ST_CD = '".request('wh')."',
			@P_POMDOYN = '".request('po_type')."',
			@P_INV_NO = '".request('inv_no')."',
			@P_CONTAIN_NO = '".request('contain_no')."',
			@P_DELI_ORD_NO = '".request('deli_order_no')."',
			@P_MOBIL_NO = '".request('mobil_no')."',
			@P_OUT_CLASS = '".request('class')."',
			@P_VAT_RATE = '".request('ppn')."',
			@P_REMARK = '".request('remark')."',
			@P_USER_ID = '".session('pwiscm_user_id')."'";
		}

		$data = DB::select(DB::raw($sqlStmt))[0];

		$records = array("draw" => 0, "data" => $data);
        return response()->json($records);
	}

	public function detailCrateList($outDate, $outNumber)
    {
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        $sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewDetail', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_DATE = '".$outDate."', @P_OUT_NO = '".$outNumber."'";
		$data = DB::select(DB::raw($sqlStmt));

		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);
        return response()->json($records);
	}

	public function searchPOToAdd($poNumber, $orderNumber,$barcodeNumber)
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

        if($barcodeNumber=="0")
    {
      $barcodeNumber = "";
    }

		if($poNumber == "" && $orderNumber == "" && $barcodeNumber == "")
		{
			$sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewScan', @P_CST_CD = '".session('pwiscm_supplier_id')."'";
			$data = DB::select(DB::raw($sqlStmt));

		}
		elseif($poNumber !== "" && $orderNumber == "" && $barcodeNumber == "")
		{
			$sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewScan', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_PO_NO = '".$poNumber."'";
			$data = DB::select(DB::raw($sqlStmt));

		}
		elseif($poNumber == "" && $orderNumber !== "" && $barcodeNumber == "")
		{
			$sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewScan', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_O_NO='".$orderNumber."'";
			$data = DB::select(DB::raw($sqlStmt));

		}
    elseif($poNumber == "" && $orderNumber == "" && $barcodeNumber !== "")
    {
      $sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewScan', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_LBL_ID='".$barcodeNumber."'";
      $data = DB::select(DB::raw($sqlStmt));

    }
		else{
			$sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewScan', @P_CST_CD = '".session('pwiscm_supplier_id')."', @P_PO_NO = '".$poNumber."', @P_O_NO='".$orderNumber."'";
			$data = DB::select(DB::raw($sqlStmt));
		}


		$records = array("draw" => 0, "recordsTotal" => 0, "recordsFiltered" => 0, "data" => $data);
        return response()->json($records);
	}

	public function insertDetailDN()
    {


		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        $params = [
			'outDate' => request('out_date'),
			'outNo' => request('out_no'),
			'pwiscm_factory_id' =>session('pwiscm_factory_id'),
			'pwiscm_supplier_id' =>session('pwiscm_supplier_id'),
			'wh' =>request('wh'),
			'pwiscm_user_id' =>session('sequence'),
			'labels' =>request('labels')
		];
		$sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'DetailSave',
					@P_FAC_CD = :pwiscm_factory_id,
					@P_OUT_DATE = :outDate,
					@P_OUT_NO = :outNo,
					@P_CST_CD = :pwiscm_supplier_id,
					@P_ST_CD = :wh,
					@P_LBL = :labels,
					@P_USER_ID = :pwiscm_user_id";

		$sth = db::getPdo()->prepare($sqlStmt);
		$sth->execute($params);
		$data = $sth->fetchAll(\PDO::FETCH_OBJ);
		$records = array("draw" => 0, "data" => $data[0]);
		return response()->json($records);


		/*
		$sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'DetailSave',
					@P_FAC_CD = '".session('pwiscm_factory_id')."',
					@P_OUT_DATE = '".request('out_date')."',
					@P_OUT_NO = '".request('out_no')."',
					@P_CST_CD = '".session('pwiscm_supplier_id')."',
					@P_ST_CD = '".request('wh')."',
					@P_LBL = '".request('labels')."',
					@P_USER_ID = '".session('pwiscm_user_id')."'";

		$data = DB::select(DB::raw($sqlStmt))[0];

		$records = array("draw" => 0, "data" => $data);
		return response()->json($records);
		*/
	}

	function deleteInserted() {

		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        $params = [
				'outDate' => request('out_date'),
				'outNo' => request('out_no'),
				'pwiscm_factory_id' =>session('pwiscm_factory_id'),
				'sequence' =>request('sequence')
		];
		$sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'DetailDelete', @P_FAC_CD = :pwiscm_factory_id, @P_OUT_DATE = :outDate, @P_OUT_NO = :outNo, @P_OUT_SEQ = :sequence";
        $sth = db::getPdo()->prepare($sqlStmt);
		$sth->execute($params);
		$data = $sth->fetchAll(\PDO::FETCH_OBJ);
        $records = array("draw" => 0, "data" => $data[0]);
		return response()->json($records);

		/*
		$sqlStmt = "EXEC SP_DELIVERY_NOTE_SAVE @iFlag = 'DetailDelete', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_DATE = '".request('out_date')."', @P_OUT_NO = '".request('out_no')."', @P_OUT_SEQ = ".request('sequence')."";
		$data = DB::select(DB::raw($sqlStmt))[0];

		$records = array("draw" => 0, "data" => $data);
		return response()->json($records);
		*/
	}

	function deleteMaster()
	{

		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        }
        $params = ['outDate' => request('out_date'), 'outNo' => request('out_no'), 'pwiscm_factory_id' =>session('pwiscm_factory_id'), 'pwiscm_user_id' =>session('pwiscm_user_id')];
        $sqlStmt = "EXEC SP_SCM_WH_OUT_MST_DELETE @P_OUT_DATE = :outDate, @P_FAC_CD = :pwiscm_factory_id, @P_OUT_NO = :outNo, @P_USER_CD = :pwiscm_user_id";
        $sth = db::getPdo()->prepare($sqlStmt);
        $sth->execute($params);
        $records = array("draw" => 0, "data" => null);
        return response()->json($records);

       /*
		$sqlStmt = "EXEC SP_SCM_WH_OUT_MST_DELETE @P_OUT_DATE = '".request('out_date')."', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_NO = '".request('out_no')."', @P_USER_CD = '".session('pwiscm_user_id')."'";
		$data = DB::statement(DB::raw($sqlStmt));

		$records = array("draw" => 0, "data" => null, "query" => $sqlStmt);
		return response()->json($records);
		*/

	}


	function DNprint($outNo, $outDate)
	{
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
		}

		$edit = null;
		$out_date = null;

		if($outNo !="0" )
		{

			$sqlEdit = "SELECT CST.CST_NM, OM.OUT_DATE + '-' + OM.FAC_CD + '-' + OM.OUT_NO AS DELIVERY_NO, OM.INV_NO
			, CST.ADDRESS1 AS CST_ADDRESS1, CST.ADDRESS2 AS CST_ADDRESS2, CST.ADDRESS3 AS CST_ADDRESS3
			, FAC.ADDRESS1 AS BUYER_ADDRESS1, FAC.ADDRESS2 AS BUYER_ADDRESS2, FAC.ADDRESS3 AS BUYER_ADDRESS3
			, CST.TEL_NO, CST.FAX_NO, CST.EMAIL_ACC AS EMAIL
			, '@SCM;' + OM.OUT_DATE + ';' + OM.FAC_CD + ';' + OM.OUT_NO AS BARCODE, OM.REMARK
			FROM PWISCM.DBO.SCM_WH_OUT_MST OM
			LEFT JOIN PWIERP.DBO.MST_SUPPLIER CST ON (CST.CST_CD = OM.CST_CD)
			LEFT JOIN PWIERP.DBO.MST_FAC FAC ON (FAC.FAC_CD = OM.FAC_CD)
			WHERE OM.OUT_DATE = '".$outDate."'
			AND OM.FAC_CD   = '".session('pwiscm_factory_id')."'
			AND OM.OUT_NO   = '".$outNo."'";
			$edit = DB::select(DB::raw($sqlEdit))[0];

			//dd($edit);
			//$out_date = trim(substr($edit->OUT_DATE,0,4)."-".substr($edit->OUT_DATE,4,2)."-".substr($edit->OUT_DATE,6,2));


			$sqlDetail = "SELECT OD.*
				, CASE WHEN LEN(SIZE_COL) = 0 THEN SIZE_COL
					   ELSE LEFT(SIZE_COL, LEN(SIZE_COL) - 1) END AS SIZE_RUN
			 FROM (SELECT OD.OUT_SEQ
						, OD.ARTNO, ART.ARTICLEDESC
						, OM.O_NO, OM.ORDER_QTY
						, ISNULL(OP.PART_NM, OD.MAT_CD) AS PART_NM
						, OD.OUT_QTY AS SCAN_QTY
						, OD.PO_NO, OD.PO_SEQ
						, (SELECT S.UKSIZE + '/' + LTRIM(REPLACE (STR(S.CST_OUT_QTY, 18, 2), '.00', '')) + ', '
							 FROM PWISCM.DBO.SCM_WH_OUT_SIZE S
							 LEFT JOIN PWIERP.DBO.MST_STD_SIZE SS ON (SS.BUYER = OD.BUYER AND SS.GENDER_CD = OD.GENDER_CD AND SS.FIX_SIZE = S.UKSIZE)
							WHERE S.OUT_DATE = OD.OUT_DATE AND S.FAC_CD = OD.FAC_CD
							  AND S.OUT_NO = OD.OUT_NO AND S.OUT_SEQ = OD.OUT_SEQ
							ORDER BY ISNULL(SS.SEQ, '999'), S.UKSIZE FOR XML PATH ('')) AS SIZE_COL
						, (SELECT COUNT(*)
							 FROM PWIFMS.DBO.UMS_LBL_LOG A
							WHERE A.LOG_TYPE = '3' AND A.LINK_NO LIKE OD.OUT_DATE + ';' + OD.FAC_CD + ';' + OD.OUT_NO + ';' + LTRIM(STR(OD.OUT_SEQ)) + '%') AS PACK_QTY
					 FROM PWISCM.DBO.SCM_WH_OUT_DET OD WITH (NOLOCK)
					 LEFT JOIN PWIERP.DBO.SAL_ORDER_MST OM ON (OM.PWI_NO = OD.PWI_NO)
					 LEFT JOIN PWIERP.DBO.MST_ARTICLE ART ON (ART.ARTNO = OD.ARTNO)
					 LEFT JOIN PWIERP.DBO.MST_OUT_PROCESS OP ON (OP.MAT_CD = OD.MAT_CD)
					 WHERE OD.OUT_DATE = '".$outDate."'
								AND OD.FAC_CD   = '".session('pwiscm_factory_id')."'
								AND OD.OUT_NO   = '".$outNo."') OD
			ORDER BY OD.OUT_SEQ;

			";

			$detail = DB::select(DB::raw($sqlDetail));

			/*
			$params = ['outDate' => $outDate, 'outNo' => $outNo, 'pwiscm_factory_id' =>session('pwiscm_factory_id')];
			$sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'PrintNote', @P_FAC_CD =:pwiscm_factory_id, @P_OUT_DATE =:outDate, @P_OUT_NO =:outNo";
			$sth = db::getPdo()->prepare($sqlStmt);
			$sth->execute($params);
			$data = $sth->fetchAll(\PDO::FETCH_OBJ);
			$records = array("draw" => 0, "data" => null);
			*/

			//$sqlEdit = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'PrintNote', @P_FAC_CD = '".session('pwiscm_factory_id')."', @P_OUT_DATE = '".$outDate."', @P_OUT_NO = '".$outNo."'";
			//$data = DB::select(DB::unprepared($sqlEdit));

			$out_no = $outNo;
			$out_date = $outDate;

		}


		//echo "<pre>";
		//print_r($detail[0]);
        return view('DNPrint', compact("edit", "detail", "out_date", "out_no"));
	}

	public function listSize($poNumber, $poSeq, $outDate, $outNumber, $outSeq, $buyer, $gender)
    {
		if(!session('pwiscm_logged')) {
			return redirect(url('/'));
		}


		$sqlStmt = "EXEC SP_DELIVERY_NOTE_VIEW @iFlag = 'ViewSize',
					@P_FAC_CD = '".session('pwiscm_factory_id')."',
					@P_CST_CD = '".session('pwiscm_supplier_id')."',
					@P_PO_NO = '".$poNumber."',
					@P_PO_SEQ = '".$poSeq."',
					@P_OUT_DATE = '".$outDate."',
					@P_OUT_NO = '".$outNumber."',
					@P_OUT_SEQ = ".$outSeq.",
					@P_BUYER = '".$buyer."',
					@P_GENDER = '".$gender."'";


		$data = DB::select(DB::raw($sqlStmt));

		$records = array("draw" => 0, "recordsTotal" => count($data), "recordsFiltered" => count($data), "data" => $data);
        return response()->json($records);
    }



}
