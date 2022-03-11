<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    
    public function handle($request, Closure $next)
    {
        if(!Session::get('pwiscm_logged')) {
            return redirect('/');  
        }

       return $next($request);
    }
    
}
