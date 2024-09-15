@extends('layouts.sidebar')
{{-- カレンダーを表示するシンプルな画面の構造を提供 --}}
@section('content')
<div class="w-75 m-auto">
  <div class="w-100">
    <p>{{ $calendar->getTitle() }}</p>
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
@endsection
