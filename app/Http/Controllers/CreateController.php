<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Library\CreateClass;

class CreateController extends Controller
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
    $maker = DB::table($schema.'.product_makers')->get();
    $product = DB::table($schema.'.product_names')->get();

    $array = CreateClass::GetSessionWarranty();
    foreach($array as $key => $val){
      $request->session()->pull($key);
    };

    $data = [
      'login_id'=>$login_id,
      'maker'=>$maker,
      'product'=>$product,
    ];

    return view('create.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function confirm(Request $request)
  {
    $input = $request->all();
    // $schema = $input['input']['schema'];
    // $product_maker = CreateClass::GetProductMaker($schema, $input['product_maker']);
    // $product_name = CreateClass::GetProductName($schema, $input['product_name']);
    
    foreach($input as $key => $val){
      if($key != "_token"){$request->session()->flash($key, $val);}
    };
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

    $data = [
      'login_id'=>$input['input']['login_id'],
      // 'product_maker'=>$product_maker,
      // 'product_name'=>$product_name,
    ];

    return view('create.confirm', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();

    $request->session()->reflash();
    $action = $request->input('action');
    if($action == 'back'){
      return redirect(route('create.index', ['login_id' =>$input['input']['login_id']]))->withInput($input);
    }elseif($action == 'regist'){
      $schema = $input['input']['schema'];
      $ymcount = CreateClass::GetYMCount($schema);
      $id = $input['input']['initial'].date('Y').date('m').sprintf('%04d', $ymcount);
   
      DB::table($schema.'.warranties')->insert([
        'id'=>$id,
        'name'=>session()->get('name'),
        'kana'=>session()->get('kana'),
        'tel_fix'=>session()->get('tel_fix'),
        'tel_mobile'=>session()->get('tel_mobile'),
        'zip'=>session()->get('zip'),
        'address'=>session()->get('address'),
        'product_name'=>session()->get('product_name'),
        'product_maker'=>session()->get('product_maker'),
        'product_number'=>mb_convert_kana(session()->get('product_number'), 'as'),
        'option1_name'=>session()->get('option1_name'),
        'option1_maker'=>session()->get('option1_maker'),
        'option1_number'=>mb_convert_kana(session()->get('option1_number'), 'as'),
        'option2_name'=>session()->get('option2_name'),
        'option2_maker'=>session()->get('option2_maker'),
        'option2_number'=>mb_convert_kana(session()->get('option2_number'), 'as'),
        'option3_name'=>session()->get('option3_name'),
        'option3_maker'=>session()->get('option3_maker'),
        'option3_number'=>mb_convert_kana(session()->get('option3_number'), 'as'),
        'option4_name'=>session()->get('option4_name'),
        'option4_maker'=>session()->get('option4_maker'),
        'option4_number'=>mb_convert_kana(session()->get('option4_number'), 'as'),
        'option5_name'=>session()->get('option5_name'),
        'option5_maker'=>session()->get('option5_maker'),
        'option5_number'=>mb_convert_kana(session()->get('option5_number'), 'as'),
        'date_purchase'=>session()->get('date_purchase'),
        'date_start'=>session()->get('date_start'),
        'date_end'=>session()->get('date_end'),
        'remark'=>session()->get('remark'),
        'created_at'=>now(),
        'updated_at'=>now(),
      ]);

      $array = CreateClass::GetSessionWarranty();
      foreach($array as $key => $val){
        $request->session()->forget($val);
      };
      //二重投稿防止
      $request->session()->regenerateToken();
    }

    return redirect(route('document.index', ['login_id' =>$input['input']['login_id']]).'?id='.$id);
  }
}
