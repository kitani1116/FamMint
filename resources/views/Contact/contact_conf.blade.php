@extends('Layout.layout')
@section('content')
<link rel="stylesheet" href="../resources/css/conf.css">

<form action="./contact_complete" method="post">
  {{ csrf_field() }}
  <div id="title">
    <h2>入力内容確認</h2>
    <br>
  </div>

  <div class="input_content">
    <p>名前</p>
    <input type="text" id="fullname" name="name" size="20" value="{{$inputs['name']}}" readonly>
    <br>
  </div>

  <div class="input_content">
    <p>メールアドレス</p>
    <input type="text" id="email" name="email" size="20" value="{{$inputs['email']}}" readonly>
    <br>
  </div>

  <div class="input_content">
    <p>お問い合わせ種類</p>
    <input type="text" id="type" name="type" size="20" value="{{$inputs['type']}}" readonly>
    <br>
  </div>

  <div class="input_content">
    <p>お問い合わせ内容</p>
    <textarea name="message" id="message" cols="30" rows="10" readonly>{{$inputs['message']}}</textarea>
    <br>
  </div>

  <div id="button">
    <input type="submit" id="entry" value="送信する">
    <input type="submit" id="edit" name="修正する" value="修正する">
  </div>

</form>

@endsection