<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Library\GetClass;

class EditController extends Controller
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
    $maker = DB::table($schema.'.product_makers')->get();
    $product = DB::table($schema.'.product_names')->get();

    $warranty = GetClass::GetWarrantyDetail($schema, $id);

    $data = [
      'login_id'=>$login_id,
      'maker'=>$maker,
      'product'=>$product,
      'warranty'=>$warranty,
    ];

    return view('edit.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();
    $schema = $input['input']['schema'];

    // echo '<pre>';
    // var_dump($input);exit;
    // echo '</pre>';
    //バリデーションルールの作成
    $rule = [
      'name' => ['required', 'string', 'max:50',],
      'kana' => ['required', 'string', 'max:50',],
      'tel_fix' => ['nullable', 'required_without:tel_mobile', 'regex:/^[0-9\-]+$/', 'max:15',],
      'tel_mobile' => ['nullable', 'regex:/^[0-9\-]+$/', 'max:15',],
      'zip' => ['required', 'regex:/^[0-9]+$/','max:7',],
      'address' => ['required', 'max:100'],
      'product_name' => ['required', 'max:50'],
      'product_maker' => ['required', 'max:20'],
      'product_number' => ['required', 'max:20'],
      'serial_number' => ['nullable','max:20'],
      'date_purchase' => ['required'],
      'date_start' => ['required'],
    ];
    $message = [
      'tel_fix.regex' => '固定電話に使用できるのは半角数字とハイフンのみです。',
      'tel_fix.max' => '固定電話は15桁までで入力してください。',
      'tel_fix.required_without' => '固定電話か携帯電話のいずれかを入力してください。',
      'tel_mobile.regex' => '携帯電話に使用できるのは半角数字とハイフンのみです。',
      'tel_mobile.max' => '携帯電話は15桁までで入力してください。',
      'zip.regex' => '郵便番号に使用できるのは半角数字のみです。',
      'zip.max' => '郵便番号は7桁で入力してください。',
    ];
    $this->validate($request, $rule, $message);

    DB::table($schema.'.warranties')
    ->where('id', '=', $input['id'])
    ->update([
      'name'=>$input['name'],
      'kana'=>$input['kana'],
      'tel_fix'=>$input['tel_fix'],
      'tel_mobile'=>$input['tel_mobile'],
      'zip'=>$input['zip'],
      'address'=>$input['address'],
      'product_name'=>$input['product_name'],
      'product_maker'=>$input['product_maker'],
      'product_number'=>mb_convert_kana($input['product_number'], 'as'),
      'option1_name'=>$input['option1_name'],
      'option1_maker'=>$input['option1_maker'],
      'option1_number'=>mb_convert_kana($input['option1_number'], 'as'),
      'option2_name'=>$input['option2_name'],
      'option2_maker'=>$input['option2_maker'],
      'option2_number'=>mb_convert_kana($input['option2_number'], 'as'),
      'option3_name'=>$input['option3_name'],
      'option3_maker'=>$input['option3_maker'],
      'option3_number'=>mb_convert_kana($input['option3_number'], 'as'),
      'option4_name'=>$input['option4_name'],
      'option4_maker'=>$input['option4_maker'],
      'option4_number'=>mb_convert_kana($input['option4_number'], 'as'),
      'option5_name'=>$input['option5_name'],
      'option5_maker'=>$input['option5_maker'],
      'option5_number'=>mb_convert_kana($input['option5_number'], 'as'),
      'date_purchase'=>$input['date_purchase'],
      'date_start'=>$input['date_start'],
      'date_end'=>$input['date_end'],
      'remark'=>$input['remark'],
    ]);
    //二重投稿防止
    $request->session()->regenerateToken();

    $session = "変更を保存しました。";

    return redirect(route('detail.index', ['login_id' =>$input['input']['login_id']]).'?id='.$input['id'])->with('session', $session);
  }

}
