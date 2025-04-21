@extends('template.header')
@section('title','ログイン画面')
@section('body')
<div class="content">
  <form method="POST" action="{{ route('login') }}">
    @csrf
      <div class="form form-login form-width-sm">
        <div class="form-header">IDとパスワードを入力してください</div>
        <div class="form-box box-size-sm">
          @if($errors->has('login_id') && $errors->has('password'))<div class="form-alert alert-login">IDとパスワードを入力してください。</div>
          @elseif($errors->has('login_id'))<div class="form-alert alert-login">{{$errors->first('login_id')}}</div>
          @elseif($errors->has('password'))<div class="form-alert alert-login">{{$errors->first('password')}}</div>
          @elseif(session('loginerror'))<div class="form-alert alert-login">{{session('loginerror')}}</div>@endif
          <div class="form-row">
            <div class="formRow-label">ID</div>
            <div class="formRow-value">
                <input name="login_id" type="text" class="form-control form-control-sm" alue="{{old('login_id')}}" autofocus>
            </div>
          </div>
          <div class="form-row">
            <div class="formRow-label">パスワード</div>
            <div class="formRow-value">
                <input name="password" type="password" class="form-control form-control-sm" autocomplete="current-password">
            </div>
          </div>
          <div class="form-row form-size-keyword">
            <div class="formRow-label">
              <input class="" name="remember" type="checkbox" {{old('remember') ? 'checked' : ''}}>
              <div>&nbsp;ログイン情報を記憶する</div>
            </div>
          </div>
          <div class="form-submit">
            <button type="submit" class="submit-button button-color-bl">ログイン</button>
          </div>
        </div>
      </div>



  </form>


</div>
@endsection
