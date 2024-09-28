@extends('layouts.sidebar')

@section('content')
    <div class="search_content w-100 d-flex">
        {{-- ユーザー一覧の表示部分 --}}
        <div class="reserve_users_area">
            @foreach ($users as $user)
                <div class="border one_person">
                    <div class="user-item">
                        <span>ID : </span><span>{{ $user->id }}</span>
                    </div>
                    {{-- ユーザーの名前とプロフィールリンク: --}}
                    <div class="user-item">
                        <span>名前 : </span>
                        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                            <span>{{ $user->over_name }}</span>
                            <span>{{ $user->under_name }}</span>
                        </a>
                    </div>
                    <div class="user-item">
                        <span>カナ : </span>
                        <span>({{ $user->over_name_kana }}</span>
                        <span>{{ $user->under_name_kana }})</span>
                    </div>
                    <div class="user-item">
                        @if ($user->sex == 1)
                            <span>性別 : </span><span>男</span>
                        @elseif($user->sex == 2)
                            <span>性別 : </span><span>女</span>
                        @else
                            <span>性別 : </span><span>その他</span>
                        @endif
                    </div>
                    <div class="user-item">
                        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
                    </div>
                    <div class="user-item">
                        @if ($user->role == 1)
                            <span>権限 : </span><span>教師(国語)</span>
                        @elseif($user->role == 2)
                            <span>権限 : </span><span>教師(数学)</span>
                        @elseif($user->role == 3)
                            <span>権限 : </span><span>講師(英語)</span>
                        @else
                            <span>権限 : </span><span>生徒</span>
                        @endif
                    </div>
                    <div class="user-item">
                        @if ($user->role == 4)
                            <span>選択科目 :</span>
                            @foreach ($user->subjects as $subject)
                                <span>{{ $subject->subject }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 検索フォーム部分 --}}
        <div class="search_area">
            <div class="">
                <div>
                    <p class="search_title">検索</p>
                </div>
                <div>
                    <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
                </div>
                <div>
                    <label>カテゴリ</label>
                    <div class="">
                        <select class="selection" form="userSearchRequest" name="category">
                            <option value="name">名前</option>
                            <option value="id">社員ID</option>
                        </select>
                    </div>

                </div>
                <div>
                    <label>並び替え</label>
                    <div>
                        <select class="selection" name="updown" form="userSearchRequest">
                            <option value="ASC">昇順</option>
                            <option value="DESC">降順</option>
                        </select>
                    </div>

                </div>
                <div class="">
                    <p class="search_conditions"><span>検索条件の追加</span></p>
                    <div class="search_conditions_inner">
                        <div>
                            <label>性別</label>
                            <div>
                                <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
                                <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
                                <span>その他</span><input type="radio" name="sex" value="3"
                                    form="userSearchRequest">
                            </div>

                        </div>
                        <div>
                            <label>権限</label>
                            <div>
                                <select class="selection engineer" name="role" form="userSearchRequest">
                                    <option selected disabled>----</option>
                                    <option value="1">教師(国語)</option>
                                    <option value="2">教師(数学)</option>
                                    <option value="3">教師(英語)</option>
                                    <option value="4" class="">生徒</option>
                                </select>
                            </div>

                        </div>

                        <div class="selected_engineer">
                            <label>選択科目</label>
                            <br>
                            <div class="d-flex">
                                @foreach ($subjects as $subject)
                                    <div class="selected_subject">
                                        <span>{{ $subject->subject }}</span>
                                        <input type="checkbox" name="subject[]" value="{{ $subject->id }}"
                                            form="userSearchRequest">
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

                <div class="search_btn">
                    <input class="search_btn_in" type="submit" name="search_btn" value="検索" form="userSearchRequest">
                </div>
                <div class="reset">
                    <input class="reset_in" type="reset" value="リセット" form="userSearchRequest">
                </div>
            </div>
            {{-- 検索処理用のフォーム  --}}
            <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
        </div>
    </div>
@endsection
