@extends('template.header')
@section('title','ユーザー削除')
@section('body')
<div class="content">
  <form method="POST" action="{{route('admin.customer.delete.send')}}">
    @csrf
    @foreach($data['customer'] as $customer)
      <div class="form form-width-sm">
        <div class="nav">
          <div class="nav-title">ユーザー削除
            <div class="nav-alert"><i class="fas fa-exclamation-triangle"></i>&nbsp;ユーザーを削除しますか？</div>
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
              <div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]請求元</font></div></div>
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
          <a href="{{route('admin.customer.detail.index')}}?id={{$customer->login_id}}" class="submit-button button-color-bk">戻る</a>
          <button name="action" type="submit" value="delete" class="submit-button button-color-rd">削除する</button>
          <input name="id" type="hidden" value="{{$customer->login_id}}" />
        </div>
      </div>
    @endforeach
  </form>
</div>
@endsection
