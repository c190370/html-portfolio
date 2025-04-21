@extends('template.header')
@section('title','保証書編集')
@section('body')
<div class="content">
  <form method="POST" action="{{route('edit.send', ['login_id' =>$data['login_id']])}}" class="h-adr">
    @csrf
    @foreach($data['warranty'] as $warranty)
      <div class="form form-width-lg">
        <div class="nav"><div class="nav-title">保証書編集({{$warranty->id}})</div></div>
        <div class="form-header">顧客情報</div>
        <div class="form-box box-size-lg box-color-bl">
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">顧客名</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="name" type="text" class="form-control form-control-sm @if($errors->has('name'))form-error @endif" value=@if(old('name'))"{{old('name')}}"@else"{{$warranty->name}}"@endif />
                @if($errors->has('name'))<div class="formRowLavel-error">{{$errors->first('name')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">顧客名フリガナ</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="kana" type="text" class="form-control form-control-sm @if($errors->has('kana'))form-error @endif" value=@if(old('kana'))"{{old('kana')}}"@else"{{$warranty->kana}}"@endif />
              @if($errors->has('kana'))<div class="formRowLavel-error">{{$errors->first('kana')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-tel">
            <div class="formRow-label">
              <div class="formRowLavel-title">電話番号</div><div class="formRowLavel-require">どちらかが必須</div><div class="form-annotation form-alert">※半角数字とハイフンのみ使用可能</div>
            </div>
            <div class="formRow-value">
              <div class="form-caption">固定電話</div>
              <input name="tel_fix" type="text" class="form-control form-control-sm form-size-sm @if($errors->has('tel_fix'))form-error @endif" value=@if(old('tel_fix'))"{{old('tel_fix')}}"@else"{{$warranty->tel_fix}}"@endif />
              <div class="form-caption caption-right">携帯電話</div>
              <input name="tel_mobile" type="text" class="form-control form-control-sm form-size-sm @if($errors->has('tel_mobile'))form-error @endif" value=@if(old('tel_mobile'))"{{old('tel_mobile')}}"@else"{{$warranty->tel_mobile}}"@endif />
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
                <input name="zip" type="text" class="p-postal-code form-control form-control-sm form-size-sm @if($errors->has('zip'))form-error @endif" value=@if(old('zip'))"{{old('zip')}}"@else"{{$warranty->zip}}"@endif />
                <div class="form-caption caption-right">住所</div><span class="p-country-name" style="display:none;">Japan</span>
                <input name="address" type="text" class="p-region p-locality p-street-address form-control form-control-sm form-size-lg @if($errors->has('address'))form-error @endif" value=@if(old('address'))"{{old('address')}}"@else"{{$warranty->address}}"@endif />
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
                      @foreach($data['product'] as $product)
                        <option value="{{$product->name}}" @if(Session::get('product_name')) @if(Session::get('product_name')==$product->name)selected  @endif @elseif(!Session::get('product_maker')) @if($warranty->product_name==$product->name)selected @endif @endif>{{$product->name}}</option>
                      @endforeach
                    </select>
                    @if($errors->has('product_name'))<div class="formRowLavel-error">{{$errors->first('product_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <select name="product_maker" class="form-control form-control-sm @if($errors->has('product_maker'))form-error @endif">
                      @foreach($data['maker'] as $maker)
                        <option value="{{$maker->name}}" @if(Session::get('product_maker')) @if(Session::get('product_maker')==$maker->name)selected  @endif @elseif(!Session::get('product_maker')) @if($warranty->product_maker==$maker->name)selected @endif @endif>{{$maker->name}}</option>
                      @endforeach
                    </select>
                    @if($errors->has('product_maker'))<div class="formRowLavel-error">{{$errors->first('product_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="product_number" type="text" class="form-control form-control-sm form-size-lg @if($errors->has('product_number'))form-error @endif" value=@if(old('product_number'))"{{old('product_number')}}"@else"{{$warranty->product_number}}"@endif />
                    @if($errors->has('product_number'))<div class="formRowLavel-error">{{$errors->first('product_number')}}</div>@endif
                  </div>
                </td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション1</div></div></td>
                <td>
                  <div class="formRow-label">
                    <input name="option1_name" type="text" class="form-control form-control-sm @if($errors->has('option1_name'))form-error @endif" value=@if(old('option1_name'))"{{old('option1_name')}}"@else"{{$warranty->option1_name}}"@endif />
                    @if($errors->has('option1_name'))<div class="formRowLavel-error">{{$errors->first('option1_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option1_maker" type="text" class="form-control form-control-sm @if($errors->has('option1_maker'))form-error @endif" value=@if(old('option1_maker'))"{{old('option1_maker')}}"@else"{{$warranty->option1_maker}}"@endif />
                    @if($errors->has('option1_maker'))<div class="formRowLavel-error">{{$errors->first('option1_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option1_number" type="text" class="form-control form-control-sm @if($errors->has('option1_number'))form-error @endif" value=@if(old('option1_number'))"{{old('option1_number')}}"@else"{{$warranty->option1_number}}"@endif />
                    @if($errors->has('option1_number'))<div class="formRowLavel-error">{{$errors->first('option1_number')}}</div>@endif
                  </div>
                </td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション2</div></div></td>
                <td>
                  <div class="formRow-label">
                    <input name="option2_name" type="text" class="form-control form-control-sm @if($errors->has('option2_name'))form-error @endif" value=@if(old('option1_name'))"{{old('option2_name')}}"@else"{{$warranty->option2_name}}"@endif />
                    @if($errors->has('option2_name'))<div class="formRowLavel-error">{{$errors->first('option2_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option2_maker" type="text" class="form-control form-control-sm @if($errors->has('option2_maker'))form-error @endif" value=@if(old('option2_maker'))"{{old('option2_maker')}}"@else"{{$warranty->option2_maker}}"@endif />
                    @if($errors->has('option2_maker'))<div class="formRowLavel-error">{{$errors->first('option2_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option2_number" type="text" class="form-control form-control-sm @if($errors->has('option2_number'))form-error @endif" value=@if(old('option2_number'))"{{old('option2_number')}}"@else"{{$warranty->option2_number}}"@endif />
                    @if($errors->has('option2_number'))<div class="formRowLavel-error">{{$errors->first('option2_number')}}</div>@endif
                  </div>
                </td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション3</div></div></td>
                <td>
                  <div class="formRow-label">
                    <input name="option3_name" type="text" class="form-control form-control-sm @if($errors->has('option3_name'))form-error @endif" value=@if(old('option3_name'))"{{old('option3_name')}}"@else"{{$warranty->option3_name}}"@endif />
                    @if($errors->has('option3_name'))<div class="formRowLavel-error">{{$errors->first('option3_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option3_maker" type="text" class="form-control form-control-sm @if($errors->has('option3_maker'))form-error @endif" value=@if(old('option3_maker'))"{{old('option3_maker')}}"@else"{{$warranty->option3_maker}}"@endif />
                    @if($errors->has('option3_maker'))<div class="formRowLavel-error">{{$errors->first('option3_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option3_number" type="text" class="form-control form-control-sm @if($errors->has('option3_number'))form-error @endif" value=@if(old('option3_number'))"{{old('option3_number')}}"@else"{{$warranty->option3_number}}"@endif />
                    @if($errors->has('option3_number'))<div class="formRowLavel-error">{{$errors->first('option3_number')}}</div>@endif
                  </div>
                </td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション4</div></div></td>
                <td>
                  <div class="formRow-label">
                    <input name="option4_name" type="text" class="form-control form-control-sm @if($errors->has('option4_name'))form-error @endif" value=@if(old('option4_name'))"{{old('option4_name')}}"@else"{{$warranty->option4_name}}"@endif />
                    @if($errors->has('option4_name'))<div class="formRowLavel-error">{{$errors->first('option4_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option4_maker" type="text" class="form-control form-control-sm @if($errors->has('option4_maker'))form-error @endif" value=@if(old('option4_maker'))"{{old('option4_maker')}}"@else"{{$warranty->option4_maker}}"@endif />
                    @if($errors->has('option4_maker'))<div class="formRowLavel-error">{{$errors->first('option4_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option4_number" type="text" class="form-control form-control-sm @if($errors->has('option4_number'))form-error @endif" value=@if(old('option4_number'))"{{old('option4_number')}}"@else"{{$warranty->option4_number}}"@endif />
                    @if($errors->has('option4_number'))<div class="formRowLavel-error">{{$errors->first('option4_number')}}</div>@endif
                  </div>
                </td>
              </tr>
              <tr>
                <td><div class="formRow-label"><div class="formRowLavel-title">オプション5</div></div></td>
                <td>
                  <div class="formRow-label">
                    <input name="option5_name" type="text" class="form-control form-control-sm @if($errors->has('option5_name'))form-error @endif" value=@if(old('option5_name'))"{{old('option5_name')}}"@else"{{$warranty->option5_name}}"@endif />
                    @if($errors->has('option5_name'))<div class="formRowLavel-error">{{$errors->first('option5_name')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option5_maker" type="text" class="form-control form-control-sm @if($errors->has('option5_maker'))form-error @endif" value=@if(old('option5_maker'))"{{old('option5_maker')}}"@else"{{$warranty->option5_maker}}"@endif />
                    @if($errors->has('option5_maker'))<div class="formRowLavel-error">{{$errors->first('option5_maker')}}</div>@endif
                  </div>
                </td>
                <td>
                  <div class="formRow-label">
                    <input name="option5_number" type="text" class="form-control form-control-sm @if($errors->has('option5_number'))form-error @endif" value=@if(old('option5_number'))"{{old('option5_number')}}"@else"{{$warranty->option5_number}}"@endif />
                    @if($errors->has('option5_number'))<div class="formRowLavel-error">{{$errors->first('option5_number')}}</div>@endif
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="form-line"></div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">購入日</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="date_purchase" type="text" id="date_purchase" class="calendar form-control form-control-sm form-size-sm @if($errors->has('date_purchase'))form-error @endif" value=@if(old('date_purchase'))"{{old('date_purchase')}}"@else"{{$warranty->date_purchase}}"@endif />
              @if($errors->has('date_purchase'))<div class="formRowLavel-error">{{$errors->first('date_purchase')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">メーカー保証開始日</div><div class="formRowLavel-require">必須</div>
            </div>
            <div class="formRow-value">
              <input name="date_start" type="text" id="date_start" class="calendar form-control form-control-sm form-size-sm @if($errors->has('date_start'))form-error @endif" value=@if(old('date_start'))"{{old('date_start')}}"@else"{{$warranty->date_start}}"@endif />
              @if($errors->has('date_start'))<div class="formRowLavel-error">{{$errors->first('date_start')}}</div>@endif
            </div>
          </div>
          <div class="form-row form-size-md">
            <div class="formRow-label">
              <div class="formRowLavel-title">延長保証終了日</div>
            </div>
            <div class="formRow-value">
              <input name="date_end" type="text"  id="date_end" class="calendar form-control form-control-sm form-size-sm @if($errors->has('date_end'))form-error @endif" value=@if(old('date_end'))"{{old('date_end')}}"@else"{{$warranty->date_end}}"@endif />
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
<textarea name="remark" rows="3" class="calendar form-control form-control-sm form-size-lg @if($errors->has('remark'))form-error @endif">@if(old('remark')){{old('remark')}}@else{{$warranty->remark}}@endif</textarea>
              @if($errors->has('remark'))<div class="formRowLavel-error">{{$errors->first('remark')}}</div>@endif
            </div>
          </div>
        </div>
      </div>
      <div class="form-submit">
        <a href="{{route('detail.index', ['login_id' =>$data['login_id']])}}?id={{$warranty->id}}" class="submit-button button-color-bk">戻る</a>
        <button name="action" type="submit" value="edit" class="submit-button button-color-bl">変更する</button>
        <input name="id" type="hidden" value="{{$warranty->id}}" />
      </div>
    @endforeach
  </form>
</div>
@endsection
