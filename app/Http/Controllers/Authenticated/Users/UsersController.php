<?php

// 名前空間とクラス:
namespace App\Http\Controllers\Authenticated\Users;//ログインしたユーザーに関する操作を担当

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
// 利用しているモデル:
use App\Models\Users\User;//ユーザーのデータを管理するモデル。
use App\Models\Users\Subjects;//科目に関するデータを管理するモデル。

use App\Searchs\DisplayUsers;
// 利用しているファクトリクラス:
use App\Searchs\SearchResultFactories;//検索結果を生成するためのクラス（ユーザー検索に関与）

class UsersController extends Controller
{
    // ユーザーの検索結果を表示するページにデータを渡す
    public function showUsers(Request $request){
        $keyword = $request->keyword;//検索キーワードを取得
        $category = $request->category;//カテゴリを取得
        $updown = $request->updown;//並び順の指定を取得
        $gender = $request->sex;//性別を取得
        $role = $request->role;//役割(管理者、一般ユーザーなど)を取得
        $subjects = $request->subject;// ここで検索時の科目を受け取る

        // 検索ファクトリを使用して、条件に一致するユーザーを取得
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);

        // 全ての科目を取得
        $subjects = Subjects::all();
        // 検索結果と科目をビューに渡して表示
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    //特定のユーザーのプロフィールを表示
    public function userProfile($id){
        // 指定されたIDのユーザーを取得し、関連する科目もロード
        $user = User::with('subjects')->findOrFail($id);

        // 全ての科目リストを取得
        $subject_lists = Subjects::all();

        // ユーザー情報と科目リストをビューに渡す
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    // 特定のユーザーの科目の編集
    public function userEdit(Request $request){
        // 編集対象のユーザーを取得
        $user = User::findOrFail($request->user_id);

        // ユーザーの科目を同期（更新）
        $user->subjects()->sync($request->subjects);

        // プロフィールページにリダイレクト
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}
