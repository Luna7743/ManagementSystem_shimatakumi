@extends('layouts.sidebar')

{{-- 新規投稿の作成画面を表示するためのもの --}}
@section('content')
    <div class="post_create_container d-flex">
        <div class="post_create_area border w-50 m-5 p-5">
            {{-- メインカテゴリーとサブカテゴリーの選択 --}}
            <div class="">
                <p class="mb-0">カテゴリー</p>
                <select class="w-100" form="postCreate" name="post_category_id">
                    <option value="" disabled>教科</option>
                    @foreach ($main_categories as $main_category)
                        <!-- メインカテゴリーを選択肢として追加 -->
                        <option value="{{ $main_category->id }}" disabled>{{ $main_category->main_category }}</option>
                        <!-- サブカテゴリーをメインカテゴリーに紐付けて表示 -->
                        @foreach ($main_category->subCategories as $sub_category)
                            <option value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            {{-- 投稿タイトルの入力フィールド --}}
            <div class="mt-3">
                @if ($errors->first('post_title'))
                    <span class="error_message">{{ $errors->first('post_title') }}</span>
                @endif
                <p class="mb-0">タイトル</p>
                <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
            </div>
            {{-- 投稿内容の入力フィールド --}}
            <div class="mt-3">
                @if ($errors->first('post_body'))
                    <span class="error_message">{{ $errors->first('post_body') }}</span>
                @endif
                <p class="mb-0">投稿内容</p>
                <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
            </div>
            {{-- 投稿ボタンとフォーム --}}
            <div class="mt-3 text-right">
                <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
            </div>
            <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
        </div>

        {{-- 管理者向けメインカテゴリー追加フォーム --}}
        @can('admin')
            <div class="w-25 ml-auto mr-auto">
                <div class="category_area mt-5 p-5">
                    <div class="">
                        <p class="m-0">メインカテゴリー</p>
                        <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
                        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
                    </div>
                    <!-- サブカテゴリー追加 -->
                    <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">
                        {{ csrf_field() }}</form>
                </div>
            </div>
        @endcan
    </div>
@endsection
