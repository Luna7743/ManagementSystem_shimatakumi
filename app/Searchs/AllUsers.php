<?php
namespace App\Searchs;

use App\Models\Users\User;

// 検索条件にかかわらずすべてのユーザーを取得するためのクラス
class AllUsers implements DisplayUsers{

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    $users = User::all();
    return $users;
  }


}
