@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/child_sidepage.css">


<div id="title_box">
  <h1 id="back_text">favorite</h1>
  <p id="title_text">お気に入り</p>
</div>

<div class="list_title">
  <h2>お気に入りの仕事</h2>
</div>
<div class="list">
  @if($FJobList == false)
  <div id="emptytext">
    <p>お気に入り登録されている仕事がありません。</p>
    <p>トップページへ戻りお気に入り登録をしてください。</p>
  </div>
  @else
  <table>
    <tr>
      <th class="posting">掲載状況</th>
      <th class="name">仕事名</th>
      <th class="content">内容</th>
      <th class="mony">報酬</th>
      <th class="adding_date">追加日時</th>
      <th class="delete">削除</th>
    </tr>

    @foreach($FJobList as $value)
    <tr>
      <td class="posting">
        @if ($value -> DeleteRole == 0)
          掲載中
        @else
          非掲載
        @endif</td>
      <td class="name">{{ $value -> name }}</td>
      <td class="content">{{ $value -> content }}</td>
      <td class="mony">{{ $value -> reward }}{{$walletName -> money_name}}</td>
      <td class="adding_date">{{ $value -> created_at }}</td>
      <form action="./favoriteJobDelete" method="get">
        {{ csrf_field() }}
        <td class="delete"><input type="hidden" name="id" value="{{ $value -> id }}">
          <input type="submit" value="削除"></td>
      </form>
    </tr>
    @endforeach
  </table>
  @endif
</div>



<div class="list_title">
  <h2>お気に入りの商品</h2>
</div>
<div class="list">
  @if($FItemList == false)
  <div id="emptytext">
    <p>現在表示できる商品がありません。</p>
    <p>新しい商品が追加されるまでお待ちください。</p>
  </div>
  @else
  <table>
    <tr>
      <th class="posting">掲載状況</th>
      <th class="name">商品名</th>
      <th class="content">内容</th>
      <th class="mony">価格</th>
      <th class="adding_date">追加日時</th>
      <th class="delete">削除</th>
    </tr>
    

    @foreach($FItemList as $value)
    
    <tr>
      <td class="posting">
        @if ($value -> DeleteRole == 0)
          掲載中
        @else
          非掲載
        @endif</td>
      <td class="name">{{ $value -> name }}</td>
      <td class="content">{{ $value -> content }}</td>
      <td class="mony">{{ $value -> price }}{{$walletName -> money_name}}</td>
      <td class="adding_date">{{ $value -> created_at }}</td>
      <form action="./favoriteItemDelete" method="get">
        {{ csrf_field() }}
        <td class="delete"><input type="hidden" name="id" value="{{ $value -> id }}">
        <input type="submit" value="削除"></td>
      </form>
    </tr>
    @endforeach
  </table>
  @endif
</div>



@endsection