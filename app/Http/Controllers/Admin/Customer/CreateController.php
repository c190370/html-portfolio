<?php

namespace App\Http\Controllers\Admin\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    $array = CreateClass::GetSessionCustomer();
    foreach($array as $key => $val){
      $request->session()->pull($key);
    };
    $data = [];

    return view('admin.customer.create.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function confirm(Request $request)
  {
    $input = $request->all();
    foreach($input as $key => $val){
      if($key != "_token"){$request->session()->flash($key, $val);}
    };
    // echo '<pre>';
    // var_dump($input);exit;
    // echo '</pre>';
    //バリデーションルールの作成
    $rule = [
      'name' => ['required', 'string', 'max:50',],
      'login_id' => ['required', 'unique:customers', 'unique:users','string', 'regex:/^[a-z0-9\_]+$/', 'max:20',],
      'initial' => ['required', 'unique:customers', 'string', 'regex:/^[A-Z]+$/', 'max:3',],
      'email' => ['nullable', 'string', 'email:rfc', 'regex:/^[a-zA-Z0-9\@._-]+$/', 'max:255'],
      'tel' => ['nullable', 'regex:/^[0-9\-]+$/', 'max:15',],
      'zip' => ['nullable', 'regex:/^[0-9]+$/','max:7',],
      'address' => ['max:255'],
      'payee' => ['required',],
      'claimant_name' => ['required', 'string', 'max:20',],
      'claimant_address' => ['required', 'string', 'max:50',],
      'claimant_tel' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-]+$/', 'max:15',],
      'claimant_fax' => ['string', 'regex:/^[a-zA-Z0-9\-]+$/', 'max:15',],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];
    $message = [
      'login_id.unique' => 'このIDはすでに登録されています。',
      'login_id.regex' => '会社IDに使用できるのは半角英字(小文字)のみです。',
      'initial.unique' => 'このイニシャルはすでに登録されています。',
      'initial.string' => '使用できない文字が含まれています。',
      'initial.regex' => '会社イニシャルに使用できるのは半角英字(大文字)のみです。',
      'email.email' => 'メールアドレス形式で入力してください。',
      'email.regex' => 'メールアドレスに使用できるのは半角英数字、ハイフン(-)、アンダーバー(_)のみです。',
      'email.max' => 'メールアドレスに使用できる文字数は255文字までです。',
      'zip.regex' => '郵便番号に使用できるのは半角数字のみです。',
      'zip.max' => '郵便番号は7桁で入力してください。',
      'tel.regex' => '電話番号に使用できるのは半角数字のみです。',
      'tel.max' => '電話番号は15桁までで入力してください。',
      'claimant_tel.regex' => '電話番号(請求元)に使用できるのは半角英数字、ハイフン(-)のみです。',
      'claimant_fax.regex' => 'FAX(請求元)に使用できるのは半角英数字、ハイフン(-)のみです。',
      'password.string' => '使用できない文字が含まれています。',
      'password.min' => 'パスワードは8文字以上で入力してください。',
      'password.confirmed' => '確認用のパスワードと一致しません。',
    ];
    $this->validate($request, $rule, $message);

    $data = [];

    return view('admin.customer.create.confirm', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();

    $request->session()->reflash();
    $action = $request->input('action');
    if($action == 'back'){
      return redirect(route('admin.customer.create.index'))->withInput($input);
    }elseif($action == 'regist'){
      $id = DB::table('users')->insertGetId([
        'login_id'=>session()->get('login_id'),
        'password' => Hash::make(session()->get('password')),
        'role' => 'customer',
        'created_at'=>now(),
        'updated_at'=>now(),
      ]);
    
      DB::table('customers')->insert([
        'user_id'=>$id,
        'login_id'=>session()->get('login_id'),
        'initial'=>session()->get('initial'),
        'name'=>session()->get('name'),
        'email'=>session()->get('email'),
        'tel'=>session()->get('tel'),
        'zip'=>session()->get('zip'),
        'address'=>session()->get('address'),
        'remark'=>session()->get('remark'),
        'payee'=>session()->get('payee'),
        'claimant_name'=>session()->get('claimant_name'),
        'claimant_address'=>session()->get('claimant_address'),
        'claimant_tel'=>session()->get('claimant_tel'),
        'claimant_fax'=>session()->get('claimant_fax'),
        'created_at'=>now(),
        'updated_at'=>now(),
      ]);

      $array = CreateClass::GetSessionCustomer();
      foreach($array as $key => $val){
        $request->session()->forget($val);
      };;

    $session = '登録が完了しました。';

    //二重投稿防止
    $request->session()->regenerateToken();
  };
    return redirect(route('admin.index'))->with('session', $session);
  }
}
