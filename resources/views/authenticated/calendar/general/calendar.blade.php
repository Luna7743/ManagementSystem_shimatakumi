@extends('layouts.sidebar')
{{-- カレンダーを表示し、ユーザーが予約を行うための画面を構成 --}}
@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-90 m-auto" style="border-radius:5px;">

      <!-- カレンダーのタイトル表示 -->
      <p class="text-center">{{ $calendar->getTitle() }}</p>

      <!-- カレンダーの内容を表示 -->
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>

    <!-- 予約ボタン -->
    <div class="text-right w-90 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>

  {{-- 予約キャンセルのモーダル --}}
  <div class="modal js-modal">
    {{-- モーダルの背景部分 --}}
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <div class="w-100">
        <div class="modal-inner-date w-60 m-auto  pb-3 d-flex" style="align-items: baseline">
          <p>予約日:</p>
          <input type="text" class="modal_date" name="getDate" value="" form="deleteParts" readonly>
        </div>

        <div class="modal-inner-time w-60 m-auto pb-3 d-flex" style="align-items: baseline">
          <p>時間:リモ</p>
          <input type="text" class="modal_part" name="getPart" value="" form="deleteParts" readonly>
          <p>部</p>
        </div>

        <div class="w-60 m-auto pb-3">
          <p>上記の予約をキャンセルしてもよろしいでしょうか？</p>
        </div>

        <div class="edit-modal-btn w-60 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn  btn-primary d-inline-block" href="#">閉じる</a>
          <input type="submit" class="btn  btn-danger d-block" value="キャンセル" form="deleteParts">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
