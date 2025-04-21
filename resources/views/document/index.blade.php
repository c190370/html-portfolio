@extends('template.header')
@section('title','保証書作成完了')
@section('body')
  <div class="list">
    <div class="list-message">
      登録が完了しました。
    </div>
    <div class="list-submit">
      <a href="{{route('document.pdf', ['login_id' =>$data['login_id']])}}?id={{$data['id']}}" class="submit-button button-color-pk" target="_blank"><i class="far fa-file-pdf"></i>&nbsp;PDFを表示</a>
    </div>
    <div class="list-submit">
      <a href="{{route('create.index', ['login_id' =>$data['login_id']])}}" class="submit-button button-color-bl"><i class="fas fa-file"></i>&nbsp;続けて登録(新規)</a>
    </div>
    <div class="list-submit">
      <a href="{{route('copy.index', ['login_id' =>$data['login_id']])}}?id={{$data['id']}}" class="submit-button button-color-bl"><i class="fas fa-copy"></i>&nbsp;続けて登録(複製)</a>
    </div>
    <div class="list-submit">
      <a href="{{route('index', ['login_id' =>$data['login_id']])}}" class="submit-button button-color-bk"><i class="fas fa-reply"></i>&nbsp;TOPに戻る</a>
    </div>
  </div>
@endsection
