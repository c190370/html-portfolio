<?php

namespace app\Library;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeClass
{
  public static function GetChargeName($id)
  {
    $val = DB::table('m_charge')->where('id', '=', $id)->first('name');
    $charge = ($val) ? $val->name : '';

    return $charge;
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