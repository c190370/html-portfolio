@extends('template.header')
@section('title','ユーザー登録(確認)')
@section('body')
<div class="content">
  <form method="POST" action="{{route('admin.customer.create.send')}}" class="h-adr">
    @csrf
    <div class="form form-width-sm">
      <div class="nav"><div class="nav-title">登録内容確認</div></div>
      <div class="form-box box-size-sm box-color-bl">
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">ユーザー名</div></div>
          <div class="formRow-value">{{Session::get('name')}}</div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">ユーザーID</div></div>
          <div class="formRow-value">{{Session::get('login_id')}}</div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">ユーザーイニシャル</div></div>
          <div class="formRow-value">
            <div class="formRow-value">{{Session::get('initial')}}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label"><div class="formRowLavel-title">メールアドレス</div></div>
          <div class="formRow-value">
            <div class="formRow-value @if(!Session::get('email'))value-height @endif">{{Session::get('email')}}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title">住所</div></div>
          <div class="formRow-value">
            <div class="formRowValue-top">
              <div class="form-caption caption-width">郵便番号</div>
              <div class="formRow-value form-size-md">{{Session::get('zip')}}</div>
            </div>
            <div class="formRowValue-bottom">
              <div class="form-caption caption-width">住所</div>
              <div class="formRow-value form-size-ad">{{Session::get('address')}}</div>
            </div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title">電話番号</div></div>
          <div class="formRow-valuer">
            <div class="formRow-value @if(!Session::get('tel'))value-height @endif">{{Session::get('tel')}}</div>
          </div>
          </div>
      </div>
      <div class="form-box box-size-sm box-color-bl">
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title"><font class="formRowLavel-color-pink">[保証書]</font>「販売店・延長保証サービス窓口」欄の文言</div></div>
          <div class="formRow-value">
            <div class="formRow-value @if(!Session::get('remark'))value-height @endif">{!!nl2br(e(Session::get('remark')))!!}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]</font>振込先</div></div>
          <div class="formRow-value">
            <div class="formRow-value @if(!Session::get('payee'))value-height @endif">{!!nl2br(e(Session::get('payee')))!!}</div>
          </div>
        </div>
        <div class="form-row row-size-sm">
          <div class="formRow-label">
            <div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]</font>請求元</div></div>
          <div class="formRow-value">
            <div class="formRowValue-top">
              <div class="form-caption caption-width">名前</div>
              <div class="formRow-value form-size-md">{{Session::get('claimant_name')}}</div>
            </div>
            <div class="formRowValue-bottom">
              <div class="form-caption caption-width">住所</div>
              <div class="formRow-value form-size-ad">{{Session::get('claimant_address')}}</div>
            </div>
            <div class="formRowValue-top">
              <div class="form-caption caption-width">電話番号</div>
              <div class="formRow-value form-size-md">{{Session::get('claimant_tel')}}</div>
            </div>
            <div class="formRowValue-bottom">
              <div class="form-caption caption-width">FAX</div>
              <div class="formRow-value form-size-ad">{{Session::get('claimant_fax')}}</div>
            </div>
          </div>
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
