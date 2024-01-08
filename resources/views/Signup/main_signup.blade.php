@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/sign_up.css">
<div id="title">
  <h2>Sign Up</h2>
</div>

<div id="form">
  <form action="./main_conf" method="post" novalidate>
    {{ csrf_field() }}

    
    
    <div id="name_error">
      <div id="sei">
        @error('last_name')
          <p class="error_text">{{$message}}</p>
        @enderror
      </div>
      <div id="mei">
        @error('first_name')
          <p class="error_text">{{$message}}</p>
        @enderror
      </div>
    </div>
    <div id="name">
      <div>
        <label for="last_name">姓:</label>
        <input type="text" id="last_name" name="last_name" size="20" value="{{ old('last_name') }}">
      </div>
      <div>
        <label for="first_name">名:</label>
        <input type="text" id="first_name" name="first_name" size="20" value="{{ old('first_name') }}">
      </div>
    </div>

    <br>

    @error('email')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="email">メールアドレス:</label><br>
    <input type="email" id="email" name="email" value="{{ old('email') }}">

    <br>

    @error('pass')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="pass">パスワード(4～15文字の英数字):</label><br>
    <input type="password" id="pass" name="pass">
    <br>
    <label for="pass2">パスワード(確認):</label><br>
    <input type="password" id="pass2" name="pass_confirmation">

    <br>

    @error('primary_school')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="primary_school">卒業した小学校(例. なごやしょうがっこう):</label><br>
    <input type="text" id="primary_school" name="primary_school" value="{{ old('primary_school') }}">
    
    <br>

    <div id="button">
      <input type="submit" id="conf" value="確認">
      <a href="./">
      <input type="button" id="back" value="戻る">
      </a>
    </div>
    


  </form>
</div>
@endsection