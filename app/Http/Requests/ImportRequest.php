<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ImportRequest extends FormRequest
{
  public function validateUploadFile(Request $request)
  {
    // echo '<pre>';
    // var_dump($request);exit;
    // echo '</pre>';
    return \Validator::make($request->all(), [
        'csv_file' => 'required|file|mimetypes:text/plain|mimes:csv,txt',
      ], [
        'csv_file.required'  => 'ファイルを選択してください。',
        'csv_file.file'      => 'ファイルアップロードに失敗しました。',
        'csv_file.mimetypes' => 'ファイル形式が不正です。',
        'csv_file.mimes'     => 'ファイル拡張子が異なります。',
      ]
    );
  }

}
