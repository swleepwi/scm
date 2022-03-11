<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Session;

class CheckLogin {

    public static function isLogged()
    {
        
        if(!Session::get('pwiscm_logged')) {
            return redirect('/');
        }
        //return redirect('/');
    }    
}