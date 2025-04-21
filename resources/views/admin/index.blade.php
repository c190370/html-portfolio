@extends('template.header')
@section('title','管理画面')
@section('body')
<div class="content">
  <div class="nav">
    <div class="nav-title">ユーザー一覧</div>
    <div class="nav-create">
      <a class="listButton-create listButton-button button-color-bl" href="{{route('admin.customer.create.index')}}">
        <i class="fas fa-user-plus"></i>&nbsp;新規追加
      </a>
    </div>
  </div>
  <div class="list">
    <table>
      <thead><tr>
        <th></th>
        <th>ユーザー名</th>
        <th>メールアドレス</th>
        <th>電話番号</th>
        <th>住所</th>
        <th></th>
      </tr></thead>
      <tbody>
        @foreach($data['customers'] as $customer)
          <tr @if($customer->role=='delete')class="list-delete"@endif>
            <td class="list-button"><a class="listButton-button button-color-pk" href="{{route('admin.warranty.index')}}?user={{$customer->login_id}}"><i class="fas fa-file-alt"></i></a></td>
            <td>{{$customer->name}}</td>
            <td>{{$customer->email}}</td>
            <td>{{$customer->tel}}</td>
            <td>〒{{$customer->zip}}&nbsp;{{$customer->address}}</td>
            <td class="text-center">
              <a class="listButton-button button-color-gr" href="{{route('admin.customer.detail.index')}}?id={{$customer->login_id}}">
                <i class="fas fa-list-alt"></i>&nbsp;詳細
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
