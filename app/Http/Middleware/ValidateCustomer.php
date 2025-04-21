<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ValidateCustomer
{
  public function handle($request, Closure $next)
  {
    $input = "";
      //存在しないIDを指定した場合はリダイレクトする
      if($request->input()){
        $input = $request->input();
        $id = (!empty($input['id'])) ? ($input['id']) : NULL;
        $customer = DB::table('customers')->where('login_id', '=', $id)->exists();
          if(!$customer){
            return redirect(route('admin.index'));
          };
      };
    return $next($request);
  }
}
