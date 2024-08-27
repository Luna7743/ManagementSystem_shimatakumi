@extends('layouts.sidebar')
@section('content')

{{-- ユーザーが「いいね」した投稿を表示するビューを作成 --}}
<div class="post_view w-75 mt-5">
  <p class="w-75 m-auto">いいねした投稿</p>
  @foreach($posts as $post)
  <div class="post_area border w-75 m-auto p-3">
    <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
    <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
    <div class="post_bottom_area d-flex">
      {{-- 現在のユーザーがこの投稿を「いいね」しているかどうかを確認 --}}
      @if(Auth::user()->is_Like($post->id))
      {{-- 「いいね」している場合: --}}
      <p class="m-0">
        {{-- 「いいね」を取り消すボタンを表示 --}}
        <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
        {{-- その投稿の「いいね」カウントを表示 --}}
        <span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span>
      </p>
      
      @else
      {{-- 「いいね」していない場合: --}}
      <p class="m-0">
        {{-- 「いいね」ボタンを表示 --}}
        <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
        <span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span>
      </p>
      @endif
    </div>
  </div>
  @endforeach
</div>

@endsection
