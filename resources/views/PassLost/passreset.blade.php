@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/sign_up.css">

<div id="title">
  <h2>Password Reset</h2>
</div>

<div id="text">
  <p>新しいパスワードをご入力ください。</p>
</div>

<div id="form">
  <form action="./passreset_complete" method="post" novalidate>
    {{ csrf_field() }}

    @error('pass')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="pass">パスワード(4～15文字の英数字):</label><br>
    <input type="password" id="pass" name="pass">
    <br>
    <label for="pass2">パスワード(確認):</label><br>
    <input type="password" id="pass2" name="pass_confirmation">

    <br>

    <div id="button">
      <input type="submit" id="conf" value="変更する">
      <a href="./">
      <input type="button" id="back" value="やめる">
      </a>
    </div>
    


  </form>
</div>
@endsection