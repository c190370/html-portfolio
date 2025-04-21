@extends('template.header')
@section('title','保証書削除')
@section('body')
<div class="content">
  <form method="POST" action="{{route('delete.send', ['login_id' =>$data['login_id']])}}" class="h-adr">
    @csrf
    @foreach($data['warranty'] as $warranty)
      <div class="form form-width-lg">
        <div class="nav">
          <div class="nav-title">保証書削除({{$warranty->id}})
            <div class="nav-alert"><i class="fas fa-exclamation-triangle"></i>&nbsp;一度削除した保証書を元に戻すことは出来ません</div>
          </div>
        </div>
        <div class="form-header">顧客情報</div>
        <div class="form-box box-size-lg box-color-bl">
          <div class="form-row form-size-md">
            <div class="formRow-label"><div class="formRowLavel-title">顧客名</div></div>
            <div class="formRow-value">{{$warranty->name}}</div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label"><div class="formRowLavel-title">顧客名フリガナ</div></div>
            <div class="formRow-value">{{$warranty->kana}}</div>
          </div>
          <div class="form-row form-size-tel">
            <div class="formRow-label"><div class="formRowLavel-title">電話番号</div></div>
            <div class="formRow-value">
              <div class="form-caption">固定電話：</div>
              <div class="form-size-sm">{{$warranty->tel_fix}}</div>
              <div class="form-caption caption-right">携帯電話：</div>
              <div class="form-size-sm">{{$warranty->tel_mobile}}</div>
            </div>
          </div>
          <div class="form-line"></div>
          <div class="form-row form-size-max">
            <div class="formRow-label"><div class="formRowLavel-title">住所</div></div>
            <div class="formRow-value">
              <div class="form-caption">郵便番号：</div>
              <div class="form-size-sm">{{$warranty->zip}}</div>
              <div class="form-caption caption-right">住所：</div>
              <div class="form-size-lg">{{$warranty->address}}</div>
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
                <td><div class="formRow-value">{{$warranty->product_name}}</div></td>
                <td><div class="formRow-value">{{$warranty->product_maker}}</div></td>
                <td><div class="formRow-value">{{$warranty->product_number}}</div></td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション1<div></div></td>
                <td><div class="formRow-value">{{$warranty->option1_name}}</div></td>
                <td><div class="formRow-value">{{$warranty->option1_maker}}</div></td>
                <td><div class="formRow-value">{{$warranty->option1_number}}</div></td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション2</div></div></td>
                <td><div class="formRow-value">{{$warranty->option2_name}}</div></td>
                <td><div class="formRow-value">{{$warranty->option2_maker}}</div></td>
                <td><div class="formRow-value">{{$warranty->option2_number}}</div></td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション3</div></div></td>
                <td><div class="formRow-value">{{$warranty->option3_name}}</div></td>
                <td><div class="formRow-value">{{$warranty->option3_maker}}</div></td>
                <td><div class="formRow-value">{{$warranty->option3_number}}</div></td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション4</div></div></td>
                <td><div class="formRow-value">{{$warranty->option4_name}}</div></td>
                <td><div class="formRow-value">{{$warranty->option4_maker}}</div></td>
                <td><div class="formRow-value">{{$warranty->option4_number}}</div></td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション5</div></div></td>
                <td><div class="formRow-value">{{$warranty->option5_name}}</div></td>
                <td><div class="formRow-value">{{$warranty->option5_maker}}</div></td>
                <td><div class="formRow-value">{{$warranty->option5_number}}</div></td>
              </tr>
            </tbody>
          </table>
          <div class="form-line"></div>
          <div class="form-row form-size-md">
            <div class="formRow-label"><div class="formRowLavel-title">購入日</div></div>
            <div class="formRow-value">{{date('Y/m/d',strtotime($warranty->date_purchase))}}</div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label"><div class="formRowLavel-title">メーカー保証開始日</div></div>
            <div class="formRow-value">{{date('Y/m/d',strtotime($warranty->date_start))}}</div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label"><div class="formRowLavel-title">延長保証終了日</div></div>
            <div class="formRow-value">
              <div class="formRow-value">@if($warranty->date_end){{date('Y/m/d',strtotime($warranty->date_end))}}@endif</div>
            </div>
          </div>
        </div>
        <div class="form-header">その他</div>
        <div class="form-box box-color-yr">
          <div class="form-row form-size-max">
            <div class="formRow-label"><div class="formRowLavel-title">備考</div></div>
            <div class="formRow-value @if(!$warranty->remark)value-height @endif">{!!nl2br(e($warranty->remark))!!}</div>
          </div>
        </div>
      </div>
      <div class="form-submit">
        <a href="{{route('detail.index', ['login_id' =>$data['login_id']])}}?id={{$warranty->id}}" class="submit-button button-color-bk">戻る</a>
        <button name="action" type="submit" value="delete" class="submit-button button-color-rd">削除する</button>
        <input name="id" type="hidden" value="{{$warranty->id}}" />
      </div>
    @endforeach
  </form>
</div>
@endsection