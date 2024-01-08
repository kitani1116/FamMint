<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/7cb37501fb.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../resources/css/login.css">
  <title>Document</title>
</head>
<body>
  
  <div id="content">
    <img class="logo" src="../public/img/ロゴ2.png" alt="">
    <form action="" method="post" novalidate>
    {{ csrf_field() }}


    @if (!empty(session('errorM')))
      <p id="errorM">{{session('errorM')}}</p>
      <br>
  @endif

      <div class="form">
        @error('email')
        <p class="error_text">{{$message}}</p>
        @enderror
        <label for="email">
        <i class="fa-solid fa-envelope"></i></label>
        <input type="email" id="email" name="email" placeholder="メールアドレス" size="35" value="{{ old('email') }}">
      </div>

      <br>

      <div class="form">
        @error('pass')
        <p class="error_text">{{$message}}</p>
        @enderror
        <label for="pass">
        <i class="fa-solid fa-lock"></i></label>
        <input type="password" id="pass" name="pass" placeholder="パスワード" size="35">
      </div>

      <div class="button">
        <input type="submit" id="login" value="Log In">
        <br>
        <a href="./main_signup">
        <input type="button" id="signup" value="Sign Up" >
        </a>
      </div>
    </form>

    <div id="pass_conf">
      <p>または</p>
    </div>

    <div id="contact">
      <p><a href="./passlost">・パスワードをお忘れの方</a></p>
      <p><a href="./contact">・ご不明な点等ございましたらこちらからお問い合わせください。</a></p>
    </div>
  </div>



  <div id="footer">
    <small>Copyright © KITANI SHOU All Rights Reserved.</small>
  </div>
</body>
</html>