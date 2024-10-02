@extends('layouts.sidebar')

@section('content')
<div class="calendar-container">
    {{-- ユーザーのプロフィール表示部分 --}}
    <div class="vh-100">
        <div class="my-pro">
            <span>{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>
        </div>
        <div class="top_area w-75 m-auto pt-5">
            <div class="user_status p-3">
                <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
                <p>カナ : <span>{{ $user->over_name_kana }}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
                <p>性別 : @if ($user->sex == 1)
                    <span>男</span>@else<span>女</span>
                    @endif
                </p>
                <p>生年月日 : <span>{{ $user->birth_day }}</span></p>
                <div>選択科目 :
                    @foreach ($user->subjects as $subject)
                        <span>{{ $subject->subject }}</span>
                    @endforeach
                </div>
                <div class="subject_edit">
                    {{-- 管理者のみ表示される「選択科目の編集」ボタンとフォーム --}}
                    @can('admin')
                        <span class="subject_edit_btn">選択科目の編集</span>
                        <div class="subject_inner">
                            <form action="{{ route('user.edit') }}" method="post">
                                <div class="d-flex subject_edit" style="align-items: baseline">
                                    @foreach ($subject_lists as $subject_list)
                                        <div class="subject_name_edit">
                                            <label>{{ $subject_list->subject }}</label>
                                            <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
                                        </div>
                                    @endforeach
                                    <input type="submit" value="編集" class="btn btn-primary">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                </div>

                                {{ csrf_field() }}
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
