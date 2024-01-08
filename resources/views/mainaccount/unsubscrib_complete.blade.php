@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/unsubscrib_comp.css">

<script>
  $(document).ready(function() {
    $("#execution").click(function() {
  
      if(confirm("アカウントを削除して本当によろしいですか？")){
      }else{
        return false;
      }
    });
  });</script>

<div id="title_box">
  <h1 id="back_text">Unsubscribe</h1>
  <p id="title_text">退会手続きを実行します</p>
</div>

<div id="comp_text">
  <h2>最終確認</h2>
  <p>退会後、ご登録いただいた「子アカウント」「仕事」「商品」等、</p>
  <p>すべてのデータが破棄され復元することができなくなります。</p>
  <p>また、ご利用いただいております各コンテンツがご利用できなくなります。</p>
  <br>
  <p>下記のボタンより退会手続きが完了しログインページへ移動します。</p>
</div>

<form action="{{ route('unsubscribButton') }}" method="post">
  {{ csrf_field() }}
  <input type="submit" id="execution" value="退会する">
</form>
<a href="./other_menu">
  <input type="button" id="back" value="戻る">
</a>

@endsection