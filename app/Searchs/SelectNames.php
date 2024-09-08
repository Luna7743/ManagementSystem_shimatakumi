<?php
namespace App\Searchs;

use App\Models\Users\User;

// ユーザー検索機能において、名前や名前のカナ、性別、役割を条件にユーザーを検索するために使用されるクラス
class SelectNames implements DisplayUsers{

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    // 性別が指定されていない場合、全ての性別を対象とする
    if(empty($gender)){
      $gender = ['1', '2', '3'];
    }else{
      $gender = array($gender);
    }

    // 役割が指定されていない場合、全ての役割を対象とする
    if(empty($role)){
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }

    // ユーザー検索クエリの構築
    $users = User::with('subjects')
    ->where(function($q) use ($keyword){
      // 名前または名前のカナでキーワード検索
      $q->where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })->whereIn('sex', $gender)
    ->whereIn('role', $role)
    ->orderBy('over_name_kana', $updown)->get();

    return $users;
  }
}
