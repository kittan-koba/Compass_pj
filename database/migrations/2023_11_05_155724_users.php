<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('over_name', 60)->change();
            $table->string('under_name', 60)->change();
            $table->string('over_name_kana', 60)->change();
            $table->string('under_name_kana', 60)->change();
            $table->string('mail_address', 255)->change();
            $table->unsignedInteger('sex')->change();
            $table->date('birth_day')->change();
            $table->unsignedInteger('role')->change();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('users');
    }
}