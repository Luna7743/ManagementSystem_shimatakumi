<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];

    public function subCategories(){
        // リレーションの定義
        return $this->hasMany(SubCategory::class);
        //hasMany:1つのメインカテゴリーは、複数のサブカテゴリーを持つ関係（1対多）を定義しています。
    }

}
