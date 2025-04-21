<?php

namespace App\Http\Controllers\Admin\Warranty;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Library\HomeClass;

class HomeController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index(Request $request)
  {
    $input = $request->all();
    $schema = 'servantop_ini_'.$input['user'];
    //検索フォーム
    $keyword = (empty($input['keyword'])) ? NULL : $input['keyword'];
    $date_start = (empty($input['date_start'])) ? NULL : $input['date_start'];
    $date_end = (empty($input['date_end'])) ? NULL : $input['date_end'];
    if(empty($keyword) && empty($date_start) && empty($date_end)){
      $warranty = DB::table($schema.'.warranties')->orderBy('created_at', 'desc')->paginate(50);
      $set = "";
    }else{
      $set = str_replace('　', ' ', $keyword);  //全角スペースを半角に変換
      $set = preg_replace('/\s(?=\s)/', '', $set); //連続する半角スペースは削除
      $set = trim($set); //文字列の先頭と末尾にあるホワイトスペースを削除
      $set = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $set); //円マーク、パーセント、アンダーバーはエスケープ処理
      $words = array_unique(explode(' ', $set)); //キーワードを半角スペースで配列に
      $query = DB::table($schema.'.warranties');
      foreach($words as $word){
        $query->orwhere(function($_query) use($word){
          $_query->where('id', 'LIKE', '%'.$word.'%')
                 ->orwhere('name', 'LIKE', '%'.$word.'%')
                 ->orwhere('address', 'LIKE', '%'.$word.'%');
        });
      }
      $query->when(isset($date_start), function($_query) use ($date_start){
        return $_query->where('date_start', '>=', $date_start);
      });
      $query->when(isset($date_end), function($_query) use ($date_end){
        return $_query->where('date_start', '<=', $date_end);
      });
      $warranty = $query->orderBy('created_at','desc')->paginate(50);
    }
    // echo '<pre>';
    // var_dump($date_start);exit;
    // echo '</pre>';
    for($i=0; $i<count($warranty); $i++){
      $warranty[$i]->judgment = HomeClass::GetWarrantyJudgment($warranty[$i]->date_end);
    }

    $data = [
      'user'=>$input['user'],
      'warranty'=>$warranty,
      'set'=>$set,
      'date_start'=>$date_start,
      'date_end'=>$date_end,
    ];

    return view('admin.warranty.index', ['data'=>$data, 'input'=>$input]);
  }
}
