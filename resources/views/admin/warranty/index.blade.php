@extends('template.header')
@section('title','管理画面')
@section('body')
<div class="content">
  <div class="nav">
    <div class="nav-title">保証書一覧<a href="{{route('admin.index')}}" class="listButton-serach listButton-button button-color-bk"><i class="fas fa-reply"></i>&nbsp;TOPに戻る</a></div>
    <form method="POST" action="{{route('admin.warranty.index')}}?user={{$data['user']}}">
      @csrf
      <div class="nav-serach">
        <div class="navSearch-box box-word">
          <div class="navSearchBox-label">保証番号、顧客名、住所から検索 (部分一致)</div>
          <input name="keyword" type="text" class="form-control form-control-sm" value="{{$data['set']}}" />
        </div>
        <div class="navSearch-box">
          <div class="navSearchBox-label">保証開始日</div>
          <div class="navSearchBox-value">
            <input name="date_start" type="text" class="calendar form-control form-control-sm form-size-sm" value="{{$data['date_start']}}" />
            <span>～</span>
            <input name="date_end" type="text" class="calendar form-control form-control-sm form-size-sm" value="{{$data['date_end']}}" />
          </div>
        </div>
        <div class="navSearch-button">
          <button name="action" type="submit" value="sercah" class="listButton-serach listButton-button button-color-bl"><i class="fas fa-search"></i>&nbsp;検索</button>
        </div>
      </div>
    </form>
  </div>
  <div class="list">
    <div class="list-page">{{$data['warranty']->links()}}</div>
    <table class="list-table">
      <thead><tr>
        <th></th>
        <th>保証番号</th>
        <th>顧客名</th>
        <th>商品名</th>
        <th>登録日</th>
        <th>更新日</th>
        <th></th>
        <th></th>

      </tr></thead>
      <tbody>
        @foreach($data['warranty'] as $warranty)
          <tr>
            <td width="53">@if($warranty->judgment == '1')<span class="list-status">保証中</span>@endif</td>
            <td>{{$warranty->id}}</td>
            <td><span class="list-kana">{{$warranty->kana}}</span>{{$warranty->name}}</td>
            <td>{{$warranty->product_maker}}&nbsp;{{$warranty->product_name}}</td>
            <td><span class="list-time">{{date('Y/m/d H:i:s',strtotime($warranty->created_at))}}</span></td>
            <td><span class="list-time">{{date('Y/m/d H:i:s',strtotime($warranty->updated_at))}}</span></td>
            <td class="list-button">
              <a class="listButton-button button-color-pk" href="{{route('admin.document.pdf')}}?user={{$data['user']}}&id={{$warranty->id}}" target="_blank">
                <i class="fas fa-file-alt"></i>&nbsp;保証書
              </a>
            </td>
            <td class="list-button">
              <a class="listButton-button button-color-gr" href="{{route('admin.detail.index')}}?user={{$data['user']}}&id={{$warranty->id}}">
                <i class="fas fa-comment-dots"></i>&nbsp;詳細
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
