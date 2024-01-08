@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_comp.css">

<div id="title_box">
  <h1 id="back_text">Complete</h1>
  <p id="title_text">仕事の追加が完了しました！</p>
</div>

<div id="comp_text">
  <p>お仕事の追加が正常に完了致しました。</p>
  <p>下記のボタンよりトップページへ戻り追加内容をご確認ください。</p>
</div>

<a href="./main_toppage">
  <input type="button" id="back" value="トップページへ戻る">
</a>



@endsection