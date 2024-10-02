@extends('layouts.sidebar')
{{-- ユーザーのリストや特定の日付・時間に関連する情報を表示するための画面 --}}
@section('content')
    <div class="calendar-container">
        <div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
            <div class="w-50 m-auto h-75">
                <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
                <div class="border striped-table">
                    <table class="w-100">
                        <tr class="text-center nominal">
                            <th class="w-20">ID</th>
                            <th class="w-40">名前</th>
                            <th class="w-40">場所</th>
                        </tr>

                        @foreach ($reservePersons as $reserve)
                            @foreach ($reserve->users as $user)
                                <tr class="text-center ">
                                    <td class="w-25">{{ $user->id }}</td>
                                    <td class="w-25">{{ $user->over_name }}{{ $user->under_name }}</td>
                                    <td class="w-25">リモート</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
