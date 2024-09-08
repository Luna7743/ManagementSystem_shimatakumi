<?php
namespace App\Searchs;

use App\Models\Users\User;

// IDに基づいたユーザー検索を行うクラス
class SelectIds implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // 性別が指定されていない場合、全性別を検索対象とする
    if(is_null($gender)){
      $gender = ['1', '2', '3'];
    }else{
      $gender = array($gender);
    }

    // 役割が指定されていない場合、全役割を検索対象とする
    if(is_null($role)){
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }

    // キーワード（ID）が指定されていない場合
    if(is_null($keyword)){
      // 全ユーザーを性別・役割でフィルタリング
      $users = User::with('subjects')
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();
    }else{
      // 特定のユーザーIDでフィルタリング
      $users = User::with('subjects')
      ->where('id', $keyword)
      ->whereIn('sex', $gender)
      ->whereIn('role', $role)
      ->orderBy('id', $updown)->get();
    }
    return $users;
  }

}
