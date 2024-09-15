<?php
namespace App\Searchs;

use App\Models\Users\User;

// IDに基づく検索に加えて、科目などの詳細な条件も使ってユーザーをフィルタリングする。
class SelectIdDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // キーワードがnullの場合、全ユーザーのIDを取得
    if(is_null($keyword)){
      $keyword = User::pluck('id')->toArray();
    }else{
      $keyword = array($keyword);
    }

    // 性別がnullの場合、全ての性別を対象にする
    if(is_null($gender)){
      $gender = ['1', '2', '3'];
    }else{
      $gender = array($gender);
    }

    // 役割がnullの場合、全ての役割を対象にする
    if(is_null($role)){
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }

    // ユーザー検索
    $users = User::with('subjects')
    ->whereIn('id', $keyword)
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    ->whereHas('subjects', function($q) use ($subjects){
      // 選択科目によるフィルタリング（複数科目対応）
      $q->whereIn('subjects.id', $subjects);
    })
    ->orderBy('id', $updown)->get();
    return $users;
  }

}
