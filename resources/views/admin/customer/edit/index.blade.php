@extends('template.header')
@section('title','ユーザー編集')
@section('body')
<div class="content">
  <form method="POST" action="{{route('admin.customer.edit.send')}}" class="h-adr">
    @csrf
    @foreach($data['customer'] as $customer)
      <div class="form form-width-sm">
        <div class="nav"><div class="nav-title">ユーザー編集</div></div>
        <div class="form-box box-size-sm box-color-bl">
          <div class="form-row">
            <div class="formRow-label">
              <div class="formRowLavel-title">ユーザー名</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="name" type="text" class="form-control form-control-sm @if($errors->has('name'))form-error @endif" value=@if(old('name'))"{{old('name')}}"@else"{{$customer->name}}"@endif />
              @if($errors->has('name'))<div class="formRowLavel-error">{{$errors->first('name')}}</div>@endif
            </div>
          </div>
          <div class="form-row">
            <div class="formRow-label">
              <div class="formRowLavel-title">ユーザーID</div><div class="form-annotation form-alert">※変更できません</div>
            </div>
            <div class="formRow-value">
              {{$customer->login_id}}
            </div>
          </div>
          <div class="form-row">
            <div class="formRow-label">
              <div class="formRowLavel-title">ユーザーイニシャル</div><div class="form-annotation form-alert">※変更できません</div>
            </div>
            <div class="formRow-value">
              {{$customer->initial}}
            </div>
          </div>
          <div class="form-row">
            <div class="formRow-label">
              <div class="formRowLavel-title">住所</div>
            </div>
            <div class="formRow-value">
              <div class="formRowValue-top">
                <div class="form-caption caption-width">郵便番号</div>
                <input name="zip" type="text" class="p-postal-code form-control form-control-sm form-size-sm @if($errors->has('zip'))form-error @endif" value=@if(old('zip'))"{{old('zip')}}"@else"{{$customer->zip}}"@endif />
                <div class="form-annotation form-alert">※ハイフンなし・半角数字で入力</div>
              </div>
              <div class="formRowValue-bottom">
                <div class="form-caption caption-width">住所</div><span class="p-country-name" style="display:none;">Japan</span>
                <input name="address" type="text" class="p-region p-locality p-street-address form-control form-control-sm form-size-ad @if($errors->has('address'))form-error @endif" value=@if(old('address'))"{{old('address')}}"@else"{{$customer->address}}"@endif />
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
              <input name="email" type="text" class="form-control form-control-sm @if($errors->has('email'))form-error @endif" value=@if(old('email'))"{{old('email')}}"@else"{{$customer->email}}"@endif />
              @if($errors->has('email'))<div class="formRowLavel-error">{{$errors->first('email')}}</div>@endif
            </div>
          </div>
          <div class="form-row">
            <div class="formRow-label">
              <div class="formRowLavel-title">電話番号</div><div class="form-annotation form-alert">※半角数字とハイフンで入力</div>
            </div>
            <div class="formRow-valuer">
              <input name="tel" type="text" class="form-control form-control-sm @if($errors->has('tel'))form-error @endif" value=@if(old('tel'))"{{old('tel')}}"@else"{{$customer->tel}}"@endif />
              @if($errors->has('tel'))<div class="formRowLavel-error">{{$errors->first('tel')}}</div>@endif
            </div>
          </div>
        </div>
        <div class="form-box box-size-sm box-color-bl">
          <div class="form-row">
            <div class="formRow-label">
              <div class="formRowLavel-title"><font class="formRowLavel-color-pink">[保証書]</font>「販売店・延長保証サービス窓口」欄の文言</div>
            </div>
            <div class="formRow-value">
              <textarea name="remark" rows="3" class="calendar form-control form-control-sm @if($errors->has('remark'))form-error @endif">@if(old('remark')){{old('remark')}}@else{{$customer->remark}}@endif</textarea>
              @if($errors->has('remark'))<div class="formRowLavel-error">{{$errors->first('remark')}}</div>@endif
            </div>
          </div>
          <div class="form-row">
            <div class="formRow-label">
              <div class="formRowLavel-title"><font class="formRowLavel-color-green">[請求書]</font>振込先</div>(※2行まで)<div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <textarea id="payee" name="payee" rows="2" class="calendar form-control form-control-sm @if($errors->has('payee'))form-error @endif">@if(old('payee')){{old('payee')}}@else{{$customer->payee}}@endif</textarea>
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
                <input name="claimant_name" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_name'))form-error @endif" value=@if(old('claimant_name'))"{{old('claimant_name')}}"@else"{{$customer->claimant_name}}"@endif />
              </div>
              <div class="formRowValue-top">
                <div class="form-caption caption-width">住所</div>
                <input name="claimant_address" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_address'))form-error @endif" value=@if(old('claimant_address'))"{{old('claimant_address')}}"@else"{{$customer->claimant_address}}"@endif />
              </div>
              <div class="formRowValue-top">
                <div class="form-caption caption-width">電話番号</div>
                <input name="claimant_tel" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_tel'))form-error @endif" value=@if(old('claimant_tel'))"{{old('claimant_tel')}}"@else"{{$customer->claimant_tel}}"@endif />
              </div>
              <div class="formRowValue-bottom">
                <div class="form-caption caption-width">FAX</div>
                <input name="claimant_fax" type="text" class="form-control form-control-sm form-size-ad @if($errors->has('claimant_fax'))form-error @endif" value=@if(old('claimant_fax'))"{{old('claimant_fax')}}"@else"{{$customer->claimant_fax}}"@endif />
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
        <a href="{{route('admin.customer.detail.index')}}?id={{$customer->login_id}}" class="submit-button button-color-bk">戻る</a>
        <button name="action" type="submit" value="edit" class="submit-button button-color-bl">変更する</button>
        <input name="id" type="hidden" value="{{$customer->login_id}}" />
      </div>
    @endforeach
  </form>
</div>
@endsection
