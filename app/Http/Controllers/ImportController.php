<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Rules\MakerRule;
use App\Rules\NameRule;
use App\Rules\ExtentionRule;

use App\Library\ImportClass;

class ImportController extends Controller
{
  public function index(Request $request)
  {
    $input = $request->all();
    $login_id = $input['input']['login_id'];
    $schema = $input['input']['schema'];
    $maker = DB::table($schema.'.product_makers')->get();
    $product = DB::table($schema.'.product_names')->get();

    $data = [
      'login_id'=>$login_id,
      'maker'=>$maker,
      'product'=>$product,
    ];

    return view('import.index', ['data'=>$data, 'input'=>$input,]);
  }

  public function send(Request $request)
  {
    $input = $request->all();
    $schema = $input['input']['schema'];
    // アップロードファイルに対してのバリデート
    $validator = $this->validateUploadFile($request);

    if($validator->fails() === true){
      return redirect(route('import.index', ['login_id' =>$input['input']['login_id']]))->with('message', $validator->errors()->first('csv_file'));
    }
    // CSVファイルをサーバーに保存
    $temporary_csv_file = $request->file('csv_file')->store('csv');

    $fp = fopen(storage_path('app/') . $temporary_csv_file, 'r');
    $headers = fgetcsv($fp); // 一行目（ヘッダ）読み込み
    $column_names = [];

    // CSVヘッダ確認
    if(count($headers) == 28){
      foreach ($headers as $header) {
        $result = ImportClass::GetColumnsValue($header, 'SJIS-win');

        if($result === null){
          fclose($fp);
          Storage::delete($temporary_csv_file);
          return redirect(route('import.index', ['login_id' =>$input['input']['login_id']]))
              ->with('message', 'CSVファイルのフォーマットが正しいことを確認してださい。');
        }
        $column_names[] = $result;
      }
    }else{
      return redirect(route('import.index', ['login_id' =>$input['input']['login_id']]))
              ->with('message', 'CSVファイルのフォーマットが正しいことを確認してださい。');
    }

    $errors_list = [];
    $i = 0;

    // TODO:サイズが大きいCSVファイルを読み込む場合、この処理ではメモリ不足になる可能性がある為改修が必要になる
    while ($row = fgetcsv($fp)) {
      // SJIS-win→UTF-8へエンコード
      mb_convert_variables('UTF-8', 'SJIS-win', $row);

      foreach ($column_names as $column_no => $column_name){
        $csv_list[$i][$column_name] = $row[$column_no] === '' ? null : $row[$column_no];
      }
      $check_maker = ImportClass::CheckProductMaker($schema, $csv_list[$i]['product_maker']);
      $check_name = ImportClass::CheckProductName($schema, $csv_list[$i]['product_name']);
      // バリデーションチェック
      $validator = \Validator::make(
          $csv_list[$i],
          $this->defineValidationRules($check_maker, $check_name),
          $this->defineValidationMessages($i)
      );
      if($validator->fails() === true){
        $errors_list[$i + 2] = $validator->errors()->all();
      }
      $i++;
    }
    // バリデーションエラーチェック
    if(count($errors_list) > 0){
      return redirect(route('import.index', ['login_id' =>$input['input']['login_id']]))
        ->with('errors', ['errors_list' => $errors_list,]);
    }
    // 登録処理
    if(isset($csv_list) === true){
      foreach($csv_list as $csv){
        $ymcount = ImportClass::GetYMCount($schema);
        $id = $input['input']['initial'].date('Y').date('m').sprintf('%04d', $ymcount);
        $tel_fix = substr($csv['tel_fix'], 0, 1) == '0' ? $csv['tel_fix'] : '0'.$csv['tel_fix'];
        $tel_mobile = substr($csv['tel_mobile'], 0, 1) == '0' ? $csv['tel_mobile'] : '0'.$csv['tel_mobile'];

        DB::table($schema.'.warranties')->insert([
          'id'=>$id,
          'name'=>$csv['name'],
          'kana'=>$csv['kana'],
          'tel_fix'=>$tel_fix,
          'tel_mobile'=>$tel_mobile,
          'zip'=>$csv['zip'],
          'address'=>$csv['address'],
          'product_name'=>$csv['product_name'],
          'product_maker'=>$csv['product_maker'],
          'product_number'=>mb_convert_kana($csv['product_number'], 'as'),
          'option1_name'=>$csv['option1_name'],
          'option1_maker'=>$csv['option1_maker'],
          'option1_number'=>mb_convert_kana($csv['option1_number'], 'as'),
          'option2_name'=>$csv['option2_name'],
          'option2_maker'=>$csv['option2_maker'],
          'option2_number'=>mb_convert_kana($csv['option2_number'], 'as'),
          'option3_name'=>$csv['option3_name'],
          'option3_maker'=>$csv['option3_maker'],
          'option3_number'=>mb_convert_kana($csv['option3_number'], 'as'),
          'option4_name'=>$csv['option4_name'],
          'option4_maker'=>$csv['option4_maker'],
          'option4_number'=>mb_convert_kana($csv['option4_number'], 'as'),
          'option5_name'=>$csv['option5_name'],
          'option5_maker'=>$csv['option5_maker'],
          'option5_number'=>mb_convert_kana($csv['option5_number'], 'as'),
          'date_purchase'=>$csv['date_purchase'],
          'date_start'=>$csv['date_start'],
          'date_end'=>$csv['date_end'],
          'remark'=>$csv['remark'],
          'created_at'=>now(),
          'updated_at'=>now(),
        ]);
        // if($this->fill($csv)->save() === false){
        //   return redirect(route('import.index', ['login_id' =>$input['input']['login_id']]))->with('message', '新規登録処理に失敗しました。');
        // }
      }
    }

    return redirect(route('import.index', ['login_id' =>$input['input']['login_id']]))->with('session', $i.'件のCSV登録が完了しました。' );
  }

