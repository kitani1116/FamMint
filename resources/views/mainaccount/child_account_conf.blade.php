@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_conf.css">


<div id="title_box">
  <h1 id="back_text">Confirmation</h1>
  <p id="title_text">子アカウントの追加内容</p>
</div>

<div id="form_box">
  <form action="./child_account_comp" method="post">
    {{ csrf_field() }}
    <div class="input_content">
      <p>名</p>
      <input type="text" id="first_name" name="first_name" size="20" value="{{$inputs['first_name']}}" readonly>
      <br>
    </div>
    
    <div class="input_content">
      <p>メールアドレス</p>
      <input type="email" id="email" name="email" value="{{$inputs['email']}}" readonly>
      <br>
    </div>
    
    <div class="input_content">
      <p>パスワード</p>
      <input type="password" id="pass" name="pass" value="{{$inputs['pass']}}" readonly>
      <br>
    </div>
    
  
    <div id="button">
      <input  class="oneclick" type="submit" id="entry" value="登録する">
      <a href="./other_menu">
        <input type="button" id="edit" value="戻る">
      </a>
    </div>
  </form>
</div>

@endsection