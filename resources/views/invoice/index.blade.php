@extends('template.header')
@section('title','請求書')
@section('body')
<div class="content">
    <div class="nav nav-invoice">
      <div>
        <form method="POST" action="{{route('invoice.index', ['login_id' =>$data['login_id']])}}">
          @csrf
          <div class="nav-serach">
            <div class="navSearch-lavel">年月選択</div>
            <div class="navSearchBox-value navSearchBox-width">
              <select name="ym" class="form-control form-control-sm form-size-sm" onchange="submit(this.form)">
                @foreach($data['select_ym'] as $select_ym)
                  <option value="{{$select_ym->ym}}" @if($data['yyyymm']) @if($select_ym->ym==$data['yyyymm'])selected @endif @else @if($select_ym->ym==date('Ym'))selected @endif @endif>{{substr($select_ym->ym, 0, 4)}}年{{ltrim(substr($select_ym->ym, 4, 2), 0)}}月</option>
                @endforeach
              </select>
            </div>
          </div>
        </form>
      </div>
      {{--  <a class="listButton-serach listButton-button button-color-bl" href="{{route('invoice.edit.index', ['login_id' =>$data['login_id']])}}">
        <i class="fas fa-yen-sign"></i>&nbsp;単価設定
      </a>  --}}
    </div>
    <div class="invoice">
      <div class="invoice-title"><span>請求書</span></div>
      <div class="invoice-date"><span>{{date("Y/n/j")}}</span></div>
        <div class="invoiceHeader-name"><span>{{$data['name']}}</span>御中</div>
        <div class="invoiceHeader-row">
          <div class="invoiceHeader-left">
            <div>
              <div class="invoiceHeaderLeft-month">{{ltrim($data['month'], '0')}}月分</div>
              <div class="invoiceHeaderLeft-word">下記の通り、御請求申し上げます。</div>
            </div>
          </div>
          <div class="invoiceHeader-right">
            <div class="invoiceHeaderRight-name">{{$data['customer'][0]->claimant_name}}</div>
            <div class="invoiceHeaderRight-value">{{$data['customer'][0]->claimant_address}}</div>
            <div class="invoiceHeaderRight-value">TEL:{{$data['customer'][0]->claimant_tel}}</div>
            @if(isset($data['customer'][0]->claimant_fax))
              <div class="invoiceInfoRight-value">FAX:{{$data['customer'][0]->claimant_fax}}</div>
            @endif
            <div class="invoiceHeaderRight-value">事業者登録番号:T8120003009713</div>
          </div>
        </div>
      <div class="invoice-info">
        <table>
          <tbody>
            <tr>
              <td rowspan="2"  width="260">
                <div class="invoiceInfo-left">
                  <div class="invoiceInfo-title">請求金額</div>
                  <div>\{{number_format($data['total'])}}</div>
                </div>
              </td>
              <td>
                <div class="invoiceInfo-right">
                  <div class="invoiceInfo-title">お振込口座</div>
                  <div>{!!nl2br(e($data['customer'][0]->payee))!!}</div>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="invoiceInfo-right">
                  <div class="invoiceInfo-title">支払期日</div>
                  <div>{{$data['last_day']}}</div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="invoice-calc">
        <table>
          <thead>
            <tr><th width="260">品名</th><th width="120">単価</th><th width="100">数量</th><th width="120">金額</th></tr>
          </thead>
          <tbody
            @foreach($data['product'] as $product)
              <tr>
                <td>@if($product->product_name){{$product->product_name}}@endif</td>
                <td class="invoice-num">@if($product->price)\{{number_format($product->price)}}@endif</td>
                <td class="invoice-num">@if($product->count){{$product->count}}</td>@endif
                <td class="invoice-num">@if($product->mutil)\{{number_format($product->mutil)}}@endif</td>
              </tr>
            @endforeach
            <tr>
              <td class="invoice-word" colspan="3">
                <div><div class="invoice-word-lavel">小計&nbsp;(10%対象)</div></td><td class="invoice-num">\{{number_format($data['subtotal'])}}</div>
              </td>
            </tr>
            <tr>
              <td class="invoice-word" colspan="3">
                <div><div class="invoice-word-lavel">消費税&nbsp;(10%)</div></td><td class="invoice-num">\{{number_format($data['tax'])}}</div>
              </td>
            </tr>
            <tr>
              <td class="invoice-word" colspan="3">
                <div><div class="invoice-word-lavel">合計&nbsp;(税込)</div></td><td class="invoice-num">\{{number_format($data['total'])}}</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="invoice-tax">【10%対象額：\{{number_format($data['subtotal'])}}&emsp;10％消費税：\{{number_format($data['tax'])}}】</div>
      <div class="invoice-footer">
        <table class="table table-sm">
          <tr>
            <td class="invoiceFooterLeft-remark">
              <div>備考</div>
              <textarea class="form-control form-control-sm" rows="2"></textarea>
            </td> 
          </tr>
        </table>
      </div>
    </div>
    <div class="form-submit">
      <a href="{{route('index', ['login_id' =>$data['login_id']])}}" class="submit-button button-color-bk">戻る</a>
       <button class="submit-button button-color-pk printStart"><i class="fas fa-print"></i>印刷</button> 
    </div>
</div>
@endsection