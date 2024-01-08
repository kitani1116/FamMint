@extends('Layout.layout')

@section('content')
<link rel="stylesheet" href="../resources/css/conf.css">

<form action="./main_complete" method="post"> 
  {{ csrf_field() }}
  <div id="title">
    <h2>入力内容確認</h2>
    <br>
  </div>
  <div id="name">
    <div>
      <h3>姓:</h3>
      <input type="text" id="last_name" name="last_name" size="20" value="{{$inputs['last_name']}}" readonly>
    </div>
    <div>
      <h3>名:</h3>
      <input type="text" id="first_name" name="first_name" size="20" value="{{$inputs['first_name']}}" readonly>
    </div>
  </div>
  <br>

  <div class="input_content">
    <h3>メールアドレス</h3>
    <input type="email" id="email" name="email" value="{{$inputs['email']}}" readonly>
    <br>
  </div>

  <div class="input_content">
    <h3>パスワード</h3>
    <input type="password" id="pass" name="pass" value="{{$inputs['pass']}}" readonly>
    <br>
  </div>

  <div class="input_content">
    <h3>卒業した小学校</h3>
    <input type="text" id="primary_school" name="primary_school" value="{{$inputs['primary_school']}}" readonly>
    <br>
  </div>

  <div id="button">
    <input class="oneclick" type="submit" id="entry" value="登録する">
    <input type="submit" id="edit" name="修正する" value="修正する">
  </div>
</form>

@endsection