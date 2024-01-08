@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/toppage.css">



@if($_SERVER['QUERY_STRING'] == 'id=ItemC')
<script>
$(document).ready(function () {
    const speed = 300;
    let href = "#ItemC";
    let target = $(href == "#" || href == "" ? "html" : href);
    let offset = -100;
    let position = target.offset().top + offset;
    $("body,html").animate({ scrollTop: position }, speed, "swing");
});
</script>
@elseif($_SERVER['QUERY_STRING'] == 'id=JobC')
<script>
$(document).ready(function () {
    const speed = 300;
    let href = "#JobC";
    let target = $(href == "#" || href == "" ? "html" : href);
    let offset = -100;
    let position = target.offset().top + offset;
    $("body,html").animate({ scrollTop: position }, speed, "swing");
});
</script>
@elseif($_SERVER['QUERY_STRING'] == 'id=Item')
<script>
$(document).ready(function () {
    const speed = 300;
    let href = "#Item";
    let target = $(href == "#" || href == "" ? "html" : href);
    let offset = -100;
    let position = target.offset().top + offset;
    $("body,html").animate({ scrollTop: position }, speed, "swing");
});
</script>
@elseif($_SERVER['QUERY_STRING'] == 'id=Job')
<script>
$(document).ready(function () {
    const speed = 300;
    let href = "#Job";
    let target = $(href == "#" || href == "" ? "html" : href);
    let offset = -100;
    let position = target.offset().top + offset;
    $("body,html").animate({ scrollTop: position }, speed, "swing");
});
</script>
@endif 







<div id="JobC" class="list_title">
  <h2>仕事完了報告</h2>
</div>
@if($CompJList == false)
  <div class="emptytext">
    <p>現在表示できる仕事完了報告はありません。</p>
    <p>完了報告をお待ち下さい。</p>
  </div>
@else
<div class="list">
  <table>
    <tr>
      <th class="time">日時</th>
      <th class="comp_name">仕事名</th>
      <th class="mony">報酬</th>
      <th class="yen">円換算</th>
      <th class="child_user">依頼者</th>
      <th class="button">支払う</th>
      <th class="delete">削除</th>
    </tr>
    @foreach($CompJList as $value)
    <tr>
      <td class="time">{{ $value -> created_at }}</td>
      <td  class="comp_name">{{ $value -> name }}</td>
      <td class="mony">{{ $value -> reward }}{{$walletName -> money_name}}</td>
      <td class="yen">{{ $value -> reward * $walletsList[0] -> rate}}円</td>
      <td class="child_user">{{ $value -> first_name }}</td>
      <form action="./CompJobPay" method="post">
        {{ csrf_field() }}
        <td class="button">
        <input type="hidden" name="id" value="{{ $value -> id }}">
        <input class="oneclick" type="submit" value="支払う"></td>
      </form>
      <form action="./CompJobdelete" method="POST">
        {{ csrf_field() }}
        <td class="delete"><input type="hidden" name="id" value="{{ $value -> id }}">
        <button type="submit">削除</button></td>
      </form>
    </tr>
    @endforeach
  </table>
</div>
@endif

<div id="ItemC" class="list_title">
  <h2>商品購入依頼</h2>
</div>
@if($CompIList == false)
  <div class="emptytext">
    <p>現在表示できる商品購入依頼はありません。</p>
    <p>購入依頼をお待ちください。</p>
  </div>
  @else
<div class="list">
  <table>
    <tr>
      <th class="time">日時</th>
      <th class="comp_name">商品名</th>
      <th class="mony">価格</th>
      <th class="yen">円換算</th>
      <th class="child_user">依頼者</th>
      <th class="button">承諾</th>
      <th class="delete">拒否</th>
    </tr>

    @foreach($CompIList as $value)
    <tr>
      <td class="time">{{ $value -> created_at }}</td>
      <td class="comp_name">{{ $value -> name }}</th>
      <td class="mony">{{ $value -> price }}{{$walletName -> money_name}}</td>
      <td class="yen">{{ $value -> price * $walletsList[0] -> rate}}円</td>
      <td class="child_user">{{ $value -> first_name }}</td>
      <form action="./Compitempay" method="post">
        {{ csrf_field() }}
        <td class="button">
        <input type="hidden" name="id" value="{{ $value -> id }}">
        <input class="oneclick" type="submit" value="承諾"></td>
      </form>
      <form action="./CompItemdelete" method="POST">
        {{ csrf_field() }}
        <td class="delete"><input type="hidden" name="id" value="{{ $value -> id }}">
        <button type="submit">拒否</button></td>
      </form>
    </tr>
    @endforeach
  </table>
</div>
@endif

<div id="Job" class="list_title">
  <h2>掲載中の仕事</h2>
</div>
<div class="list">
  @if($JobList == false)
  <div class="emptytext">
    <p>現在表示できる仕事がありません。</p>
    <p><a href="./new_job">仕事の追加</a>ページから仕事を追加してください。</p>
  </div>
  @else
  <table>
    <tr>
      <th class="posting_name">仕事名</th>
      <th class="detail">仕事内容</th>
      <th class="mony">報酬</th>
      <th class="yen">円換算</th>
      <th class="button">編集</th>
      <th class="delete">削除</th>
    </tr>
      @foreach($JobList as $value)
      <tr>
        <td class="posting_name">{{ $value -> name }}</td>
        <td class="detail">{{ $value -> content }}</th>
        <td class="mony">{{ $value -> reward }}{{$walletName -> money_name}}</td>
        <td class="yen">{{ $value -> reward * $walletsList[0] -> rate}}円</td>
        <form action="./new_job_edit" method="get">
          {{ csrf_field() }}
          <td class="button">
          <input type="hidden" name="id" value="{{ $value -> id }}">
          <input type="submit" value="編集"></td>
        </form>
        <form action="{{ route('JobDclick') }}" method="POST">
          {{ csrf_field() }}
          <td class="delete"><input type="hidden" name="id" value="{{ $value -> id }}">
          <button type="submit">削除</button></td>
        </form>
      </tr>
      @endforeach
  </table>
  @endif
</div>

<div id="Item" class="list_title">
  <h2>掲載中の商品</h2>
</div>
<div class="list">
  @if($ItemList == false)
  <div class="emptytext">
    <p>現在表示できる商品がありません。</p>
    <p><a href="./new_item">商品の追加</a>ページから仕事を追加してください。</p>
  </div>
  @else
  <table>
    <tr>
      <th class="posting_name">商品名</th>
      <th class="detail">商品内容</th>
      <th class="mony">価格</th>
      <th class="yen">円換算</th>
      <th class="button">編集</th>
      <th class="delete">削除</th>
    </tr>

    @foreach($ItemList as $value)
    <tr>
      <td class="posting_name">{{ $value -> name }}</td>
      <td class="detail">{{ $value -> content }}</th>
      <td class="mony">{{ $value -> price }}{{$walletName -> money_name}}</td>
      <td class="yen">{{ $value -> price * $walletsList[0] -> rate}}円</td>
      <form action="./new_item_edit" method="get">
        {{ csrf_field() }}
        <td class="button">
        <input type="hidden" name="id" value="{{ $value -> id }}">
        <input type="submit" value="編集"></td>
      </form>
      <form action="{{ route('ItemDclick') }}" method="POST">
        {{ csrf_field() }}
        <td class="delete"><input type="hidden" name="id" value="{{ $value -> id }}">
        <button type="submit">削除</button></td>
      </form>
    </tr>
    @endforeach
  </table>
  @endif
</div>
@endsection