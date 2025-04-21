<?php

namespace App\Http\Controllers;

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

  public function index(Request $request)
  {
    $input = $request->all();

    $data = [
      'id'=>$input['id'],
      'login_id'=>$input['input']['login_id'],
    ];

    return view('document.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function pdf(Request $request)
  {
    $input = $request->all();

    $id = $input['id'];
    $customer = DB::table('customers')->where('user_id', '=', Auth::user()->id)->get();
    $schema = $input['input']['schema'];
    $warranty = DB::table($schema.'.warranties')->where('id', '=', $id)->get();
    // echo '<pre>';
    // var_dump($warranty);exit;
    // echo '</pre>';
    
    $data = [
      'customer'=>$customer,
      'warranty'=>$warranty,
      'login_id'=>$input['input']['login_id'],
    ];

    $pdf = PDF::loadView('document.pdf', compact('data'));
    $pdf->getDomPDF()->set_option('enable_font_subsetting', true);
    return $pdf->stream('document.pdf');

    return view('document.pdf', ['data'=>$data, 'input'=>$input,]);
  }

  public function print(Request $request)
  {
    $input = $request->all();

    $id = $input['id'];
    $customer = DB::table('customers')->where('user_id', '=', Auth::user()->id)->get();
    $schema = $input['input']['schema'];
    $warranty = DB::table($schema.'.warranties')->where('id', '=', $id)->get();
    // echo '<pre>';
    // var_dump($warranty);exit;
    // echo '</pre>';
    
    $data = [
      'customer'=>$customer,
      'warranty'=>$warranty,
      'login_id'=>$input['input']['login_id'],
    ];

    return view('document.print', ['data'=>$data, 'input'=>$input,]);
  }
}
