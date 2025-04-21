@extends('template.header')
@section('title','保証書新規登録')
@section('body')
<div class="content">
  <form method="POST" action="{{route('copy.confirm', ['login_id' =>$data['login_id']])}}" class="h-adr">
    @foreach($data['warranty'] as $warranty)
      @csrf
      <div class="form form-width-lg">
        <div class="nav"><div class="nav-title">保証書新規登録</div></div>
        <div class="form-header">顧客情報</div>
        <div class="form-box box-size-lg box-color-bl">
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">顧客名</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="name" type="text" class="form-control form-control-sm @if($errors->has('name'))form-error @endif" value=@if(old('name'))"{{old('name')}}"@elseif(Session::get('name')){{Session::get('name')}}@else"{{$warranty->name}}"@endif />
              @if($errors->has('name'))<div class="formRowLavel-error">{{$errors->first('name')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">顧客名フリガナ</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="kana" type="text" class="form-control form-control-sm @if($errors->has('kana'))form-error @endif" value=@if(old('kana'))"{{old('kana')}}"@elseif(Session::get('kana')){{Session::get('kana')}}@else"{{$warranty->kana}}"@endif />
              @if($errors->has('kana'))<div class="formRowLavel-error">{{$errors->first('kana')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-tel">
            <div class="formRow-label">
              <div class="formRowLavel-title">電話番号</div><div class="formRowLavel-require">どちらかが必須</div><div class="form-annotation form-alert">※半角数字とハイフンのみ使用可能</div>
            </div>
            <div class="formRow-value">
              <div class="form-caption">固定電話</div>
              <input name="tel_fix" type="text" class="form-control form-control-sm form-size-sm @if($errors->has('tel_fix'))form-error @endif" value=@if(old('tel_fix'))"{{old('tel_fix')}}"@elseif(Session::get('tel_fix')){{Session::get('tel_fix')}}@else"{{$warranty->tel_fix}}"@endif />
              <div class="form-caption caption-right">携帯電話</div>
              <input name="tel_mobile" type="text" class="form-control form-control-sm form-size-sm @if($errors->has('tel_mobile'))form-error @endif" value=@if(old('tel_mobile'))"{{old('tel_mobile')}}"@elseif(Session::get('tel_mobile')){{Session::get('tel_mobile')}}@else"{{$warranty->tel_mobile}}"@endif />
              @if($errors->has('tel_fix')||$errors->has('tel_mobile'))
                <div class="formRowLavel-error">{{$errors->first('tel_fix')}}{{$errors->first('tel_mobile')}}</div>
              @endif
            </div>
          </div>
          <div class="form-line"></div>
          <div class="form-row form-size-max">
            <div class="formRow-label">
              <div class="formRowLavel-title">住所</div><div class="formRowLavel-require">必須</div><div class="form-annotation form-alert">※郵便番号はハイフンなし・半角数字で入力</div>
            </div>
            <div class="formRow-value">
                <div class="form-caption">郵便番号</div>
                <input name="zip" type="text" class="p-postal-code form-control form-control-sm form-size-sm @if($errors->has('zip'))form-error @endif" value=@if(old('zip'))"{{old('zip')}}"@elseif(Session::get('zip')){{Session::get('zip')}}@else"{{$warranty->zip}}"@endif />
                <div class="form-caption caption-right">住所</div><span class="p-country-name" style="display:none;">Japan</span>
                <input name="address" type="text" class="p-region p-locality p-street-address form-control form-control-sm form-size-lg @if($errors->has('address'))form-error @endif" value=@if(old('address'))"{{old('address')}}"@elseif(Session::get('address')){{Session::get('address')}}@else"{{$warranty->address}}"@endif />
              @if($errors->has('zip')||$errors->has('address'))
                <div class="formRowLavel-error">{{$errors->first('zip')}}{{$errors->first('address')}}</div>
              @endif
            </div>
          </div>
        </div>
        <div class="form-header">商品情報</div>
        <div class="form-box box-size-lg box-color-gr">
          <table class="table table-sm">
            <thead><tr><th width="150"></th><th>商品名</th><th>メーカー名</th><th>型番</th></tr></thead>
            <tbody>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">商品</div><div class="formRowLavel-require">必須</div></div></td>
                <td>
                  <div class="formRow-label">
                    <select name="product_name" class="form-control form-control-sm @if($errors->has('product_name'))form-error @endif">
                      <option value="" disabled @if(!Session::get('product_name'))selected @endif class="hide">商品を選択</option>
                      @foreach($data['product'] as $product)
                        <option value="{{$product->name}}" @if(Session::get('product_name')) @if(Session::get('product_name')==$product->name)selected @endif @endif>{{$product->name}}</option>
                      @endforeach
                    </select>
                    @if($errors->has('product_name'))<div class="formRowLavel-error">{{$errors->first('product_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <select name="product_maker" class="form-control form-control-sm @if($errors->has('product_maker'))form-error @endif">
                      <option value="" disabled @if(!Session::get('product_maker'))selected @endif class="hide">メーカーを選択</option>
                      @foreach($data['maker'] as $maker)
                        <option value="{{$maker->name}}" @if(Session::get('product_maker')) @if(Session::get('product_maker')==$maker->name)selected @endif @endif>{{$maker->name}}</option>
                      @endforeach
                    </select>
                    @if($errors->has('product_maker'))<div class="formRowLavel-error">{{$errors->first('product_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="product_number" type="text" class="form-control form-control-sm @if($errors->has('product_number'))form-error @endif" value="@if(Session::get('product_number')){{Session::get('product_number')}}@else{{old('product_number')}}@endif" />
                    @if($errors->has('product_number'))<div class="formRowLavel-error">{{$errors->first('product_number')}}</div>@endif
                  </div>
                </td>
              </tr>
              @for($i=1;$i<=5;$i++)
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション{{$i}}</div></div></td>
                <td>
                  <div class="formRow-label">
                    <input name="option{{$i}}_name" type="text" class="form-control form-control-sm @if($errors->has('option'.$i.'_name'))form-error @endif" value="@if(Session::get('option'.$i.'_name')){{Session::get('option'.$i.'_name')}}@else{{old('option'.$i.'_name')}}@endif" />
                    @if($errors->has('option'.$i.'_name'))<div class="formRowLavel-error">{{$errors->first('option'.$i.'_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option{{$i}}_maker" type="text" class="form-control form-control-sm @if($errors->has('option'.$i.'_maker'))form-error @endif" value="@if(Session::get('option'.$i.'_maker')){{Session::get('option'.$i.'_maker')}}@else{{old('option'.$i.'_maker')}}@endif" />
                    @if($errors->has('option'.$i.'_maker'))<div class="formRowLavel-error">{{$errors->first('option'.$i.'i_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option{{$i}}_number" type="text" class="form-control form-control-sm @if($errors->has('option'.$i.'_number'))form-error @endif" value="@if(Session::get('option'.$i.'_number')){{Session::get('option'.$i.'_number')}}@else{{old('option'.$i.'_number')}}@endif" />
                    @if($errors->has('option'.$i.'_number'))<div class="formRowLavel-error">{{$errors->first('option'.$i.'_number')}}</div>@endif
                  </div>
                </td>
              </tr>
              @endfor
            </tbody>
          </table>
          <div class="form-line"></div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">購入日</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="date_purchase" type="text" id="date_purchase" class="calendar form-control form-control-sm form-size-sm @if($errors->has('date_purchase'))form-error @endif" value="@if(Session::get('date_purchase')){{Session::get('date_purchase')}}@else{{old('date_purchase')}}@endif" />
              @if($errors->has('date_purchase'))<div class="formRowLavel-error">{{$errors->first('date_purchase')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">メーカー保証開始日</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="date_start" type="text" id="date_start" class="calendar form-control form-control-sm form-size-sm @if($errors->has('date_start'))form-error @endif" value="@if(Session::get('date_start')){{Session::get('date_start')}}@else{{old('date_start')}}@endif" />
              @if($errors->has('date_start'))<div class="formRowLavel-error">{{$errors->first('date_start')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">延長保証終了日</div>
            </div>
            <div class="formRow-value">
              <input name="date_end" type="text"  id="date_end" class="calendar form-control form-control-sm form-size-sm @if($errors->has('date_end'))form-error @endif" value="@if(Session::get('date_end')){{Session::get('date_end')}}@else{{old('date_end')}}@endif" />
              @if($errors->has('date_end'))<div class="formRowLavel-error">{{$errors->first('date_end')}}</div>@endif
            </div>
          </div>
        </div>
        <div class="form-header">その他</div>
        <div class="form-box box-color-yr">
          <div class="form-row form-size-max">
            <div class="formRow-label">
              <div class="formRowLavel-title">備考</div>
            </div>
            <div class="formRow-value">
<textarea name="remark" rows="3" class="calendar form-control form-control-sm form-size-lg @if($errors->has('remark'))form-error @endif">@if(Session::get('remark')){{Session::get('remark')}}@else{{old('remark')}}@endif</textarea>
              @if($errors->has('remark'))<div class="formRowLavel-error">{{$errors->first('remark')}}</div>@endif
            </div>
          </div>
        </div>
      </div>
      <div class="form-submit">
        <a href="{{route('index', ['login_id' =>$data['login_id']])}}" class="submit-button button-color-bk">戻る</a>
        <button name="action" type="submit" value="regist" class="submit-button button-color-bl">確認画面へ</button>
      </div>
    @endforeach
  </form>
</div>
@endsection
