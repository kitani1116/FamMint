<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../resources/css/layout.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://kit.fontawesome.com/7cb37501fb.js" crossorigin="anonymous"></script>
  <title>Document</title>



</head>
<body>

  <div id="header">
    <a href=@if(session()->get('role') == 0)
              {{"./main_toppage"}}
              @elseif(session()->get('role') == 1)
              {{"./child_toppage"}}
              @else
              {{"./"}}
              @endif id="h-logo"><img src="../public/img/ロゴ(white).png" ></a> 
    <form action="{{ route('logoutclick') }}" method="post">
      {{ csrf_field() }}
      <div id="logout">
        <i class="fa-solid fa-right-from-bracket">
          <input type="submit" value="Logout">
          </i>
      </div>
    </form>
  </div>

  <div id="menu">
    <div id="top">
      <a href="./main_toppage">TOP</a>
    </div>
    <div id="Newjob">
      <a href="./new_job">仕事の追加</a>
    </div>
    <div id="Newitem">
      <a href="./new_item">商品の追加</a>
    </div>
    <div id="othermenu">
      <a href="./other_menu">設定</a>
    </div>
  </div>

  <div id="childmenu">
    <div id="element">
      <div id="top">
        <a href="./child_toppage">TOP</a>
      </div>
      <div id="favorite">
        <a href="./favorite">お気に入り</a>
      </div>
      <div id="history">
        <a href="./history">取引履歴</a>
      </div>
    </div>
    <form action="./search_result" method="get">
      {{ csrf_field() }}
      <div id="search">
          <div id="category">
            <select name="name" id="">
              <option>ご選択ください</option>
              <option>仕事</option>
              <option>商品</option>
            </select>
          </div>
          <div id="search_box">
            <input type="text" name="keyword" placeholder="キーワード">
            <input type="submit" value="検索">
          </div>
      </div>
    </form>
  </div>


  <script>
    $(document).ready(function () {
        var clickCount = 0;
  
        $('.oneclick').click(function () {
            clickCount++;
            if (clickCount >= 2) {
                return false;
            }
        });
    });
  </script>

  <div id="content">
    @yield('content')
  </div>

  <div id="footer">
    <small>Copyright © KITANI SHOU All Rights Reserved.</small>
  </div>
</body>
</html>