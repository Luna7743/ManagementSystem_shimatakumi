<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];

    // メインカテゴリーとのリレーション
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
        //belongsTo:1つのサブカテゴリーは、1つのメインカテゴリーに属している関係を定義しています。
    }

    // 投稿とのリレーション
    public function posts()
    {
        return $this->belongsToMany('App\Models\Posts\Post',
         'post_sub_categories', // 中間テーブル名
        'sub_category_id', // SubCategory モデルの外部キー
        'post_id' // Post モデルの外部キー
        );

    }
}
