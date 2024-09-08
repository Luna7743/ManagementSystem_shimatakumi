<?php
namespace App\Searchs;

use App\Models\Users\User;

// ユーザー検索機能において、検索条件に基づいて適切な検索クラスを動的に選択し、検索結果を取得するためのファクトリークラス
class SearchResultFactories{
// 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects) {
    // カテゴリが名前の場合
    if ($category == 'name') {
      // 科目が指定されていない場合、SelectNames クラスを使用
      if (is_null($subjects)) {
        $searchResults = new SelectNames();
      } else {
        // 科目が指定されている場合、SelectNameDetails クラスを使用
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);

    // カテゴリがIDの場合
    } elseif ($category == 'id') {
      // 科目が指定されていない場合、SelectIds クラスを使用
      if (is_null($subjects)) {
        $searchResults = new SelectIds();
      } else {
        // 科目が指定されている場合、SelectIdDetails クラスを使用
        $searchResults = new SelectIdDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);

    // その他のカテゴリの場合、全ユーザーを取得する
    } else {
      $allUsers = new AllUsers();
      return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}
