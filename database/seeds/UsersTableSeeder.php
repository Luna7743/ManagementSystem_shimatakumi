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
        // ダミーデータを10個作成
        $dummyUsers = [
            ['鈴木', '三郎', 'スズキ', 'サブロウ', 'saburo.suzuki@example.com', '1992-03-03', '1'],
            ['高橋', '四郎', 'タカハシ', 'シロウ', 'shiro.takahashi@example.com', '1993-04-04', '1'],
            ['伊藤', '五郎', 'イトウ', 'ゴロウ', 'goro.ito@example.com', '1994-05-05', '1'],
            ['渡辺', '花子', 'ワタナベ', 'ハナコ', 'hanako.watanabe@example.com', '1995-06-06', '2'],
            ['山本', '光子', 'ヤマモト', 'ミツコ', 'mitsuko.yamamoto@example.com', '1996-07-07', '2'],
            ['中村', '美子', 'ナカムラ', 'ヨシコ', 'yoshiko.nakamura@example.com', '1997-08-08', '2'],
            ['小林', '麗子', 'コバヤシ', 'レイコ', 'reiko.kobayashi@example.com', '1998-09-09', '2'],
            ['加藤', '恵子', 'カトウ', 'ケイコ', 'keiko.kato@example.com', '1999-10-10', '2'],
        ];

        foreach ($dummyUsers as $user) {
            User::create([
                'over_name' => $user[0],
                'under_name' => $user[1],
                'over_name_kana' => $user[2],
                'under_name_kana' => $user[3],
                'mail_address' => $user[4],
                'sex' => $user[6], // 1 = 男性, 2 = 女性
                'birth_day' => $user[5],
                'role' => '4', // 例: 4 = 生徒
                'password' => Hash::make('pikapika'),
            ]);
        }
    }
}
