<?php

namespace app\Library;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateClass
{
  public static function GetProductMaker($schema, $id)
  {
    $val = DB::table($schema.'.product_makers')->where('id', '=', $id)->first('name');
    $product_maker = ($val) ? $val->name : '';

    return $product_maker;
  }

  public static function GetProductName($schema, $id)
  {
    $val = DB::table($schema.'.product_names')->where('id', '=', $id)->first('name');
    $product_name = ($val) ? $val->name : '';

    return $product_name;
  }

  public static function GetYMCount($schema)
  {
    $yyyymm = date('Y').date('m');
    $exist = DB::table($schema.'.counts')->where('yyyymm', '=', $yyyymm)->exists();

    if($exist){
      $count = DB::table($schema.'.counts')->where('yyyymm', '=', $yyyymm)->first('count');
      $count_plus = $count->count + 1;
      DB::table($schema.'.counts')
        ->where('yyyymm', '=', $yyyymm)
        ->update([
          'count'=>$count_plus,
        ]);
        $ymcount = $count_plus;
    }else{
      DB::table($schema.'.counts')->insert([
        'yyyymm'=>$yyyymm,
        'count'=>1,
      ]);
      $ymcount = 1;
    }

    return $ymcount;
  }

  public static function GetSessionCustomer()
  {
    $array = [
      'name',
      'login_id',
      'initial',
      'email',
      'zip',
      'address',
      'tel',
      'remark',
      'payee',
      'claimant_name',
      'claimant_address',
      'claimant_tel',
      'claimant_fax',
      'password'];

    return $array;
  }

  public static function GetSessionWarranty()
  {
    $array=[
      'name',
      'kana',
      'tel_fix',
      'tel_mobile',
      'zip',
      'address',
      'product_name',
      'product_maker',
      'product_number',
      'option1_name',
      'option1_maker',
      'option1_number',
      'option2_name',
      'option2_maker',
      'option2_number',
      'option3_name',
      'option3_maker',
      'option3_number',
      'option4_name',
      'option4_maker',
      'option4_number',
      'option5_name',
      'option5_maker',
      'option5_number',
      'date_purchase',
      'date_start',
      'date_end',
      'remark',
    ];

    return $array;
  }
}