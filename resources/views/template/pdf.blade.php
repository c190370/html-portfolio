<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
      @font-face{
          font-style: normal;
          font-weight: normal;
          src: url("{{ storage_path('fonts/NotoSansJP-Regular.otf') }}") format('opentype');
      }
      @page{margin: 20px 15px;}
      body {
        font-family: -apple-system,BlinkMacSystemFont,KintoSans-Regular;
        width: 100%;
        margin: 10px 15px;
        word-wrap: break-word; 　　/* IEやFirefox対応用 */
　　    overflow-wrap: break-word;
      }

      table{
        border-collapse:  collapse; 
      }

      td{
        padding: 5px;
        color: #000000;
        border: solid 1px #666666;
      }
    

      .title{
        width: 100%;
        text-align: center;
        border-bottom: solid 3px #e2ddac;
      }

      .sub-title{
        font-size: 16px;
      }

      .area_1{
        position: absolute;
        width: 100%;
        margin: 20px 0 0 0;
        font-size: 14px;
      }

      .area_2{
        position: absolute;
        width: 100%;
        margin: 92px 0 0 0;
        font-size: 14px;
      }

      .area_3{
        page-break-before: always;
        position: absolute;
        width: 100%;
        font-size: 12px;
      }

      .area_2 table{
        width: 100%;
      }

      .area_3 table{
        width: 100%;
      }

      .name{
        float: left;
        width: 100%;
        font-family: genshingothic-normal;
      }

      .mark{
        float: right;
        width: 10%;
        height: 70px;
        line-height: 50px;
        margin: 0 10% 0 0;
        font-size: 24px;
        text-align: center;
        background-color: #beb668;    
      }
      </style>
  </head>
  <body>
    <div id="wrapper">
      <div class="header">
      </div>
@yield('body')
    </div>
  </body>
</html>