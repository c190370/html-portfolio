@extends('template.header')
@section('title','請求書')
@section('body')
<div class="content">
  <form method="POST" action="{{route('invoice.edit.send', ['login_id' =>$data['login_id']])}}">
    @csrf
    <div class="invoice">
      <table class="table table-bordered table-sm">
        <tr><th width="">品名</th><th width="120">単価(\)</th></tr>
        <?php $i=0; ?>
          @foreach($data['product'] as $product)
            <tr>
              <td>
                <span>{{$product->name}}</span>
                @if($errors->has('price.'.$i))<div class="formRowLavel-error">{{$errors->first('price.'.$i)}}</div>@endif
              </td>
              <td>
                <input type="text" name="price[]" class="form-control form-control-sm @if($errors->has('price.'.$i))form-error @endif" value=@if(old('price.'.$i))"{{old('price.'.$i)}}" @else"{{$product->price}}"@endif />
                <input type="hidden" name="name[]" value="{{$product->name}}" />
              </td>
            </tr>
            <?php $i++ ?>
          @endforeach
      </table>
    </div>
    <div class="form-submit">
      <a href="{{route('invoice.index', ['login_id' =>$data['login_id']])}}" class="submit-button button-color-bk">戻る</a>
      <button name="action" type="submit" value="edit" class="submit-button button-color-bl">変更する</button>
    </div>
  </form>
</div>
@endsection