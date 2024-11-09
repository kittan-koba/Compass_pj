@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pb-5" style=" box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2); border-radius: 15px; padding: 20px; background:#FFF;">
    <div class="w-75 m-auto" style="border-radius:5px;">

      <p class="text-center" style="font-size: 18px; font-weight: bold;">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-70 m-auto" style="margin-top: 20px;">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<!-- ここから下新規実装するモーダル -->

<div class="delete_modal modal">
  <div class="modal__bg modal_close"></div>
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="post">
      @csrf
      {{-- 表示用 --}}
      <div class="btn_modal">
        <div class="reserve_date"></div>
        <div class="reserve_part"></div>
        <p>こちらの予約をキャンセルしますか？</p>
        <div class="btn_area">
          <a class="modal_close btn btn-primary" href="">戻る</a>
          <input type="submit" class="m-auto btn btn-danger" href="/delete/calendar" value="キャンセル">
        </div>
      </div>
      {{-- 送信用 --}}
      <input type="hidden" name="reserve_date" class="reserve_date" value="">
      <input type="hidden" name="reserve_part" class="reserve_part" value="">
    </form>
  </div>
</div>

@endsection