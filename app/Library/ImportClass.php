<?php

namespace App\Library;

use Illuminate\Support\Facades\DB;

class ImportClass
{

  public static function GetColumnsValue(string $header ,string $encoding)
  {
    // CSVヘッダとテーブルのカラムを関連付けておく
    $list = [
      'name' => "顧客名",
      'kana' => "顧客名フリガナ",
      'tel_fix' => "固定電話",
      'tel_mobile' => "携帯電話",
      'zip' => "郵便番号",
      'address' => "住所",
      'product_name' => "商品名",
      'product_maker' => "メーカー名",
      'product_number' => "型番",
      'option1_name' => "オプション1",
      'option1_maker' => "メーカー名1",
      'option1_number' => "型番1",
      'option2_name' => "オプション2",
      'option2_maker' => "メーカー名2",
      'option2_number' => "型番2",
      'option3_name' => "オプション3",
      'option3_maker' => "メーカー名3",
      'option3_number' => "型番3",
      'option4_name' => "オプション4",
      'option4_maker' => "メーカー名4",
      'option4_number' => "型番4",
      'option5_name' => "オプション5",
      'option5_maker' => "メーカー名5",
      'option5_number' => "型番5",
      'date_purchase' => "購入日",
      'date_start' => "保証開始日",
      'date_end' => "保証終了日",
      'remark' => "備考",
    ];

    foreach ($list as $key => $value) {
      if ($header === mb_convert_encoding($value, $encoding)) {
        return $key;
      }
    }
  }

  public static function CheckProductMaker($schema, $product_maker)
  {
    $val = DB::table($schema.'.product_makers')
    ->where('name', '=', $product_maker)
    ->exists();

    $check = ($val) ? '1' : '0';

    return $check;
  }

  public static function CheckProductName($schema, $product_name)
  {
    $val = DB::table($schema.'.product_names')
    ->where('name', '=', $product_name)
    ->exists();

    $check = ($val) ? '1' : '0';

    return $check;
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

  public static function CheckExtention($schema, $extention)
  {
    $array = array('csv', 'txt');
    $check = in_array($extention, $array);

    $check_ext = ($check) ? '1' : '0';

    return $check_ext;
  }
}