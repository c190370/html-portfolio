<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\GetClass;

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
    $schema = $input['input']['schema'];
    $login_id = $input['input']['login_id'];

    $warranty = GetClass::GetWarrantyDetail($schema, $id);

    // echo '<pre>';
    // var_dump($warranty);exit;
    // echo '</pre>';

    $data = [
      'login_id'=>$login_id,
      'warranty'=>$warranty,
    ];

    return view('detail.index', ['data'=>$data, 'input'=>$input,]);
  }
}
