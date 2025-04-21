<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ValidateWarrenty
{
  public function handle($request, Closure $next)
  {
    $input = "";
      //存在しないIDを指定した場合はリダイレクトする
      if($request->input()){
        $input = $request->input();
        $id = (!empty($input['id'])) ? ($input['id']) : NULL;
        if(Auth::User()->role == 'admin'){
          $customer = DB::table('customers')->where('login_id', '=', $input['user'])->exists();
          if(!$customer){
            return redirect(route('admin.index'));
          };
          $schema = 'servantop_ini_'.$input['user'];
          $warranty = DB::table($schema.'.warranties')->where('id', '=', $id)->exists();
          if(!$warranty){
            return redirect(route('admin.warranty.index').'?user='.$input['user']);
          }
        }else{
          $schema = $input['input']['schema'];
          $warranty = DB::table($schema.'.warranties')->where('id', '=', $id)->exists();
          if(!$warranty){
            return redirect(route('index', ['login_id' =>$input['input']['login_id']]));
          }
        }


      };
    return $next($request);
  }
}
