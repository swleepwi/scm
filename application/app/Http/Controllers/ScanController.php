<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ScanController extends Controller
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

        return view('form.formScanBarcode');
    }

}
