@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/new_data_form.css">

<div id="title_box">
  <h1 id="back_text">PassReset</h1>
  <p id="title_text">パスワードリセット</p>
</div>

<div id="form_box">
  <form action="child_pass_comp" method="post">
    {{ csrf_field() }}
    @error('pass')
      <p class="error_text">{{$message}}</p>
    @enderror
    <input type="hidden" name="id" value="{{$input['id']}}">
    <label for="pass">新しいパスワード(4～15文字の英数字):</label><br>
    <input type="password" id="pass" name="pass">
    <br>
    <label for="pass2">パスワード(確認):</label><br>
    <input type="password" id="pass2" name="pass_confirmation">

    <div id="button">
      <input type="submit" id="conf" value="確認">
      <a href="./other_menu">
      <input type="button" id="back" value="戻る">
      </a>
    </div>
  </form>
</div>

@endsection