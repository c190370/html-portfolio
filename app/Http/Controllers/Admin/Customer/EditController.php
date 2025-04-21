<?php

namespace App\Http\Controllers\Admin\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EditController extends Controller
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

    return view('admin.customer.edit.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();

    //バリデーションルールの作成
    $rule = [
      'name' => ['required', 'string', 'max:50',],
      'payee' => ['required',],
      'claimant_name' => ['required', 'string', 'max:20',],
      'claimant_address' => ['required', 'string', 'max:50',],
      'claimant_tel' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-]+$/', 'max:15',],
      'claimant_fax' => ['string', 'regex:/^[a-zA-Z0-9\-]+$/', 'max:15', 'nullable'],
      'email' => ['nullable', 'string', 'email:rfc', 'regex:/^[a-zA-Z0-9\@._-]+$/', 'max:255'],
      'tel' => ['nullable', 'regex:/^[0-9\-]+$/', 'max:15',],
      'zip' => ['nullable', 'regex:/^[0-9]+$/','max:7',],
      'address' => ['max:255'],
    ];
    $message = [
      'email.email' => 'メールアドレス形式で入力してください。',
      'email.regex' => 'メールアドレスに使用できるのは半角英数字、ハイフン(-)、アンダーバー(_)のみです。',
      'email.max' => 'メールアドレスに使用できる文字数は255文字までです。',
      'zip.regex' => '郵便番号に使用できるのは半角数字のみです。',
      'zip.max' => '郵便番号は7桁で入力してください。',
      'tel.regex' => '電話番号に使用できるのは半角数字のみです。',
      'tel.max' => '電話番号は15桁までで入力してください。',
      'claimant_tel.regex' => '電話番号(請求元)に使用できるのは半角英数字、ハイフン(-)のみです。',
      'claimant_fax.regex' => 'FAX(請求元)に使用できるのは半角英数字、ハイフン(-)のみです。',
    ];
    $this->validate($request, $rule, $message);

    DB::table('customers')
    ->where('login_id', '=', $input['id'])
    ->update([
      'name'=>$input['name'],
      'email'=>$input['email'],
      'tel'=>$input['tel'],
      'zip'=>$input['zip'],
      'address'=>$input['address'],
      'remark'=>$input['remark'],
      'payee'=>$input['payee'],
      'claimant_name'=>$input['claimant_name'],
      'claimant_address'=>$input['claimant_address'],
      'claimant_tel'=>$input['claimant_tel'],
      'claimant_fax'=>$input['claimant_fax'],
    ]);
    //二重投稿防止
    $request->session()->regenerateToken();

    $session = "変更を保存しました。";

    return redirect(route('admin.customer.detail.index').'?id='.$input['id'])->with('session', $session);
  }

}
