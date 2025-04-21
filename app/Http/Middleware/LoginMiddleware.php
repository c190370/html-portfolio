<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginMiddleware
{
  public function handle($request, Closure $next)
  {
    if(Auth::check()){
      $customers = DB::table('customers')->where('user_id', '=', Auth::user()->id)->get();
      foreach($customers as $customer){
        $input['login_id'] = $customer->login_id;
        $input['name'] = $customer->name;
        $input['initial'] = $customer->initial;
        $input['schema'] = 'servantop_ini_'.$input['login_id'];
      }
      
      $request->merge(['input'=>$input]);
      return $next($request);
    }else{
      return redirect(RouteServiceProvider::HOME);
    }
    
  }
}
