<?php

// Swiftでいうimport文みたいな感じ
use Illuminate\Database\Migrations\Migration; // マイグレーションを実行する基底クラス。これを継承すると、スキーマ操作を記述する。
use Illuminate\Database\Schema\Blueprint; // テーブルのカラムやインデックスを定義するためのクラス。インデックス: データベーステーブルの検索を高速化するための仕組み。（主キーを設定し、テーブルに値を追加すると、主キーは自動でインクリメントされる、それを自動的にインデックスが作成されるという。そうなると、何あテーブル内で値を検索するときにそのインデックス（id）だけでカラム内の該当する値を見つけるから検索が高速化するというニュアンスらしい）
use Illuminate\Support\Facades\Schema; // テーブルを作成、変更、削除するためのファサード（インターフェース）。

// new classで無名クラスを返している。このクラスはマイグレーションを継承している。つまり、テーブルのスキーマ操作をするクラス。
// up, down関数を定義し、テーブルの作成と削除を制御する。
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // upメソッド: マイグレーションを実行したときに行う処理
    // 主に「テーブルを作成する」や「テーブルを変更する」操作を記述している。
    public function up()
    {
        // Schema::create
        // データベースに新しいテーブルを作成する。
        // profilesという名前のテーブルが作成される。
        // コールバック関数内で、Blueprintクラスを使って、カラムやインデックスを定義する。LaravelのSchema::createの中で使用されるコールバック関数は、テーブルの構造を定義するために使われる。
        // コールバック関数: 特定の処理が行われたときに「後から呼び出される関数」のことを指す。
        // つまり、Scema::createが先に呼び出され実行される（profilesテーブルを作成しなさいという命令）ので、その後から呼び出される（第2引数でコールバック関数を渡す）。
        // 渡される$tableはBlueprintクラスのインスタンスで、テーブルのカラムやインデックスを定義するために使う。
        Schema::create('profiles', function (Blueprint $table) {
            
            // 主キー(Primary Key)のカラムを作成。BIGINT型。
            // 主キーは自動的にインクリメントしていく数値のキー、型はBIGINT型
            $table->id();

            // user_idのカラムを作成。unsignedBigInteger型
            // users.idを参照する外部キー
            // usersテーブルのidを参照する外部キーとして、利用される。
            // 符号なし: unsigned、つまり、正の範囲だけを活用。負の範囲は活用しない。idカラムは-1などとディクレイメントされないので、負の範囲は必要なし。
            $table->unsignedBigInteger('user_id'); 

            // bioカラムを作成。Text型。自己紹介カラム。
            // Text型: 長文データを保存できる。
            // nullable()により、値がnullでも許容される。（必須ではないカラム）
            $table->text('bio')->nullable();

            // created_at, updated_atというタイムスタンプのカラムを自動で追加する。
            // created_at: レコードが作成された日時を記録。
            // updated_at: レコードが最後に更新された日時を記録。
            $table->timestamps(); // created_at, updated_at カラム
    
            // 外部キー制約
            // 外部キー: 別テーブルのデータを参照する「橋渡し」
            // テーブル同士のつながりや関係性を定義するために使う。
            // ここでいう外部キーは、user_idカラム
            // usersテーブルのidカラムを参照する
            // onDelete('cascade'):
            // usersテーブルの対応するidのレコードが削除された場合、自動的にprofilesテーブルの関連レコードも削除される
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // マイグレーションをロールバック（取り消し）したときに行う処理を記述
    public function down()
    {
        // Schema::dropIfExists('profiles')
        // データベースにprofilesテーブルがすでに存在している場合に削除
        // 存在していない場合、何もぜず、エラーも発生しない
        Schema::dropIfExists('profiles');
    }
};
