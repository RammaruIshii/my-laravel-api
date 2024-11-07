<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // ここでは、usersテーブルに関連するモデルを定義します。
    // 'users' テーブルに関連付けられた、'name', 'email', 'created_at', 'updated_at' のカラムを自動で利用します。

    protected $fillable = ['name', 'email']; // 追加するカラムの定義（例：name, email）
}
