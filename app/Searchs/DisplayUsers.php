<?php
namespace App\Searchs;

// 検索機能に関連するクラスが共通のメソッドシグネチャを持つことを保証するためのインターフェース
// 改修課題：選択科目の検索機能
interface DisplayUsers{
public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
}
