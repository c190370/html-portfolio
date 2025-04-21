<?php

namespace app\Library;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceClass
{

  public static function GetYM($schema)
  {
    $select_ym = DB::SELECT("
      SELECT
      DATE_FORMAT(date_purchase, '%Y%m') as ym
      FROM " .$schema. ".warranties
      GROUP BY DATE_FORMAT(date_purchase, '%Y%m')
      ORDER BY DATE_FORMAT(date_purchase, '%Y%m') DESC;
    ");

    return $select_ym;
  }

  public static function GetLastDay($yyyymm)
  {
    $year = ltrim(substr($yyyymm, 0, 4), 0);
    $month = ltrim(substr($yyyymm, 4, 2), 0);

    $next = date('Y-m', strtotime(date($year . '-'. $month . '-01').'+1 month'));
    $last_day = date('Y年m月d日', strtotime('last day of' . $next));
    
    return $last_day;
  }

  public static function GetYMAX($schema)
  {
    $max = DB::SELECT("
      SELECT
      DATE_FORMAT(date_purchase, '%Y%m') as ym
      FROM " .$schema. ".warranties
      GROUP BY DATE_FORMAT(date_purchase, '%Y%m')
      ORDER BY DATE_FORMAT(date_purchase, '%Y%m') DESC
      LIMIT 1
    ");

    foreach($max as $val){
      $max_ym = $val->ym;
    }

    return $max_ym;
  }

  public static function GetProductCount($schema, $yyyymm)
  {
    $product = DB::SELECT("
      SELECT
      product_names.id,
      warranties.product_name,
      count(*) as count
      FROM " .$schema. ".warranties as warranties
      JOIN " .$schema. ".product_names ON warranties.product_name = product_names.name
      WHERE DATE_FORMAT(date_purchase, '%Y%m') = ".$yyyymm."
      GROUP BY product_names.id,warranties.product_name
      ORDER BY product_names.id
    ");

    return $product;
  }

  public static function GetProductPrice($schema, $product_name)
  {
    $val = DB::table($schema.'.product_names')
      ->where('name', '=', $product_name)
      ->first('price');

    $price = $val->price;

    return $price;
  }

}