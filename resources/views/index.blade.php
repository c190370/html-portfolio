@extends('template.header')
@section('title','TOP画面')
@section('body')
<div class="content">
  <div class="nav">
    <div class="nav-title">保証書一覧</div>
    <div class="nav-create">
      <a class="listButton-create listButton-button button-color-bl" href="{{route('create.index', ['login_id' =>$data['login_id']])}}">
        <span><i class="fas fa-file"></i>&nbsp;新規追加</span>
      </a>
      <a class="listButton-create listButton-button button-color-bl" href="{{route('import.index', ['login_id' =>$data['login_id']])}}">
        <span><i class="fas fa-file-import"></i>&nbsp;CSV取込</span>
      </a>
      <a class="listButton-create listButton-button button-color-bk" href="{{route('invoice.index', ['login_id' =>$data['login_id']])}}">
        <span><i class="fas fa-money-check-alt"></i>&nbsp;請求書</span>
      </a>
    </div>
    <form method="POST" action="{{route('index', ['login_id' =>$data['login_id']])}}">
      @csrf
      <div class="nav-serach">
        <div class="navSearch-box box-word">
          <div class="navSearchBox-label">保証番号、顧客名(フリガナでも可)、住所 (部分一致可)から検索</div>
          <input name="keyword" type="text" class="form-control form-control-sm" value="{{$data['set']}}" />
        </div>
        <div class="navSearch-box">
          <div class="navSearchBox-label">保証開始日</div>
          <div class="navSearchBox-value">
            <input name="date_start_s" type="text" class="calendar form-control form-control-sm form-size-sm" value="{{$data['date_start_s']}}" />
            <span>～</span>
            <input name="date_end_s" type="text" class="calendar form-control form-control-sm form-size-sm" value="{{$data['date_end_s']}}" />
          </div>
        </div>
        <div class="navSearch-box box-word">
        </div>
        <div class="navSearch-box">
          <div class="navSearchBox-label">購入日</div>
          <div class="navSearchBox-value">
            <input name="date_start_p" type="text" class="calendar form-control form-control-sm form-size-sm" value="{{$data['date_start_p']}}" />
            <span>～</span>
            <input name="date_end_p" type="text" class="calendar form-control form-control-sm form-size-sm" value="{{$data['date_end_p']}}" />
          </div>
        </div>
        <div class="navSearch-button">
          <button name="action" type="submit" value="sercah" class="listButton-serach listButton-button button-color-bl">
            <span><i class="fas fa-search"></i>&nbsp;検索</span>
          </button>
        </div>
      </div>
    </form>
  </div>
  <div class="list">
    <div class="list-page">{!! $data['warranty']->links()!!}</div>
    <table class="list-table">
      <thead><tr>
        <th width="49"></th>
        <th width="115">保証番号</th>
        <th width="90">顧客名</th>
        <th>商品名 / 型番</th>
        <th width="110">登録日時</th>
        <th width="110">更新日時</th>
        <th width="75">購入日</th>
        <th width="75">保証開始日</th>
        <th width="129">保証書</th>
        <th width="62"></th>
        <th width="62"></th>
      </tr></thead>
      <tbody>
        @foreach($data['warranty'] as $warranty)
          <tr>
            <td>@if($warranty->judgment == '1')<span class="list-status">保証中</span>@endif</td>
            <td>{{$warranty->id}}</td>
            <td>{{$warranty->name}}</td>
            <td>{{$warranty->product_maker}}&nbsp;{{$warranty->product_name}}&nbsp;/&nbsp;{{$warranty->product_number}}</td>
            <td class="list-time">{{date('Y/m/d H:i',strtotime($warranty->created_at))}}<br/></td>
            <td class="list-time">{{date('Y/m/d H:i',strtotime($warranty->updated_at))}}</td>
            <td class="list-time">{{date('Y/m/d',strtotime($warranty->date_purchase))}}</td>
            <td class="list-time">{{date('Y/m/d',strtotime($warranty->date_start))}}</td>
            <td class="list-button-w">
              <div>
              <a class="listButton-button button-color-pk" href="{{route('document.pdf', ['login_id' =>$data['login_id']])}}?id={{$warranty->id}}" target="_blank">
                <i class="far fa-file-pdf"></i>&nbsp;PDF
              </a>
              <a class="listButton-button button-color-pk" href="{{route('document.print', ['login_id' =>$data['login_id']])}}?id={{$warranty->id}}" target="_blank">
                <i class="fab fa-html5"></i>&nbsp;HTML
              </a>
              </div>
            </td>
            <td class="list-button">
              <a class="listButton-button button-color-bl" href="{{route('copy.index', ['login_id' =>$data['login_id']])}}?id={{$warranty->id}}">
                <i class="fas fa-copy"></i>&nbsp;複製
              </a>
            </td>
            <td class="list-button">
              <a class="listButton-button button-color-gr" href="{{route('detail.index', ['login_id' =>$data['login_id']])}}?id={{$warranty->id}}">
                <i class="fas fa-list-alt"></i>&nbsp;詳細
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="list-page">{{$data['warranty']->links()}}</div>
  </div>
</div>
@endsection
