@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $date }}</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="h-75 border">
      <!-- 日付と何部かを抽出するために$dateと$partを -->
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>

        @foreach ($reservePersons as $reservePerson)
        @foreach ($reservePerson->users as $user)
        <!-- なぜ二重にするのか：foreachを使用している理由は、$reservePersonsの中に複数のusersが含まれているため、それぞれのreservePersonについて、その配下にいる全てのuserに対して処理を行う必要があるから。 -->
        <tr class="text-center">
          <td class="w-25">{{ $user->id }}</td>
          <td class="w-25">{{ $user->over_name . $user->under_name }}</td>
          <td class="w-25">リモート</td>
        </tr>
        @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection