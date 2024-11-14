<?php
// マイグレーション: 開発者がテーブルを作成したり変更したりできる、データベースのバージョン管理もできる。
// マイグレーションファイルは、データベースのテーブルの設計図のようなもの。
// Laravelでは、テーブルの作成や変更をマイグレーションという形式で管理する。
// このファイルでは、テーブル名やカラム（列）の定義、データ型、制約（ユニーク、インデックスなど）を指定する。
// マイグレーションは、データベースをバージョン管理するための仕組みで、開発者がテーブルを作成したり変更したりする際に非常に便利。

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
    // 下記マイグレーションコマンドを実行するまでは、作成したテーブルがデータベースに作成したことにならない。(実行後、データベースにテーブルが反映される)
    // docker compose exec app php artisan migrate 

    // up: テーブルの作成や変更を行う部分
    public function up()
    {
        // マイグレーションの実行メソッド
        Schema::create('users', function (Blueprint $table) {
            // 各々、コードの疑問点を後で調べる、idにはなぜ何も定義がないのか？そもそもどんなカラム（列）を定義しているのか、一行一行解説が欲しい
            $table->id(); // 自動で増加する主キー
            $table->string('name', 100); // 名前カラム（最大100文字）
            $table->string('email', 100)->unique(); // メールカラム（ユニーク制約）
            $table->timestamps(); // created_at と updated_at を自動で追加される
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // マイグレーションの取り消しメソッド
    // down: up() で行った変更を元に戻すための部分
    // 通常dropIfExists()を使ってテーブルを削除する。
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
