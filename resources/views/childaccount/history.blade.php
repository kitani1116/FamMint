@extends('Layout.layout')


@section('content')
<link rel="stylesheet" href="../resources/css/child_sidepage.css">

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



<div id="title_box">
  <h1 id="back_text">History</h1>
  <p id="title_text">取引履歴</p>
</div>

<div id="possession_money">
  <h2>現在の所持{{$walletName -> money_name}}:     <span id="balance"></span></h2>
  </div>


<div class="list_title">
  <h2>今までの取引履歴</h2>
</div>
<div class="list">
  @if($HList == false)
  <div id="emptytext">
    <p>お気に入り登録されている仕事がありません。</p>
    <p>トップページへ戻りお気に入り登録をしてください。</p>
  </div>
  @else
  <table>
    <tr>
      <th class="posting">取引日時</th>
      <th class="name">取引名</th>
      <th class="content">取引内容</th>
      <th class="mony">出入金</th>
    </tr>

    @foreach($HList as $value)
    <tr>
      <td class="name">{{ $value -> completed_at }}</td>
      <td class="content">{{ $value -> name }}</td>
      <td class="mony">{{ $value -> content }}</td>
      @if (strpos($value -> reward, '-') !== false)
        <td class="price">{{ $value -> reward }}{{$walletName -> money_name}}</td>
      @else
        <td class="reward">{{ $value -> reward }}{{$walletName -> money_name}}</td>
      @endif
    </tr>
    @endforeach
  </table>
  @endif
</div>




@endsection