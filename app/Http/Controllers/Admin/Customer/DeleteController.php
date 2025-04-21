<?php

namespace App\Http\Controllers\Admin\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('validate_customer');
  }

  public function index(Request $request)
  {
    $input = $request->all();
    $id = $input['id'];

    $customer = DB::table('customers')->where('login_id', '=', $id)->get();

    $data = [
      'customer'=>$customer,
    ];

    return view('admin.customer.delete.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();
    
    DB::table('users')
    ->where('login_id', '=', $input['id'])
    ->update([
      'role'=>'delete',

    ]);

    //二重投稿防止
    $request->session()->regenerateToken();

    $session = "ユーザーを削除しました。";

    return redirect(route('admin.index'))->with('session', $session);
  }
}
