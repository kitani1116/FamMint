@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_form.css">

<div id="title_box">
  <h1 id="back_text">New Item</h1>
  <p id="title_text">新しい商品の追加</p>
</div>

<div id="form_box">
  <form action="new_item_conf" method="post">
    {{ csrf_field() }}
    @error('name')
    <p class="error_text">{{$message}}</p>
  @enderror
    <label for="name">商品名:</label>
    <input type="text" id="name" name="name" size="20" value="{{ old('name') }}">

    @error('content')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="content">商品内容(100文字以内):</label>
    <textarea name="content" id="" cols="30" rows="10">{{ old('content') }}</textarea><br>

    @error('price')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="mony">価格:</label>
    <input type="text" id="mony" name="price" value="{{ old('price') }}">

    <div id="button">
      <input type="submit" id="conf" value="確認">
      <a href="./main_toppage">
      <input type="button" id="back" value="戻る">
      </a>
    </div>
  </form>
</div>

@endsection