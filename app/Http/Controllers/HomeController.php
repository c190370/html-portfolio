<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Library\GetClass;

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

    //検索フォーム
    $keyword = (empty($input['keyword'])) ? NULL : $input['keyword'];
    $date_start_s = (empty($input['date_start_s'])) ? NULL : $input['date_start_s'];
    $date_end_s = (empty($input['date_end_s'])) ? NULL : $input['date_end_s'];
    $date_start_p = (empty($input['date_start_p'])) ? NULL : $input['date_start_p'];
    $date_end_p = (empty($input['date_end_p'])) ? NULL : $input['date_end_p'];
    if(empty($keyword) && empty($date_start_s) && empty($date_end_s) && empty($date_start_p) && empty($date_end_p)){
      list($warranty, $count) = GetClass::GetNormalWarranty($schema);
      $set = '';
    }else{
      $set = str_replace('　', ' ', $keyword);  //全角スペースを半角に変換
      $set = preg_replace('/\s(?=\s)/', '', $set); //連続する半角スペースは削除
      $set = trim($set); //文字列の先頭と末尾にあるホワイトスペースを削除
      $set = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $set); //円マーク、パーセント、アンダーバーはエスケープ処理
      list($warranty, $count) = GetClass::GetSearchedWarranty($schema, $set, $date_start_s, $date_end_s, $date_start_p, $date_end_p);
    }

    for($i=0; $i<$count; $i++){
      $warranty[$i]->judgment = GetClass::GetWarrantyJudgment($warranty[$i]->date_end);
    }

    $data = [
      'login_id'=>$login_id,
      'warranty'=>$warranty,
      'set'=>$set,
      'date_start_s'=>$date_start_s,
      'date_end_s'=>$date_end_s,
      'date_start_p'=>$date_start_p,
      'date_end_p'=>$date_end_p,
    ];

    return view('index', ['data'=>$data, 'input'=>$input]);
  }
}
