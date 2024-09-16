@extends('layouts.sidebar')
{{-- カレンダーを表示し、ユーザーが予約を行うための画面を構成 --}}
@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <!-- カレンダーのタイトル表示 -->
      <p class="text-center">{{ $calendar->getTitle() }}</p>

      <!-- カレンダーの内容を表示 -->
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>

    <!-- 予約ボタン -->
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>

  {{-- 予約キャンセルのモーダル --}}
  <div class="modal js-modal">
    {{-- モーダルの背景部分 --}}
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <div class="">
        <div class="modal-inner-date">
          <p>予約日:</p>
          <input type="text" class="modal_date" name="getDate" value="" form="deleteParts" readonly>
        </div>

        <div class="modal-inner-time">
          <p>時間:リモ</p>
          <input type="text" class="modal_part" name="getPart" value="" form="deleteParts" readonly>
          <p>部</p>
        </div>

        <div class="">
          上記の予約をキャンセルしてもよろしいでしょうか？
        </div>

        <div class="edit-modal-btn">
          <a class="js-modal-close" href="#">閉じる</a>
          <input type="submit" class="" value="キャンセル" form="deleteParts">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
