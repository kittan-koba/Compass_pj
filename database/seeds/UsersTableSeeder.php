<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = ([
            [
                'over_name' => '佐藤',
                'under_name' => '次郎',
                'over_name_kana' => 'サトウ',
                'under_name_kana' => 'ジロウ',
                'mail_address' => 'hogehogess@ymail.com',
                'sex' => '1',
                'birth_day' => '1989-03-10',
                'role' => '4',
                'password' => 'sato3100',
                'remember_token' => ''
            ],
        ]);

        foreach ($users as $userData) {
            // パスワードをハッシュ化して保存
            $userData['password'] = Hash::make($userData['password']);

            // データベースに保存
            User::create($userData);
        }
    }
}