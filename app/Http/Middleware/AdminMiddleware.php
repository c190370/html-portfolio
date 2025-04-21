<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AdminMiddleware
{
  public function handle($request, Closure $next)
  {
    if(Auth::check()){
      $check = DB::table('users')
      ->where('login_id', '=', Auth::user()->login_id)
      ->first('role');

      if($check->role !== 'admin'){
        return redirect(route('index', ['login_id' =>Auth::user()->login_id]));
      }
      return $next($request);
    }else{
      return redirect(RouteServiceProvider::HOME);
    }
      
  }
}
