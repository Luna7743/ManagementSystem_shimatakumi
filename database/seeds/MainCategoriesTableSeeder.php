<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\MainCategory;

class MainCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // サンプルデータを追加
        MainCategory::create(['main_category' => '国語']);
        MainCategory::create(['main_category' => '数学']);
        MainCategory::create(['main_category' => '英語']);
    }
}
