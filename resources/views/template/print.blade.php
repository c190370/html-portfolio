<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;900&display=swap" rel="stylesheet">
    <link href="{{asset('public/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/print.css')}}" rel="stylesheet">
    <script src="{{asset('public/js/jquery-3.5.1.min.js')}}" defer></script>
    <script src="{{asset('public/js/print.js')}}" defer></script>
    <title>BEST保証申請</title>
  </head>
  <body>
    <div id="wrapper">
      <div class="header">
      </div>
@yield('body')
    </div>
  </body>
</html>