@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<!-- フラッシュメッセージの表示 -->
@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif

<!-- キャンセル確認モーダル -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">キャンセル確認</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>予約日: <span id="modal-date"></span></p>
        <p>予約時間: <span id="modal-time"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
        <button type="button" class="btn btn-danger" id="confirmCancel">キャンセルする</button>
      </div>
    </div>
  </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.cancel-button').forEach(button => {
    button.addEventListener('click', function() {
      const date = this.dataset.date;
      const time = this.dataset.time;
      document.getElementById('modal-date').innerText = date;
      document.getElementById('modal-time').innerText = time;
      $('#cancelModal').modal('show');
    });
  });
});
</script>
