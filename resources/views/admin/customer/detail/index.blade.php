@extends('template.header')
@section('title','ユーザー詳細')
@section('body')
<div class="content">
  @foreach($data['customer'] as $customer)
    <div class="form form-width-sm">
      <div class="nav">
        <div class="nav-title">ユーザー詳細
          <a class="listButton-button button-color-gr" href="{{route('admin.customer.edit.index')}}?id={{$customer->login_id}}">
            <i class="fas fa-edit"></i>&nbsp;編集
          </a>
          <a class="listButton-button button-color-rd" href="{{route('admin.customer.delete.index')}}?id={{$customer->login_id}}">
            <i class="fas fa-trash"></i>&nbsp;削除
          </a>
        </div>
      </div>
      <div class="form-box box-size-sm box-color-bl">
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">ユーザー名</div></div>
          <div class="formRow-value">{{$customer->name}}</div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">ユーザーID</div></div>
          <div class="formRow-value">{{$customer->login_id}}</div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">ユーザーイニシャル</div></div>
          <div class="formRow-value">
            <div class="formRow-value">{{$customer->initial}}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title">住所</div></div>
          <div class="formRow-value">
            <div class="formRowValue-top">
              <div class="form-caption caption-width">郵便番号</div>
              <div class="formRow-value form-size-md">{{$customer->zip}}</div>
            </div>
            <div class="formRowValue-bottom">
              <div class="form-caption caption-width">住所</div>
              <div class="formRow-value form-size-ad">{{$customer->address}}</div>
            </div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">メールアドレス</div></div>
          <div class="formRow-value">
            <div class="formRow-value @if(!$customer->email)value-height @endif">{{$customer->email}}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title">電話番号</div></div>
          <div class="formRow-valuer">
            <div class="formRow-value @if(!$customer->tel)value-height @endif">{{$customer->tel}}</div>
          </div>
        </div>
      </div>
      <div class="form-box box-size-sm box-color-bl">
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title"><font class="formRowLavel-color-pink">[保証書]</font>「販売店・延長保証サービス窓口」欄の文言</div></div>
          <div class="formRow-value">
            <div class="formRow-value @if(!$customer->remark)value-height @endif">{!!nl2br(e($customer->remark))!!}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]</font>振込先</div></div>
          <div class="formRow-value">
            <div class="formRow-value @if(!$customer->payee)value-height @endif">{!!nl2br(e($customer->payee))!!}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]</font>請求元</div></div>
          <div class="formRow-value">
            <div class="formRowValue-top">
              <div class="form-caption caption-width">名前</div>
              <div class="formRow-value form-size-md">{{$customer->claimant_name}}</div>
            </div>
            <div class="formRowValue-top">
              <div class="form-caption caption-width">住所</div>
              <div class="formRow-value form-size-ad">{{$customer->claimant_address}}</div>
            </div>
            <div class="formRowValue-top">
              <div class="form-caption caption-width">電話番号</div>
              <div class="formRow-value form-size-md">{{$customer->claimant_tel}}</div>
            </div>
            <div class="formRowValue-bottom">
              <div class="form-caption caption-width">FAX</div>
              <div class="formRow-value form-size-ad">{{$customer->claimant_fax}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-submit">
        <a href="{{route('admin.index')}}" class="submit-button button-color-bk">戻る</a>
      </div>
    </div>
  @endforeach
</div>
@endsection
