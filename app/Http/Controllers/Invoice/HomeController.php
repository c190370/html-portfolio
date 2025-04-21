<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Library\InvoiceClass;

class HomeController extends Controller
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
    $name = $input['input']['name'];
    $customer = DB::table('customers')->where('login_id', '=', $login_id)->get();
    $select_ym = InvoiceClass::GetYM($schema);
    $max_ym = InvoiceClass::GetYMAX($schema);
    $yyyymm = (empty($input['ym'])) ? $max_ym : $input['ym'];
    $month = ltrim(substr($yyyymm, 4, 2), 0);
    $last_day = InvoiceClass::GetLastDay($yyyymm);

    $product = InvoiceClass::GetProductCount($schema, $yyyymm);
    $subtotal = 0;
    for($i=0;$i<10;$i++){
      if(!empty($product[$i])){
      $price = InvoiceClass::GetProductPrice($schema, $product[$i]->product_name);
      $mutil = $price * $product[$i]->count;
      $product[$i]->price = $price;
      $product[$i]->mutil = $mutil;
      $subtotal = $subtotal + $mutil;
      }else{
        $product[$i] = (object)[
          'product_name' => NULL,
          'count' => NULL,
          'price' => NULL,
          'mutil' => NULL,
        ];
      
      }
    }
    $tax = $subtotal / 10;
    $total = $subtotal + $tax;
    // echo '<pre>';
    // var_dump($payee);exit;
    // echo '</pre>';

    $data = [
      'login_id'=>$login_id,
      'select_ym'=>$select_ym,
      'yyyymm'=>$yyyymm,
      'month'=>$month,
      'last_day'=>$last_day,
      'name'=>$name,
      'customer'=>$customer,
      'product'=>$product,
      'tax'=>$tax,
      'subtotal'=>$subtotal,
      'total'=>$total,
    ];

    return view('invoice.index', ['data'=>$data, 'input'=>$input,]);
  }
}
