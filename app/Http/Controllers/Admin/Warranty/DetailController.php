<?php

namespace App\Http\Controllers\Admin\Warranty;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Library\HomeClass;

class DetailController extends Controller
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
    $schema = 'servantop_ini_'.$input['user'];

    $warranty = DB::table($schema.'.warranties')->where('id', '=', $id)->get();
  
    //    echo '<pre>';
    // var_dump($warrenty);exit;
    // echo '</pre>';

    $data = [
      'user'=>$input['user'],
      'warranty'=>$warranty,
    ];

    return view('admin.warranty.detail.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function confirm(Request $request)
  {
    $input = $request->all();
    $charge = CreateClass::GetChargeName($input['charge']);
    foreach($input as $key => $val){
      if($key != "_token"){$request->session()->flash($key, $val);}
    };
    // echo '<pre>';
    // var_dump($charge->name);exit;
    // echo '</pre>';
    //バリデーションルールの作成
    $rule = [
      'name' => ['required', 'string', 'max:50',],
      'kana' => ['required', 'string', 'max:50',],
      'tel_fix' => ['nullable', 'required_without:tel_mobile', 'regex:/^[0-9]+$/', 'max:11',],
      'tel_mobile' => ['nullable', 'regex:/^[0-9]+$/', 'max:11',],
      'zip' => ['required', 'regex:/^[0-9]+$/','max:7',],
      'address' => ['required', 'max:100'],
      'product_name' => ['required', 'max:50'],
      'product_maker' => ['required', 'max:20'],
      'product_number' => ['required', 'max:20'],
      'serial_number' => ['nullable', 'max:20'],
      'date_purchase' => ['required'],
      'date_start' => ['required'],
    ];
    $message = [
      'name.required' => '顧客名を入力してください。',
      'name.string' => '使用できない文字が含まれています。',
      'name.max' => '顧客名に使用できる文字数は50文字までです。',
      'kana.required' => '顧客名フリガナを入力してください。',
      'kana.string' => '使用できない文字が含まれています。',
      'kana.max' => '顧客名フリガナに使用できる文字数は50文字までです。',
      'tel_fix.regex' => '固定電話に使用できるのは半角数字のみです。',
      'tel_fix.max' => '固定電話は11桁までで入力してください。',
      'tel_fix.required_without' => '固定電話か携帯電話のいずれかを入力してください',
      'tel_mobile.regex' => '携帯電話に使用できるのは半角数字のみです。',
      'tel_mobile.max' => '携帯電話は11桁までで入力してください。',
      'zip.required' => '郵便番号を入力してください。',
      'zip.regex' => '郵便番号に使用できるのは半角数字のみです。',
      'address.required' => '住所を入力してください。',
      'zip.max' => '郵便番号は7桁で入力してください。',
      'product_name.required' => '商品名を入力してください。',
      'product_name.max' => '商品名に使用できる文字数は50文字までです。',
      'product_maker.required' => 'メーカー名を入力してください。',
      'product_maker.max' => 'メーカー名に使用できる文字数は20文字までです。',
      'product_number.required' => '型番名を入力してください。',
      'product_number.max' => '型番名に使用できる文字数は20文字までです。',
      'serial_number.max' => 'シリアルナンバーに使用できる文字数は20文字までです。',
      'date_purchase.required' => '購入日を入力してください。',
      'date_start.required' => 'メーカー保証開始日を入力してください。',
    ];
    $this->validate($request, $rule, $message);

    $data = [
      'charge'=>$charge,
      'login_id'=>$input['input']['login_id'],
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
      $id = $input['input']['initial'].date('Y').date('m').sprintf('%03d', $ymcount);;
   
      DB::table($schema.'.warranties')->insert([
        'id'=>$id,
        'name'=>session()->get('name'),
        'kana'=>session()->get('kana'),
        'charge_id'=>session()->get('charge'),
        'tel_fix'=>session()->get('tel_fix'),
        'tel_mobile'=>session()->get('tel_mobile'),
        'zip'=>session()->get('zip'),
        'address'=>session()->get('address'),
        'product_name'=>session()->get('product_name'),
        'product_maker'=>session()->get('product_maker'),
        'product_number'=>mb_convert_kana(session()->get('product_number'), 'as'),
        'serial_number'=>mb_convert_kana(session()->get('serial_number'), 'as'),
        'date_purchase'=>session()->get('date_purchase'),
        'date_start'=>session()->get('date_start'),
        'date_end'=>session()->get('date_end'),
        'remark'=>session()->get('remark'),
        'created_at'=>now(),
        'updated_at'=>now(),
      ]);


      $array = ['name', 'kana', 'cahrge', 'tel_fix', 'tel_mobile', 'zip', 'address', 'product_name', 'product_maker', 'product_number', 'serial_number', 'date_purchase', 'date_start', 'date_end', 'remark'];
      foreach($array as $key => $val){
        $request->session()->forget($val);
      };
      //二重投稿防止
      $request->session()->regenerateToken();
    }

    return redirect(route('document.index', ['login_id' =>$input['input']['login_id']]).'?id='.$id);
  }
}
