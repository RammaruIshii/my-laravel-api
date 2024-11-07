<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // id, name, email, created_at, updated_atの列（カラム）が含まれるusersテーブルを定義する
    // 下記マイグレーションコマンドを実行するまでは、作成したテーブルがデータベースに作成したことにならない。
    // docker compose exec app php artisan migrate 
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // 各々、コードの疑問点を後で調べる、idにはなぜ何も定義がないのか？そもそもどんなカラム（列）を定義しているのか、一行一行解説が欲しい
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            // created_at と updated_at を自動で追加される
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
