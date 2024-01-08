@extends('Layout.layout')

@section('content')
<link rel="stylesheet" href="../resources/css/complete.css">

<div id="title">
  <h2>送信が完了しました！</h2>
</div>

<p>お問合せありがとうございます。</p>
<p>ご入力頂きましたメールアドレスに送信完了の旨のメールをお送り致しましたのでご確認ください。</p>

<a href="./">
<input type="button" id="back" value="ログイン画面へ戻る">
</a>

@endsection