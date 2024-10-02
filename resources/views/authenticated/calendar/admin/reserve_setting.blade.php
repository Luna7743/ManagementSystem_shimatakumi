@extends('layouts.sidebar')
{{-- カレンダーを表示し、登録ボタンを設置して予約設定などの操作を行うビューを提供 --}}
@section('content')
    <div class="calendar-container">
        <div class="w-100 pt-5 d-flex" style="align-items:center; justify-content:center; ">
            <div class="w-75 m-auto" style="background:#FFF;">
                <div class="w-100 border p-5">
                    <!-- カレンダーのタイトル表示 -->
                    <p class="text-center">{{ $calendar->getTitle() }}</p>

                    {!! $calendar->render() !!}
                    <div class="w-100 adjust-table-btn text-right">
                        <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting"
                            onclick="return confirm('登録してよろしいですか？')">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
