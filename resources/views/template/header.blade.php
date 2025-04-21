<!DOCTYPE html>
<?php $date = date('Ymd') ?>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Kosugi+Maru&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/overcast/jquery-ui.css">
    <link href="{{asset('public/css/app.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/style.css')}}?id={{$date}}1" rel="stylesheet">
    <script src="{{asset('public/js/jquery-3.5.1.min.js')}}" defer></script>
    <script src="{{asset('public/js/jquery-ui.min.js')}}" defer></script>
    <script src="{{asset('public/js/datepicker-ja.js')}}" defer></script>
    <script src="{{asset('public/js/popper.min.js')}}" defer></script>
    <script src="{{asset('public/js/yubinbango.js')}}" defer></script>
    <script src="{{asset('public/js/jquery.tablesorter.min.js')}}" defer></script>
    <script src="{{asset('public/js/bootstrap.min.js')}}" defer></script>
    <script src="{{asset('public/js/style.js')}}?id={{$date}}0" defer></script>
    <title>BEST保証申請</title>
  </head>
  <body @auth @if(Auth::User()->role=="admin")class="admin" @endif @endauth>
    <div id="wrapper">
      @if(session('session'))
        <div class="modal fade" id="sessionMessage" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body text-center">{{session('session')}}</div>
              <div class="modal-footer"><button type="button" class="listButton-button button-color-bk" data-dismiss="modal">閉じる</button></div>
            </div>
          </div>
        </div>
      @endif
      <div class="header">
        <div class="header-left">
          <a @auth href=@if(Auth::User()->role=="admin")"{{route('admin.index')}}"@else"{{route('index', ['login_id' =>Auth::User()->login_id])}}"@endif @endauth class="headerLeft-title">
            住宅設備延長保証管理システム@auth @if(Auth::User()->role=="admin")(管理画面)@endif @endauth
          </a>
        </div>
        <div class="header-right">
          @auth
            <a class="" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
              ログアウト
            </a>
          @endauth
        <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">@csrf</form>
        </div>
      </div>
@yield('body')
    </div>
  </body>
</html>