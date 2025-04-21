<?php

namespace app\Library;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GetClass
{
  public static function GetChargeName($id)
  {
    $val = DB::table('m_charge')->where('id', '=', $id)->first('name');
    $charge = ($val) ? $val->name : '';

    return $charge;
  }

  public static function GetNormalWarranty($schema)
  {
    $page_count = 50;
    $warranty = DB::table($schema.'.warranties as warranty')
      ->select(
      'warranty.id',
      'warranty.name as name',
      'warranty.kana',
      'warranty.date_purchase',
      'warranty.date_start',
      'warranty.date_end',
      'warranty.created_at',
      'warranty.updated_at',
      'warranty.product_maker',
      'warranty.product_name',
      'warranty.product_number',
      )
      // ->join($schema.'.product_makers as product_makers', 'warranty.product_maker', '=', 'product_makers.id')
      // ->join($schema.'.product_names as product_names', 'warranty.product_name', '=', 'product_names.id')
      ->orderBy('created_at', 'desc')->paginate(50);

      if($warranty->total() > 0){
        if($warranty->total() <= $page_count){
          $warranty_count = $warranty->total();
        }else{
          $warranty_count = $page_count;
        }
      }

    return array($warranty, $warranty_count);
  }

  public static function GetSearchedWarranty($schema, $set, $date_start_s, $date_end_s, $date_start_p, $date_end_p)
  {


    $page_count = 50;
    $words = array_unique(explode(' ', $set)); //キーワードを半角スペースで配列に
    $query = DB::table($schema.'.warranties as warranty')
      ->select(
      'warranty.id',
      'warranty.name as name',
      'warranty.kana',
      'warranty.address',
      'warranty.date_purchase',
      'warranty.date_start',
      'warranty.date_end',
      'warranty.created_at',
      'warranty.updated_at',
      'warranty.product_maker',
      'warranty.product_name',
      'warranty.product_number',
      );
      // ->join($schema.'.product_makers as product_makers', 'warranty.product_maker', '=', 'product_makers.id')
      // ->join($schema.'.product_names as product_names', 'warranty.product_name', '=', 'product_names.id');

      foreach($words as $word){
      $query->where(function($_query) use($word){
        $_query->where('warranty.id', 'LIKE', '%'.$word.'%')
                ->orWhere('warranty.name', 'LIKE', '%'.$word.'%')
                ->orWhereRaw('warranty.kana COLLATE utf8mb4_unicode_ci LIKE ?', ['%'.$word.'%'])
                ->orWhere('warranty.address', 'LIKE', '%'.$word.'%');
      });
    }
    $query->when(isset($date_start_s), function($_query) use ($date_start_s){
      return $_query->where('date_start', '>=', $date_start_s);
    });
    $query->when(isset($date_end_s), function($_query) use ($date_end_s){
      return $_query->where('date_start', '<=', $date_end_s);
    });
    $query->when(isset($date_start_p), function($_query) use ($date_start_p){
      return $_query->where('date_purchase', '>=', $date_start_p);
    });
    $query->when(isset($date_end_p), function($_query) use ($date_end_p){
      return $_query->where('date_purchase', '<=', $date_end_p);
    });
    
    $params = [
      'keyword'=>$set,
      'date_start_s'=>$date_start_s,
      'date_end_s'=>$date_end_s,
      'date_start_p'=>$date_start_p,
      'date_end_p'=>$date_end_p,
    ];

    
    $warranty = $query->orderBy('created_at','desc')->paginate($page_count)->appends($params);

    $item_count = count($warranty->items());

    if($item_count > 0){
      if($item_count < $page_count){
        $warranty_count = $item_count;
      }else{
        $warranty_count = $page_count;
      }
    }else{
      $warranty_count = 0;
    }

    
    return array($warranty, $warranty_count);
  }

  public static function GetWarrantyDetail($schema, $id)
  {
    $warranty = DB::table($schema.'.warranties as warranty')
      // ->select(
      // 'warranty.id',
      // 'warranty.name',
      // 'warranty.kana',
      // 'warranty.tel_fix',
      // 'warranty.tel_mobile',
      // 'warranty.zip',
      // 'warranty.address',
      // 'warranty.product_maker as product_maker_id',
      // 'warranty.product_name as product_name_id',
      // 'warranty.product_number',
      // 'warranty.option1_name',
      // 'warranty.option1_maker',
      // 'warranty.option1_number',
      // 'warranty.option2_name',
      // 'warranty.option2_maker',
      // 'warranty.option2_number',
      // 'warranty.option3_name',
      // 'warranty.option3_maker',
      // 'warranty.option3_number',
      // 'warranty.option4_name',
      // 'warranty.option4_maker',
      // 'warranty.option4_number',
      // 'warranty.option5_name',
      // 'warranty.option5_maker',
      // 'warranty.option5_number',
      // 'warranty.date_purchase',
      // 'warranty.date_start',
      // 'warranty.date_end',
      // 'warranty.remark',
      // 'product_makers.name as product_maker',
      // 'product_names.name as product_name',
      // 'product_names.maker_id',
      // )
      // ->join($schema.'.product_makers as product_makers', 'warranty.product_maker', '=', 'product_makers.id')
      // ->join($schema.'.product_names as product_names', 'warranty.product_name', '=', 'product_names.id')
      ->where('warranty.id', '=', $id)
      ->orderBy('created_at', 'desc')
      ->get();

    return $warranty;
  }

  public static function GetWarrantyJudgment($date)
  {
    if($date){
      $judgment = strtotime($date) > strtotime(date('Ymd')) ? '1' : '0';
    }else{
      $judgment = 0;
    }

    return $judgment;
  }
}