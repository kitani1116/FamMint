@extends('Layout.layout')
@section('content')
<link rel="stylesheet" href="../resources/css/passlost.css">





<div id="title">
  <h2>パスワードをお忘れの方</h2>
</div>

<div id="text">
  <p>パスワードの再設定を行います。</p>
  <p>下記に<span>ご登録頂いた</span>「メールアドレス」及び「卒業した小学校」をご入力ください。</p>
</div>
<form action="./passreset" method="post" novalidate >
  {{ csrf_field() }}
  @if (!empty(session('errorM')))
      <p class="error_text">{{session('errorM')}}</p>
      <br>
  @endif
  @error('email')
    <p class="error_text">{{$message}}</p>
  @enderror
  <label for="email">メールアドレス:</label><br>
  <input type="email" id="email" name="email" value="{{ old('email') }}">
  <br>

  @error('primary_school')
    <p class="error_text">{{$message}}</p>
  @enderror
  <label for="primary_school">卒業した小学校:</label><br>
  <input type="text" id="primary_school" name="primary_school" value="{{ old('primary_school') }}">
  <br>

  <div id="button">
    <input type="submit" id="conf" value="再設定をする">
    <a href="./">
    <input type="button" id="back" value="戻る">
    </a>
  </div>

</form>

@endsection