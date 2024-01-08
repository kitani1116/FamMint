@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_form.css">


<div id="title_box">
  <h1 id="back_text">Unsubscribe</h1>
  <p id="title_text">退会フォーム</p>
</div>

<div id="form_box">
  @if(session('errorM') != NULL)
    <p class="error_text">{{ session('errorM') }}</p>
  @endif
  <form action="./unsubscrib_complete" method="post" novalidate>
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ session() -> get('id') }}">
    @error('email')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="email">メールアドレス:</label><br>
    <input type="email" id="email" name="email">
  <br>
  @error('pass')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="pass">パスワード(4～15文字の英数字):</label><br>
    <input type="password" id="pass" name="pass">

    <div id="button">
      <input type="submit" id="conf" value="確認">
      <a href="./main_toppage">
      <input type="button" id="back" value="戻る">
      </a>
    </div>
  </form>
</div>

@endsection