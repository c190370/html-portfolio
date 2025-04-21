<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Library\InvoiceClass;

class EditController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(Request $request)
  {
    $input = $request->all();
    $schema = $input['input']['schema'];
    $login_id = $input['input']['login_id'];

    $product = DB::table($schema.'.product_names')->get();

    // echo '<pre>';
    // var_dump($yyyymm);exit;
    // echo '</pre>';

    $data = [
      'login_id'=>$login_id,
      'product'=>$product,

    ];

    return view('invoice.edit.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();
    $schema = $input['input']['schema'];

    //バリデーションルールの作成
    $rule = [
      'price.*' => ['required','numeric','string', 'digits_between:1,8'],
    ];
    $message = [
      'price.*.required' => '単価が入力されていません。',
      'price.*.numeric' => '単価は半角数字で入力してください(カンマは入力しないで下さい)。',
      'price.*.digits_between' => '単価は8桁までで入力してください。',
    ];
    //       echo '<pre>';
    // var_dump($input['price'][0]);exit;
    // echo '</pre>';
    $this->validate($request, $rule, $message);
    for($i=0;$i<count($input['price']);$i++){
          DB::table($schema.'.product_names')
          ->where('name', '=', $input['name'][$i])
          ->update([
            'price'=>$input['price'][$i],
    ]);
    }

    //二重投稿防止
    $request->session()->regenerateToken();

    $session = "変更を保存しました。";

    return redirect(route('invoice.edit.index', ['login_id' =>$input['input']['login_id']]))->with('session', $session);
  }
}
