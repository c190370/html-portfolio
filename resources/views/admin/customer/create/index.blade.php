@extends('template.header')
@section('title','ユーザー登録')
@section('body')
<div class="content">
  <form method="POST" action="{{route('admin.customer.create.confirm')}}" class="h-adr">
    @csrf
    <div class="form form-width-sm">
      <div class="nav"><div class="nav-title">ユーザー登録</div></div>
      <div class="form-box box-size-sm box-color-bl">
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title">ユーザー名</div><div class="formRowLavel-require">必須</div>
          </div>
          <div class="formRow-value">
            <input name="name" type="text" class="form-control form-control-sm @if($errors->has('name'))form-error @endif" value=@if(Session::get('name'))"{{Session::get('name')}}"@else"{{old('name')}}"@endif />
            @if($errors->has('name'))<div class="formRowLavel-error">{{$errors->first('name')}}</div>@endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title">ユーザーID</div><div class="formRowLavel-require">必須</div><div class="form-annotation form-alert">※小文字の半角英数字で入力</div>
          </div>
          <div class="formRow-value">
            <input name="login_id" type="text" class="form-control form-control-sm @if($errors->has('login_id'))form-error @endif" value=@if(Session::get('login_id'))"{{Session::get('login_id')}}"@else"{{old('login_id')}}"@endif />
            @if($errors->has('login_id'))<div class="formRowLavel-error">{{$errors->first('login_id')}}</div>@endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title">ユーザーイニシャル</div><div class="formRowLavel-require">必須</div><div class="form-annotation form-alert">※大文字の半角英字2文字で入力</div>
          </div>
          <div class="formRow-value">
            <input name="initial" type="text" class="form-control form-control-sm form-size-sm @if($errors->has('initial'))form-error @endif" value=@if(Session::get('initial'))"{{Session::get('initial')}}"@else"{{old('initial')}}"@endif />
            @if($errors->has('initial'))<div class="formRowLavel-error">{{$errors->first('initial')}}</div>@endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title">住所</div>
          </div>
          <div class="formRow-value">
            <div class="formRowValue-top">
              <div class="form-caption caption-width">郵便番号</div>
              <input name="zip" type="text" class="p-postal-code form-control form-control-sm form-size-sm @if($errors->has('zip'))form-error @endif" value=@if(Session::get('zip'))"{{Session::get('zip')}}"@else"{{old('zip')}}"@endif />
              <div class="form-annotation form-alert">※ハイフンなし・半角数字で入力</div>
            </div>
            <div class="formRowValue-bottom">
              <div class="form-caption caption-width">住所</div><span class="p-country-name" style="display:none;">Japan</span>
              <input name="address" type="text" class="p-region p-locality p-street-address form-control form-control-sm form-size-ad @if($errors->has('address'))form-error @endif" value=@if(Session::get('address'))"{{Session::get('address')}}"@else"{{old('address')}}"@endif />
            </div>
            @if($errors->has('zip')||$errors->has('address'))
              <div class="formRowLavel-error">{{$errors->first('zip')}}</div>
              <div class="formRowLavel-error">{{$errors->first('address')}}</div>
            @endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title">メールアドレス</div>
          </div>
          <div class="formRow-value">
            <input name="email" type="text" class="form-control form-control-sm @if($errors->has('email'))form-error @endif" value=@if(Session::get('email'))"{{Session::get('email')}}"@else"{{old('email')}}"@endif />
            @if($errors->has('email'))<div class="formRowLavel-error">{{$errors->first('email')}}</div>@endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title">電話番号</div><div class="form-annotation form-alert">※半角数字とハイフンで入力</div>
          </div>
          <div class="formRow-valuer">
            <input name="tel" type="text" class="form-control form-control-sm @if($errors->has('tel'))form-error @endif" value=@if(Session::get('tel'))"{{Session::get('tel')}}"@else"{{old('tel')}}"@endif />
            @if($errors->has('tel'))<div class="formRowLavel-error">{{$errors->first('tel')}}</div>@endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title">パスワード</div><div class="formRowLavel-require">必須</div>
          </div>
          <div class="formRow-value">
            <div class="formRowValue-top">
              <input name="password" type="password" class="form-control form-control-sm form-size-md @if($errors->has('password'))form-error @endif" value="{{old('password')}}" autocomplete="new-password" />
            </div>
            <div class="formRowValue-bottom">
            <input name="password_confirmation" type="password" class="form-control form-control-sm form-size-md @if($errors->has('password_confirmation'))form-error @endif" value="{{old('password_confirmation')}}" />
            <div class="form-annotation">(確認用)</div>
            </div>
            @if($errors->has('password'))<div class="formRowLavel-error">{{$errors->first('password')}}</div>@endif
          </div>
        </div>
      </div>
      <div class="form-box box-size-sm box-color-bl">
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title"><font class="formRowLavel-color-pink">[保証書]</font>「販売店・延長保証サービス窓口」欄の文言</div>
          </div>
          <div class="formRow-value">
            <textarea name="remark" rows="3" class="calendar form-control form-control-sm @if($errors->has('remark'))form-error @endif">@if(Session::get('remark')){{Session::get('remark')}}@else{{old('remark')}}@endif</textarea>
            @if($errors->has('remark'))<div class="formRowLavel-error">{{$errors->first('remark')}}</div>@endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]</font>振込先</div>(※2行まで)<div class="formRowLavel-require">必須</div>
          </div>
          <div class="formRow-value">
            <textarea id="payee" name="payee" rows="2" class="calendar form-control form-control-sm @if($errors->has('payee'))form-error @endif">@if(Session::get('payee')){{Session::get('payee')}}@else{{old('payee')}}@endif</textarea>
            @if($errors->has('payee'))<div class="formRowLavel-error">{{$errors->first('payee')}}</div>@endif
          </div>
        </div>
        <div class="form-row">
          <div class="formRow-label">
            <div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]</font>請求元</div><div class="formRowLavel-require">必須</div>(FAX以外)
          </div>
          <div class="formRow-value">
            <div class="formRowValue-top">
              <div class="form-caption caption-width">名前</div>
              <input name="claimant_name" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_name'))form-error @endif" value=@if(Session::get('claimant_name'))"{{Session::get('claimant_name')}}"@else"{{old('claimant_name')}}"@endif />
            </div>
            <div class="formRowValue-top">
              <div class="form-caption caption-width">住所</div>
              <input name="claimant_address" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_address'))form-error @endif" value=@if(Session::get('claimant_address'))"{{Session::get('claimant_address')}}"@else"{{old('claimant_address')}}"@endif />
            </div>
            <div class="formRowValue-top">
              <div class="form-caption caption-width">電話番号</div>
              <input name="claimant_tel" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_tel'))form-error @endif" value=@if(Session::get('claimant_tel'))"{{Session::get('claimant_tel')}}"@else"{{old('claimant_tel')}}"@endif />
            </div>
            <div class="formRowValue-bottom">
              <div class="form-caption caption-width">FAX</div>
              <input name="claimant_fax" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_fax'))form-error @endif" value=@if(Session::get('claimant_fax'))"{{Session::get('claimant_fax')}}"@else"{{old('claimant_fax')}}"@endif />
            </div>
            @if($errors->has('claimant_name')||$errors->has('claimant_address')||$errors->has('claimant_tel')||$errors->has('claimant_fax'))
              <div class="formRowLavel-error">{{$errors->first('claimant_name')}}</div>
              <div class="formRowLavel-error">{{$errors->first('claimant_address')}}</div>
              <div class="formRowLavel-error">{{$errors->first('claimant_tel')}}</div>
              <div class="formRowLavel-error">{{$errors->first('claimant_fax')}}</div>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="form-submit">
      <a href="{{route('admin.index')}}" class="submit-button button-color-bk">戻る</a>
      <button name="action" type="submit" value="regist" class="submit-button button-color-bl">確認画面へ</button>
    </div>
  </form>
</div>
@endsection