  public function validateUploadFile(Request $request)
  {
    $input = $request->all();
    $schema = $input['input']['schema'];
    $check_ext = '';

    if($request->file('csv_file')){
      $file = $request->file('csv_file');
      $extention = $file->getClientOriginalExtension();
      $check_ext = ImportClass::CheckExtention($schema, $extention);
    }else{
      $check_ext = 1;
    }
    // dd($request->all());
    return \Validator::make($request->all(), [
      'csv_file' => [
        'required',
        'file',
        new ExtentionRule($check_ext),//拡張子
        //　以下2つはWindowsでは不安定なため封印
        // 'mimetypes:text/plain,application/vnd.ms-excel,application/octet-stream',
        // 'mimes:csv,txt',
    ],
      ], [
        'csv_file.required'  => 'ファイルを選択してください。',
        'csv_file.file'      => 'ファイルアップロードに失敗しました。',
        // 'csv_file.mimetypes' => 'ファイル形式が不正です。',
        // 'csv_file.mimes'     => 'ファイル拡張子が異なります。',
      ]
    );
  }

  private function defineValidationRules($check_maker, $check_name)
  {
    return [
      // CSVデータ用バリデーションルール
      'name' => ['required', 'string', 'max:50',],
      'kana' => ['required', 'string', 'max:50',],
      'tel_fix' => ['nullable', 'required_without:tel_mobile', 'regex:/^[0-9\-]+$/', 'max:15',],
      'tel_mobile' => ['nullable', 'regex:/^[0-9\-]+$/', 'max:15',],
      'zip' => ['required', 'regex:/^[0-9]+$/','max:7',],
      'address' => ['required', 'max:100'],
      'product_name' => ['required',  new NameRule($check_name)],
      'product_maker' => ['required',  new MakerRule($check_maker)],
      'product_number' => ['required', 'max:20'],
      'serial_number' => ['nullable','max:20'],
      'date_purchase' => ['required','date'],
      'date_start' => ['required','date'],
      'date_end' => ['date'],
    ];
  }

  private function defineValidationMessages($i)
  {
    // echo '<pre>';
    // var_dump($i);exit;
    // echo '</pre>';
    // $count = $i + 2;
    return [
      // CSVデータ用バリデーションエラーメッセージ
      'tel_fix.regex' => '固定電話に使用できるのは半角数字とハイフンのみです。',
      'tel_fix.max' => '固定電話は15桁までで入力してください。',
      'tel_fix.required_without' => '固定電話か携帯電話のいずれかを入力してください。',
      'tel_mobile.regex' => '携帯電話に使用できるのは半角数字とハイフンのみです。',
      'tel_mobile.max' => '携帯電話は15桁までで入力してください。',
      'zip.regex' => '郵便番号に使用できるのは半角数字のみです。',
      'zip.max' => '郵便番号は7桁で入力してください。',
    ];
  }

}