<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\AppConfig;
use App\Company;
use App\AppAccountModule;
use App\UserGroup;
use App\AppModule;
use App\OrganizationStructure;
use App\Employeeprofil;
use App\Helpers\OrgTree;

class LoginSystemController extends Controller
{
    

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function LoginAction(Request $request){



        $userName = request("username");
        $password = request("password");
        
        $notif = "Login fail, please check your authentication";
        $type = "warning";
        
		$sqlStmt = "EXEC PWIERP.DBO.SP_SYS_LOGIN_MENU @iFLAG = 'LoginSCM', @MENU_TYPE = 'SCM', @USER_CD = '".$userName."', @USER_PW = '".$password."'";
        $user = DB::select(DB::raw($sqlStmt));
		
        if(count($user) > 0) {
            $user = (object) $user[0];   
            
			if($user->SUCCESS_YN == "Y")
			{
				Session::put('pwiscm_logged', TRUE);
				Session::put('pwiscm_user_id', $user->USER_CD);                
				Session::put('pwiscm_supplier_name', $user->USER_NM);
				Session::put('pwiscm_supplier_id', $user->CST_CD);            
				Session::put('pwiscm_company_name', $user->CST_NM);
				Session::put('pwiscm_factory_id', $user->FAC_CD);
				
				$notif = "Welcome! ".session('pwiscm_supplier_name')." [".session('pwiscm_company_name')."]";
                $type = "success";
                session()->flash("notif", ["type" => $type, "notification" => $notif]);
                return redirect('/po/management'); 

			}
			
        }

        session()->flash("notif", ["type" => $type, "notification" => $notif]);
        return redirect('/'); 

    }

}
