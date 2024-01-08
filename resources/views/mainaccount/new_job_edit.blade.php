@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_form.css">

<div id="title_box">
  <h1 id="back_text">Job Edit</h1>
  <p id="title_text">仕事の編集</p>
</div>

<div id="form_box">
  <form action="./job_update" method="post">
    {{ csrf_field() }}
    <input type="hidden"name="id" value="{{$job[0] -> id}}">
    @error('name')
    <p class="error_text">{{$message}}</p>
  @enderror
    <label for="name">商品名:</label>
    <input type="text" id="name" name="name" size="20" value="{{$job[0] -> name}}">

    @error('content')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="content">商品内容(100文字以内):</label>
    <textarea name="content" id="" cols="30" rows="10" >{{$job[0] -> content}}</textarea><br>

    @error('reward')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="mony">価格:</label>
    <input type="text" id="mony" name="reward" value="{{$job[0] -> reward}}">

    <div id="button">
      <input type="submit" id="conf" value="確認">
      <a href="./main_toppage">
      <input type="button" id="back" value="戻る">
      </a>
    </div>
  </form>
</div>

@endsection