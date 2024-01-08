@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_conf.css">

<div id="title_box">
  <h1 id="back_text">Confirmation</h1>
  <p id="title_text">通貨変更内容の確認</p>
</div>

<div id="form_box">
  <form action="./money_comp" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$inputs['id']}}">
    <div class="input_content">
      <p>通貨名：</p>
      <input type="text" id="money_name" name="money_name" size="20" value="{{$inputs['money_name']}}" readonly>
      <br>
    </div>
  
    <div class="input_content">
      <p>レート(円)：</p>
      <input type="text" id="rate" name="rate" size="20" value="{{$inputs['rate']}}" readonly>
      <br>
    </div>
  
    <div id="button">
      <input type="submit" id="entry" value="確定">
      <a href="./other_menu">
      <input type="button" id="edit" value="戻る">
      </a>
    </div>
  </form>
</div>

@endsection