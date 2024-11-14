<?php
// User.php は、 usersテーブルとLaravelのモデルを関連付けるためのファイル。
// モデルとは、データベーステーブルに対応するクラスで、データ操作を行うために利用される。

// なぜこのUserクラスだけで、このクラスがusersデーブルに対応すると判断できるのか？
// Laravelの規約であり、モデル名が単数系の場合、対応するテーブルは複数形となるため、
// Laravel側が自動的に、Userモデルをusersテーブルに関連づける（紐づける）
// では、紐づけるモデルとテーブル名を変更するには？
// $tableを使う。
// protected $table = 'members'; // モデルが指し示すテーブル名



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // ここでは、usersテーブルに関連するモデルを定義します。
    // 'users'テーブルに関連付けられた、'name', 'email', 'created_at', 'updated_at' のカラムを自動で利用します。

    // フィールドのマスアサインメントを可能にする設定
    protected $fillable = ['name', 'email']; // データベースに保存する項目を指定（例：name, email）
}
