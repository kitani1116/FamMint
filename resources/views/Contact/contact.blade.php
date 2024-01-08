@extends('Layout.layout')
@section('content')


<link rel="stylesheet" href="../resources/css/contact.css">

<div id="title">
  <h2>お問い合わせ</h2>
</div>

<form action="./contact_conf" method="post">
  {{ csrf_field() }}
  @error('name')
    <p class="error_text">{{$message}}</p>
  @enderror
  <label for="name">お名前:</label><br>
  <input type="text" id="name" name="name" value="{{ old('name') }}">
  <br>

  @error('email')
    <p class="error_text">{{$message}}</p>
  @enderror
  <label for="email">メールアドレス:</label><br>
  <input type="email" id="email" name="email" value="{{ old('email') }}">
  <br>

  @error('type')
    <p class="error_text">{{$message}}</p>
  @enderror
  <label for="type">問い合わせ種類:</label><br>
  <select id="type" name="type">
    <option id="select">ご選択ください</option>
    <option value="ご利用方法について" {{ old('type') == 'ご利用方法について' ? 'selected' : '' }}>ご利用方法について</option>
    <option value="パスワードを忘れてしまった" {{ old('type') == 'パスワードを忘れてしまった' ? 'selected' : '' }}>パスワードを忘れてしまった</option>
    <option value="ご意見・ご要望" {{ old('type') == 'ご意見・ご要望' ? 'selected' : '' }}>ご意見・ご要望</option>
    <option value="その他" {{ old('type') == 'その他' ? 'selected' : '' }}>その他</option>
  </select>
  <input type="text" id="other" name="other" placeholder="ご入力ください。">
  <br>

  @error('message')
    <p class="error_text">{{$message}}</p>
  @enderror
  <label for="message">お問い合わせ内容:</label><br>
  <textarea name="message" id="message" >{{ old('message') }}</textarea>

  <div id="button">
    <input type="submit" id="conf" value="確認">
    <a href="./">
    <input type="button" id="back" value="戻る">
    </a>
  </div>

</form>

<script>
$('#type').on('change', function (){
  $("#select").hide();
  if($('#type').val() == 'その他'){
    $("#other").show();
  }else{
    $("#other").hide();
  }
});
</script>

@endsection