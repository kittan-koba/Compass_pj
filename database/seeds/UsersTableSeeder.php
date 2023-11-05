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

        DB::table('users')->insert([
            [
                'over_name' => '佐藤',
                'under_name' => '一郎',
                'over_name_kana' => 'サトウ',
                'under_name_kana' => 'イチロウ',
                'mail_address' => 'hogehoge@fmail.com',
                'sex' => '1',
                'birth_day' => '1989-03-10',
                'role' => '4',
                'password' => 'sato3100',
                'remember_token' => ''
            ]
        ]);

    }
}