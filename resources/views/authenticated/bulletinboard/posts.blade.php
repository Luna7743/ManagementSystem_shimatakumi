@extends('layouts.sidebar')

{{-- 投稿一覧ページを作成するための Laravel Blade テンプレートです。 --}}
@section('content')
    <div class="board_area w-100 border m-auto d-flex">
        <div class="post_view w-75 mt-5">
            <p class="w-75 m-auto">投稿一覧</p>
            @foreach ($posts as $post)
                {{-- 各投稿を表示するエリア --}}
                <div class="post_area border w-75 m-auto p-3">
                    <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん
                    </p>
                    <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>

                    <div class="post_bottom_area d-flex">
                        {{-- サブカテゴリーの表示 --}}
                        @foreach ($post->subCategories as $subCategory)
                            {{-- <button class="subcategory_button" type="" name="button">{{ $subCategory->sub_category }}</button> --}}
                            <span class="">{{ $subCategory->sub_category }}</span>
                        @endforeach

                        {{-- 投稿のステータス（コメント数や「いいね」ボタンなど）を表示するエリア --}}
                        <div class="d-flex post_status">
                            <div class="mr-5">
                                <i class="fa fa-comment"></i>
                                <span class="">{{ $post->postComments()->count() }}</span>
                            </div>
                            <div>
                                {{-- 現在のユーザーがその投稿にいいねしているかどうかをチェック --}}
                                @if (Auth::user()->is_Like($post->id))
                                    <p class="m-0">
                                        <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
                                        <span
                                            class="like_counts like_counts{{ $post->id }}">{{ $post->likes_count }}</span>
                                        <!-- ここにいいね数を表示 -->
                                    </p>
                                @else
                                    <p class="m-0">
                                        <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
                                        <span
                                            class="like_counts like_counts{{ $post->id }}">{{ $post->likes_count }}</span>
                                        <!-- ここにいいね数を表示 -->
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 投稿検索やカテゴリ選択の機能を実装 --}}
        <div class="other_area border w-25">
            <div class="border m-4">
                <div class=""><a href="{{ route('post.input') }}">投稿</a></div>
                {{-- キーワード検索部分 --}}
                <div class="">
                    <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
                    <input type="submit" value="検索" form="postSearchRequest">
                </div>
                {{-- いいねした投稿や自分の投稿のボタン --}}
                <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
                <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">

                {{-- カテゴリ選択フォーム --}}
                <form id="postSearchRequest" method="GET" action="{{ route('post.show') }}">
                    <ul class="main_categories">
                        @foreach ($categories as $category)
                            {{-- 各メインカテゴリーを表示 --}}
                            <li class="main_categories_title accordion-title" category_id="{{ $category->id }}">
                                <span>{{ $category->main_category }}</span>
                                {{-- メインカテゴリーに関連付けられたサブカテゴリーをループで表示 --}}
                                @foreach ($category->subCategories as $sub_category)
                            <li class="sub_category_box category_num{{ $category->id }}">
                                <button type="submit" name="category_word" value="{{ $sub_category->sub_category }}"
                                    class="btn btn-link">
                                    {{ $sub_category->sub_category }}
                                </button>
                            </li>
                        @endforeach
                        </li>
                        @endforeach
                    </ul>
                </form>
            </div>
        </div>

        {{-- 検索やフィルタリングを行うためのフォームです。 --}}
        <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
    </div>
@endsection
