@extends('Layout.layout')

@section('content')
<link rel="stylesheet" href="../resources/css/complete.css">

  <div id="title">
    <h2>登録が完了しました！</h2>
  </div>

  <p>ご登録ありがとうございます。</p>
  <p>下記のボタンよりログイン画面へ戻り、ログインしてください。</p>

  <a href="./">
  <input type="button" id="back" value="ログイン画面へ戻る">
  </a>
@endsection