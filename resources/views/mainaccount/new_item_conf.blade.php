@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_conf.css">

<div id="title_box">
  <h1 id="back_text">Confirmation</h1>
  <p id="title_text">追加内容の確認</p>
</div>

<div id="form_box">
  <form action="./new_item_complete" method="post">
    {{ csrf_field() }}
    <div class="input_content">
      <p>商品名：</p>
      <input type="text" id="name" name="name" size="20" value="{{$inputs['name']}}" readonly>
      <br>
    </div>
  
    <div class="input_content">
      <p>商品内容：</p>
      <textarea name="content" id="" cols="30" rows="10" readonly>{{$inputs['content']}}</textarea>
      <br>
    </div>
  
    <div class="input_content">
      <p>価格：</p>
      <input type="text" id="mony" name="price" value="{{$inputs['price']}}" readonly>
      <br>
    </div>

  
    <div id="button">
      <input  class="oneclick" type="submit" id="entry" value="追加する">
      <input type="submit" id="edit" name="修正する" value="修正する">
    </div>
  
  </form>
</div>

@endsection