<?php

namespace App\Http\Controllers\Admin\Warranty;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;


class DocumentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('validate_warrenty');
  }

  public function pdf(Request $request)
  {
    $input = $request->all();

    $customer = DB::table('customers')->where('login_id', '=', $input['user'])->get();
    $schema = 'servantop_ini_'.$input['user'];
    $warranty = DB::table($schema.'.warranties')->where('id', '=', $input['id'])->get();

    $data = [
      'customer'=>$customer,
      'warranty'=>$warranty,
    ];

    $pdf = PDF::loadView('document.pdf', compact('data'));
    $pdf->getDomPDF()->set_option('enable_font_subsetting', true);
    return $pdf->stream('document.pdf');

    return view('document.pdf', ['data'=>$data, 'input'=>$input,]);
  }
}
