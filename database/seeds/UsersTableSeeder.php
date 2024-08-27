<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // ダミーユーザーデータの作成
        // User::create([
        //     'over_name' => '田中',
        //     'under_name' => '太郎',
        //     'over_name_kana' => 'タナカ',
        //     'under_name_kana' => 'タロウ',
        //     'mail_address' => 'taro.tanaka@example.com',
        //     'sex' => '1', // 例: 1 = 男性, 2 = 女性
        //     'birth_day' => '1990-01-01',
        //     'role' => '4', // 例: 4 = 生徒
        //     'password' => bcrypt('pikapika'),
        // ]);

        // User::create([
        //     'over_name' => '鈴木',
        //     'under_name' => '花子',
        //     'over_name_kana' => 'スズキ',
        //     'under_name_kana' => 'ハナコ',
        //     'mail_address' => 'hanako.suzuki@example.com',
        //     'sex' => '2',
        //     'birth_day' => '1992-05-15',
        //     'role' => '4',
        //     'password' => bcrypt('pikapika'),
        // ]);

        // User::create([
        //     'over_name' => '佐藤',
        //     'under_name' => '次郎',
        //     'over_name_kana' => 'サトウ',
        //     'under_name_kana' => 'ジロウ',
        //     'mail_address' => 'jiro.sato@example.com',
        //     'sex' => '1',
        //     'birth_day' => '1988-08-20',
        //     'role' => '3', // 例: 3 = 教師
        //     'password' => bcrypt('pikapika'),
        // ]);

    }
}
