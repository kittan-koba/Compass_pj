<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seederを使ってデータを登録するためのコマンドを追加

        // 1. UsersTableSeederの実行
        $this->call(UsersTableSeeder::class);

        // 2. SubjectsTableSeederの実行
        $this->call(SubjectsTableSeeder::class);

        // 上記のSeederが正常に作動するように、ターミナルで以下のコマンドを実行
        // php artisan db:seed --class=DatabaseSeeder
    }
}
