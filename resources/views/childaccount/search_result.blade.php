@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/child_sidepage.css">


<div id="title_box">
  <h1 id="back_text">Sarch Result</h1>
  <p id="title_text">検索結果</p>
</div>

@if($searchList == false)

<div class="list_title">
    <h2>検索結果該当なし</h2>
</div>
<div class="list">
  <div id="emptytext">
    <p>検索結果に該当するものがありませんでした。</p>
    <p>検索の際は「仕事」又は「商品」を必ずご選択頂いた上で</p>
    <p>正しいキーワードを入力してください。</p>
  </div>


@else
<div class="list_title">
  @if ($input == '仕事')
    <h2>検索された仕事</h2>
  @else
    <h2>検索された商品</h2>
  @endif
  
</div>
<div class="list">
  <table>
    <tr>
      <th class="name">仕事名</th>
      <th class="content">内容</th>
      
      @if ($input == '仕事')
        <th class="mony">報酬</th>
        <th class="favorite">お気に入り</th>
        <th class="complete">完了</th>
      @else
        <th class="mony">価格</th>
        <th class="favorite">お気に入り</th>
        <th class="complete">購入</th>
      @endif
    </tr>

    @foreach($searchList as $value)
    @if ($input == '仕事')
      @php
        $compjob = DB::table('complete_jobs');
        $existence = $compjob -> where('users_id', session()->get('id'))
        -> where('jobs_id',  $value -> id)
        -> where('flg', 0) -> exists();

        $favoriteJ = DB::table('favorite_jobs');
        $FJexists = $favoriteJ -> where('users_id', session()->get('id'))
        -> where('jobs_id',  $value -> id) -> exists();
      @endphp
    @else
      @php
        $favoriteI = DB::table('favorite_items');
        $Fiexists = $favoriteI -> where('users_id', session()->get('id'))
        -> where('items_id',  $value -> id) -> exists();
      @endphp
    @endif
    <tr>
      <td class="name">{{ $value -> name }}</td>
      <td class="content">{{ $value -> content }}</td>
      
        @if ($input == '仕事')
          <td class="mony">{{ $value -> reward }}{{$walletName -> money_name}}</td>
          @if ($FJexists)
            <td class="chldbutton complete">
            <input id="confirmation" type="button" value="追加済み"></td>
          @else
            <form action="./JobFavoriteAddition" method="get">
            {{ csrf_field() }}
              <td class="chldbutton favorite"><input type="hidden" name="id" value="{{ $value -> id }}">
              <input type="submit" value="追加"></td>
            </form>
          @endif
          @if ($existence)
            <td class="chldbutton complete">
            <input id="confirmation" type="button" value="確認中"></td>
          @else
            <form action="./child_jobcomp" method="get">
            {{ csrf_field() }}
              <td class="chldbutton complete"><input type="hidden" name="id" value="{{ $value -> id }}">
              <input type="submit" value="完了"></td>
            </form>
          @endif
      @else
        <td class="mony">{{ $value -> price }}{{$walletName -> money_name}}</td>
        @if ($Fiexists)
          <td class="chldbutton complete">
          <input id="confirmation" type="button" value="追加済み"></td>
        @else
          <form action="./ItemFavoriteAddition" method="get">
          {{ csrf_field() }}
            <td class="chldbutton">
            <input type="hidden" name="id" value="{{ $value -> id }}">
            <input type="submit" value="追加"></td>
          </form>
        @endif
          <form action="./child_itemcomp" method="get">
            {{ csrf_field() }}
            <td class="chldbutton"><input type="hidden" name="id" value="{{ $value -> id }}">
            <input class="order{{$loop->index}}" type="submit" value="依頼"></td>
          </form>
      @endif
    </tr>
    @endforeach
  </table>
  @endif
</div>

@endsection