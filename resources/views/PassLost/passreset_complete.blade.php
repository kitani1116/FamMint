@extends('Layout.layout')
@section('content')
<link rel="stylesheet" href="../resources/css/complete.css">


  <div id="title">
    <h2>パスワードの再設定が完了しました。</h2>
  </div>

  <p class="passlost">パスワードの再設定が完了しました。</p>
  <p class="passlost">下記のボタンよりログイン画面へ戻りログインしてください。</p>

  <a href="./">
  <input type="button" id="back" value="ログイン画面へ戻る">
  </a>

  @endsection