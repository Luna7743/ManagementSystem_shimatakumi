@extends('layouts.sidebar')
{{-- カレンダーの予約確認を表示するシンプルな画面の構造を提供 --}}
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
        </div>
    @endsection
