<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class UtilityController extends Controller
{
    public function __construct()
    {
        if(!session('pwiscm_logged')) {
            //dd("sapi");
			return redirect(url('/'));
        }        
        
    }
    
    public function changePasswordForm()
    {   
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        return view('form.formChangePassword');
    }

    public function changePasswordAction()
    {	
        if(!session('pwiscm_logged')) {
			return redirect(url('/'));
        } 
        //EXEC PWIERP.DBO.SP_SYS_LOGIN_MENU @iFlag = 'ChangePassword', @MENU_TYPE = 'ERP', @USER_CD = '".session('pwiscm_supplier_name')."', @USER_PW = '".request('old_password')."', @USER_PW_NEW = '".request('new_password')."'
        $sqlStmt = "EXEC PWIERP.DBO.SP_SYS_LOGIN_MENU @iFlag = 'ChangePassword', @MENU_TYPE = 'ERP', @USER_CD = '".request('username')."', @USER_PW = '".request('old_password')."', @USER_PW_NEW = '".request('new_password')."'";
        $exec = DB::select(DB::raw($sqlStmt));
        if(count($exec) == 0)
        {
            $data["SUCCESS_YN"] = "N";
            $data["RESULT_MSG"] = "Unknown Username!";
        }
        else{
            $data = $exec[0];
        }

        $records = array("draw" => 0, "data" => $data);        
        return response()->json($records);   
    }

    public function logoutApp()
    {
        Auth::logout();
        Session::flush();
        //session()->flash("notif", ["type" => "error", "notification" => "Session has timeout you need to re-login!"]);
        return redirect('/'); 
        //return redirect(url('/'));
    }

    

}
