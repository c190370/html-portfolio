@extends('template.header')
@section('title','CSVインポート画面')
@section('body')
<div class="content">
  <form method="POST" action="{{route('import.send', ['login_id' =>$data['login_id']])}}" enctype="multipart/form-data" id="csvUpload">
    @csrf
    <div class="form form form-width-sm">
      <div class="form-header">CSVインポート</div>
        <div class="form-box box-size-lg box-color-bl">
          <div class="form-file">

            <div class="formFile-upload">
              <div><input type="file" value="ファイルを選択" name="csv_file"></div>
              <button name="action" type="submit" value="import" class="submit-button button-color-bl"><i class="fas fa-file-upload"></i>&nbsp;インポート</button>
            </div>
            @if(Session::has('message'))
              <div class="formFile-error">{{session('message')}}</div>
            @endif
            @if(is_array($errors))
                @if(count($errors['errors_list']) > 0)
                <div class="formFile-error">
                    <ul>
                      @foreach ($errors['errors_list'] as $line => $columns)
                        @foreach ($columns as $error)
                          <li>{{$line}}行目：{{$error}}</li>
                        @endforeach
                      @endforeach
                    </ul>
                </div>
              @endif
            @endif
          </div>
        </div>
      </div>
      <div class="form-header">アップロードについて</div>
        <div class="form-box box-size-lg box-color-bl">
          <div class="form-file">
            <div class="formFile-message">
              <div class="formFileMessage-download">
                <a href="{{asset('file/import.csv')}}" class="listButton-serach listButton-button button-color-pk"><i class="fas fa-file-download"></i>&nbsp;Download</a>
                <span><i class="far fa-hand-point-left"></i>&nbsp;インポート用のCSVはこちらからダウンロードしてください</span>
              </div>
              <div class="formFileMessage-caution">
                <ul>
                  <li>指定されたCSV以外のファイルはインポートしないで下さい。</li>  
                  <li>CSV内の1行目の項目名の書き換え、削除等は行わないで下さい。</li>
                  <li>商品名、メーカー名は一覧にあるもの以外は記入しないで下さい。</li>
                  <div class="formFileMessageCaution-list">
                    <div class="formFileMessageCautionList-value">
                      <a href="#maker" class="collapsed" data-toggle="collapse"><i class="fa"></i>&nbsp;メーカー一覧</a>
                      <div iD="maker" class="collapse">
                        @foreach($data['maker'] as $maker)
                          <div>{{$maker->name}}</div>
                        @endforeach
                      </div>
                    </div>
                    <div class="formFileMessageCautionList-value">
                      <a href="#product" class="collapsed" data-toggle="collapse"><i class="fa"></i>&nbsp;商品一覧</a>
                      <div iD="product" class="collapse">
                        @foreach($data['product'] as $product)
                          <div>{{$product->name}}</div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                  <li>
                    購入日、保証開始日、保証終了日は 下記に従った形で記入してください。<br/>
                    ※例えば2020年4月23日の場合は 2020/4/12 あるいは 2020-4-12 と記入してください。<br/>
                    ※西暦は4桁で、数字・記号とも全て半角で記入してください。
                  </li>
                  <li>
                    一度に大量のデータをインポートするとエラーを起こす可能性があるため
                    一度のアップロードは100件を目安にして下さい。
                    それ以上ある場合には複数回に分割してインポートしてください。
                  </li>
                  <li>ダブルクォーテーション( " )やシングルクォーテーション( ' )は使用しないで下さい。</li>
                  <li>その他の入力規則は新規追加時と同等のものとします。</li>
                  <li>上記の項目に反する場合、エラーとなりインポートできないことがあります。</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <div class="form-submit">
        <a href="{{route('index', ['login_id' =>$data['login_id']])}}" class="submit-button button-color-bk">戻る</a>
      </div>
  </div>
</form>
</div>
@endsection
