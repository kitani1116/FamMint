@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_form.css">

<div id="title_box">
  <h1 id="back_text">New Job</h1>
  <p id="title_text">新しい仕事の追加</p>
</div>

<div id="form_box">
  <form action="new_job_conf" method="post">
    {{ csrf_field() }}
    @error('name')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="name">仕事名:</label>
    <input type="text" id="name" name="name" size="20" value="{{ old('name') }}">
    
    @error('content')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="content">仕事内容(100文字以内):</label>
    <textarea name="content" id="" cols="30" rows="10">{{ old('content') }}</textarea><br>

    @error('reward')
      <p class="error_text">{{$message}}</p>
    @enderror
    <label for="mony">報酬額:</label>
    <input type="text" id="mony" name="reward" value="{{ old('reward') }}">

    <div id="button">
      <input type="submit" id="conf" value="確認">
      <a href="./main_toppage">
      <input type="button" id="back" value="戻る">
      </a>
    </div>
  </form>
</div>

@endsection