
@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/child_toppage.css">

<script>
  updateBalance();

  setInterval(function() {
      updateBalance();
  }, 10000);

  function updateBalance() {
      $.ajax({url: './api/get-balance', method: 'GET', dataType: 'json', success: function(response) {
        $('#balance').text(response.balance);
      },
        error: function(error) {
          $('#balance').text('エラー発生');
      }
      });
  }
</script>




<div id="possession_money">
<h2>現在の所持{{$walletName -> money_name}}:   <span id="balance"></span></h2>
</div>




<div class="list_title">
  <h2>掲載中の仕事</h2>
</div>
<div class="list">
  @if($JobList == false)
  <div id="emptytext">
    <p>現在表示できる仕事がありません。</p>
    <p>新しいお仕事が追加されるまでお待ちください。</p>
  </div>
  @else
  <table>
    <tr>
      <th class="name">仕事名</th>
      <th class="content">内容</th>
      <th class="mony">報酬</th>
      <th class="favorite">お気に入り</th>
      <th class="complete">完了</th>
    </tr>

    @foreach($JobList as $value)
    @php
      $compjob = DB::table('complete_jobs');
      $existence = $compjob -> where('users_id', session()->get('id'))
      -> where('jobs_id',  $value -> id)
      -> where('flg', 0) -> exists();

      $favoriteJ = DB::table('favorite_jobs');
      $FJexists = $favoriteJ -> where('users_id', session()->get('id'))
      -> where('jobs_id',  $value -> id) -> exists();
    @endphp
    <tr>
      <td class="name">{{ $value -> name }}</td>
      <td class="content">{{ $value -> content }}</td>
      <td class="mony">{{ $value -> reward }}{{$walletName -> money_name}}</td>
      @if ($FJexists)
      <td class="chldbutton complete">
        <input id="confirmation" type="button" value="追加済み"></td>
      @else
        <form action="./JobFavoriteAddition" method="get">
        {{ csrf_field() }}
        <td class="chldbutton favorite"><input type="hidden" name="id" value="{{ $value -> id }}">
          <input class="oneclick" type="submit" value="追加"></td>
      </form>
      @endif
      
      
      @if ($existence)
      <td class="chldbutton complete">
      <input id="confirmation" type="button" value="確認中"></td>
      @else
      <form action="./child_jobcomp" method="get">
        {{ csrf_field() }}
        <td class="chldbutton complete"><input type="hidden" name="id" value="{{ $value -> id }}">
          <input class="oneclick" type="submit" value="完了"></td>
      </form>
      @endif
    </tr>
    @endforeach
  </table>
  @endif
</div>

<div class="list_title">
  <h2>掲載中の商品</h2>
</div>
<div class="list">
  @if($ItemList == false)
  <div id="emptytext">
    <p>現在表示できる商品がありません。</p>
    <p>新しい商品が追加されるまでお待ちください。</p>
  </div>
  @else
  <table>
    <tr>
      <th class="name">商品名</th>
      <th class="content">内容</th>
      <th class="mony">価格</th>
      <th class="favorite">お気に入り</th>
      <th class="complete">購入</th>
    </tr>
    

    @foreach($ItemList as $value)
    @php
      $favoriteI = DB::table('favorite_items');
      $Fiexists = $favoriteI -> where('users_id', session()->get('id'))
      -> where('items_id',  $value -> id) -> exists();
    @endphp
    <tr>
      <td class="name">{{ $value -> name }}</td>
      <td class="content">{{ $value -> content }}</td>
      <td class="mony">{{ $value -> price }}{{$walletName -> money_name}}</td>
      @if ($Fiexists)
      <td class="chldbutton complete">
        <input id="confirmation" type="button" value="追加済み"></td>
      @else
      <form action="./ItemFavoriteAddition" method="get">
        {{ csrf_field() }}
        <td class="chldbutton">
        <input type="hidden" name="id" value="{{ $value -> id }}">
        <input class="oneclick" type="submit" value="追加"></td>
      </form>
      @endif
      <form action="./child_itemcomp" method="get">
        
        {{ csrf_field() }}
        <td class="chldbutton"><input type="hidden" name="id" value="{{ $value -> id }}">
        <input class="order{{$loop->index}} oneclick" type="submit" value="依頼"></td>
      </form>
    </tr>
    @endforeach
  </table>
  @endif
</div>





@if($ItemList != false)
  @foreach($ItemList as $value)
  @if($walletsList -> balance < $value -> price )
    <script>
      $('.order{{$loop->index}}').on('click',function() {
        alert('残高が足りません');
            return false;
      });
    </script>
  @endif
  @endforeach
@endif
@endsection