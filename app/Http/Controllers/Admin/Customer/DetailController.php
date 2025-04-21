<?php

namespace App\Http\Controllers\Admin\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
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

    return view('admin.customer.detail.index', ['data'=>$data, 'input'=>$input,]);
  }

}
