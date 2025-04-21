@extends('template.header')
@section('title','保証書新規登録(確認)')
@section('body')
<div class="content">
  <form method="POST" action="{{route('create.send', ['login_id' =>$data['login_id']])}}" class="h-adr">
    @csrf
    <div class="form form-width-lg">
      <div class="nav"><div class="nav-title">登録内容確認</div></div>
      <div class="form-header">顧客情報</div>
      <div class="form-box box-size-lg box-color-bl">
        <div class="form-row form-size-md">
          <div class="formRow-label"><div class="formRowLavel-title">顧客名</div></div>
          <div class="formRow-value">{{Session::get('name')}}</div>
        </div>
        <div class="form-row form-size-md">
          <div class="formRow-label"><div class="formRowLavel-title">顧客名フリガナ</div></div>
          <div class="formRow-value">{{Session::get('kana')}}</div>
        </div>
        <div class="form-row form-size-tel">
          <div class="formRow-label"><div class="formRowLavel-title">電話番号</div></div>
          <div class="formRow-value">
            <div class="form-caption">固定電話：</div>
            <div class="form-size-sm">{{Session::get('tel_fix')}}</div>
            <div class="form-caption caption-right">携帯電話：</div>
            <div class="form-size-sm">{{Session::get('tel_mobile')}}</div>
          </div>
        </div>
        <div class="form-line"></div>
        <div class="form-row form-size-max">
          <div class="formRow-label"><div class="formRowLavel-title">住所</div></div>
          <div class="formRow-value">
            <div class="form-caption">郵便番号：</div>
            <div class="form-size-sm">{{Session::get('zip')}}</div>
            <div class="form-caption caption-right">住所：</div>
            <div class="form-size-lg">{{Session::get('address')}}</div>
          </div>
        </div>
      </div>
      <div class="form-header">商品情報</div>
      <div class="form-box box-size-lg box-color-gr">
        <table class="table table-sm">
          <thead><tr><th width="150"></th><th>商品名</th><th>メーカー名</th><th>型番</th></tr></thead>
          <tbody>
            <tr>
              <td><div class="formRow-label"><div class="formRowLavel-title">商品</div></td>
              <td><div class="formRow-value">{{Session::get('product_name')}}</div></td>
              <td><div class="formRow-value">{{Session::get('product_maker')}}</div></td>
              <td><div class="formRow-value">{{Session::get('product_number')}}</div></td>
            </tr>
            @for($i=1;$i<=5;$i++)
            <tr>
              <td><div class="formRow-label"><div class="formRowLavel-title">オプション{{$i}}</div></div></td>
              <td><div class="formRow-value">{{Session::get('option'.$i.'_name')}}</div></td>
              <td><div class="formRow-value">{{Session::get('option'.$i.'_maker')}}</div></td>
              <td><div class="formRow-value">{{Session::get('option'.$i.'_number')}}</div></td>
            </tr>
            @endfor
          </tbody>
        </table>
        <div class="form-line"></div>
        <div class="form-row form-size-md">
          <div class="formRow-label"><div class="formRowLavel-title">購入日</div></div>
          <div class="formRow-value">{{date('Y/m/d',strtotime(Session::get('date_purchase')))}}</div>
        </div>
        <div class="form-row form-size-md">
          <div class="formRow-label"><div class="formRowLavel-title">メーカー保証開始日</div></div>
          <div class="formRow-value">{{date('Y/m/d',strtotime(Session::get('date_start')))}}</div>
        </div>
        <div class="form-row form-size-md">
          <div class="formRow-label"><div class="formRowLavel-title">延長保証終了日</div></div>
          <div class="formRow-value">
            <div class="formRow-value">@if(Session::get('date_end')){{date('Y/m/d',strtotime(Session::get('date_end')))}}@endif</div>
          </div>
        </div>
      </div>
      <div class="form-header">その他</div>
      <div class="form-box box-color-yr">
        <div class="form-row form-size-max">
          <div class="formRow-label"><div class="formRowLavel-title">備考</div></div>
          <div class="formRow-value @if(!Session::get('remark'))value-height @endif">{!!nl2br(e(Session::get('remark')))!!}</div>
        </div>
      </div>
    </div>
    <div class="form-submit">
      <button name="action" type="submit" value="back" class="submit-button button-color-bk">やり直す</button>
      <button name="action" type="submit" value="regist" class="submit-button button-color-bl">登録する</button>
    </div>
  </form>
</div>
@endsection
