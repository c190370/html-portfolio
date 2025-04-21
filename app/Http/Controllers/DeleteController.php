<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Library\GetClass;

class DeleteController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('validate_warrenty');
  }

  public function index(Request $request)
  {
    $input = $request->all();
    $id = $input['id'];
    $schema = $input['input']['schema'];
    $login_id = $input['input']['login_id'];

    $warranty = GetClass::GetWarrantyDetail($schema, $id);
  
    $data = [
      'login_id'=>$login_id,
      'warranty'=>$warranty,
    ];

    return view('delete.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();
    $schema = $input['input']['schema'];
    
    DB::table($schema.'.warranties')
    ->where('id', '=', $input['id'])
    ->delete();

    //二重投稿防止
    $request->session()->regenerateToken();

    $session = "保証書を削除しました。";

    return redirect(route('index', ['login_id' =>$input['input']['login_id']]))->with('session', $session);
  }
}
