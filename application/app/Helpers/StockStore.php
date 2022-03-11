<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\GeneralLedger;
use App\BudgetSplit;
use App\CoaSetup;
use App\Currency;
use App\Vendor;
use App\Customer;
use App\InventoryStock;
use App\InventoryStockMovement;
use Illuminate\Support\Facades\Session;

class StockStore {
    
    public static function addStockMovement($transDate, $itemCode, $reffNumber, $qty, $moveBy, $unitPrice, $moveType = "in") 
    {
        if($moveType == "out")
        {
            $qty = $qty * -1;
        }

        $stock = new InventoryStockMovement();
        $stock->company_id = session('erp_company')->id;
        $stock->item_code = $itemCode;
        $stock->stock_movement = $qty;
        $stock->unit_price = $unitPrice;
        $stock->trans_date = $transDate;
        $stock->reff_number = $reffNumber;
        $stock->move_by = $moveBy;
        $stock->status = 0;
        $stock->add_user = session('erp_userlogin');  
        $output = $stock->save();

        $output = self::setLastStock($moveType, $itemCode, $qty);
        return $output;
    }

    public static function removeStockMovement($itemCode, $reffNumber, $qty) 
    {
        $dStock = InventoryStockMovement::where("company_id", session('erp_company')->id)->where("item_code", $itemCode)->where("reff_number", $reffNumber)->first();
        $stock = InventoryStockMovement::find($dStock->id);
        $qty = $stock->stock_movement;

        $stock->delete();
        
        $moveType = "out";

        if($qty < 0)
        {
            $moveType = "in";
        }

        $output = self::setLastStock($moveType, $itemCode, $qty);
        return $output;
    }

    public static function setLastStock($moveType = "in", $itemCode, $qty)
    {
        if($moveType == "out")
        {
            $qty = $qty * -1;
        }

        $stockExist = InventoryStock::where("item_code", $itemCode)->where("company_id", session('erp_company')->id)->first();
        if(!$stockExist)
        {
            $newStock = new InventoryStock();
            $newStock->company_id = session('erp_company')->id;
            $newStock->item_code = $itemCode;
            $newStock->total_qty = 0;
            $newStock->add_user = session('erp_userlogin');  
            $saved = $newStock->save();
        }

        $stock = InventoryStock::where("item_code", $itemCode)->where("company_id", session('erp_company')->id)->first();
        $stock->total_qty = $stock->total_qty + $qty;
        $stock->modified_date = date("Y-m-d H:i:s");   
        $stock->modified_user = session('erp_userlogin');  
        $saved = $stock->save();    
        return $saved;
    }
}