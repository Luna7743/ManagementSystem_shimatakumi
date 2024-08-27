<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // メインカテゴリーを取得
        $mainCategory1 = MainCategory::where('main_category', '国語')->first();
        $mainCategory2 = MainCategory::where('main_category', '数学')->first();
        $mainCategory3 = MainCategory::where('main_category', '英語')->first();

        // サブカテゴリーを追加
        SubCategory::create(['main_category_id' => $mainCategory1->id, 'sub_category' => '古文']);
        SubCategory::create(['main_category_id' => $mainCategory1->id, 'sub_category' => '漢文']);
        SubCategory::create(['main_category_id' => $mainCategory2->id, 'sub_category' => '代数']);
        SubCategory::create(['main_category_id' => $mainCategory2->id, 'sub_category' => '幾何']);
        SubCategory::create(['main_category_id' => $mainCategory3->id, 'sub_category' => '文法']);
        SubCategory::create(['main_category_id' => $mainCategory3->id, 'sub_category' => '会話']);
    }

}
