@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/other_menu.css">

<script>
$(document).ready(function() {
  $(".unsubscrib").click(function() {

    if(confirm("アカウントを削除して本当によろしいですか？")){
    }else{
      return false;
    }
  });
});</script>










@if($errors->hasAny(['money_name', 'rate']))
<script>
$(document).ready(function () {
    const speed = 600;
    let href = "#mony_form";
    let target = $(href == "#" || href == "" ? "html" : href);
    let offset = -250;
    let position = target.offset().top + offset;
    $("body,html").animate({ scrollTop: position }, speed, "swing");
});
</script>
@endif


@if($errors->hasAny(['first_name', 'email', 'pass']))
<script>
$(document).ready(function () {
    const speed = 600;
    let href = "#account";
    let target = $(href == "#" || href == "" ? "html" : href);
    let offset = 280;
    let position = target.offset().top + offset;
    $("body,html").animate({ scrollTop: position }, speed, "swing");
});
</script>
@endif





<div id="title_box">
  <h1 id="back_text">Setting</h1>
  <p id="title_text">設定</p>
</div>

<div id="money">
  <div  class="list_title">
    <h2>通貨設定</h2>
  </div>
  
  <div id="mony_form">
    <form action="./money_conf" method="POST" novalidate>
      {{ csrf_field() }}
      <input type="hidden" name="id" value="{{$walletsList[0] -> id}}">
      @error('money_name')
        <p class="error_text">{{$message}}</p>
      @enderror
      <label for="money_name">通貨名:</label>
      <input type="text" id="money_name" name="money_name" size="20" value="{{$walletsList[0] -> money_name}}">

      @error('rate')
        <p class="error_text">{{$message}}</p>
      @enderror
      <label for="rate">レート(円):</label>
      <input type="text" id="rate" name="rate" size="20" value="{{$walletsList[0] -> rate}}">

      <div class="button">
        <input type="submit" value="変更する">
      </div>
    </form>
  </div>
</div>


<div id="account">
  <div class="list_title">
    <h2>アカウント設定</h2>
  </div>
  <h2 class="sub_title">登録済みの子アカウント</h2>
  <div id="account_list">
    @if($childList == false)
    <div id="emptytext">
      <p>現在登録されている子アカウントはありません。</p>
      <p>下記から新しいアカウントを追加してください。</p>
    </div>
    @else
    <table>
      <tr>
        <th class="name">名前</th>
        <th class="email">メールアドレス</th>
        <th class="mypay">現在の所持{{$walletsList[0] -> money_name}}</th>
        <th class="myyen">円換算</th>
      </tr>
      @foreach($childList as $value)
      <tr>
        <td class="name">{{ $value -> first_name }}</td>
        <td  class="email">{{ $value -> email }}</td>
        <td class="mypay">{{ $value -> balance }}{{$walletsList[0] -> money_name}}</td>
        <td class="myyen">{{ $value -> balance * $walletsList[0] -> rate}}円</td>
        <form action="./child_pass_edit" method="get">
          {{ csrf_field() }}
          <td class="delete">
          <input type="hidden" name="id" value="{{ $value -> id }}">
          <input type="submit" value="PassReset"></td>
        </form>
        <form action="./childdelete" method="POST">
          {{ csrf_field() }}
          <td class="delete"><input type="hidden" name="id" value="{{ $value -> id }}">
          <button class="unsubscrib" type="submit">退会</button></td>
        </form>
      </tr>
      @endforeach
  </table>
  @endif
  </div>
<div id="account">
  <h2 class="sub_title">子アカウントの追加</h2>
  <div id="child_form">
    <form action="./child_account_conf" method="post" novalidate>
      {{ csrf_field() }}

      @error('first_name')
        <p class="error_text">{{$message}}</p>
      @enderror
      <label for="first_name">名:</label>
      <input type="text" id="first_name" name="first_name" size="20" value="{{ old('first_name') }}">
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

      <div class="button">
        <a href="/">
        <input type="submit" value="確認">
        </a>
      </div>
    </form>
  </div>
</div>
  <h2 class="sub_title">退会をご希望の方</h2>
  <div id="unsubscribe">
    <p>退会をご希望の方は下記のボタンより手続きを行ってください。</p>
    <div class="button">
      <a href="./unsubscrib">
        <input type="button" value="退会する">
      </a>
    </div>
  </div>
</div>

@endsection