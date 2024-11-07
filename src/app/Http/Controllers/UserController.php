<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    // GET /api/users にアクセスした際に呼び出されるメソッド
    public function index(): JsonResponse
    {
        // User モデルを使って全ユーザー情報を取得
        $users = User::all(); // users テーブルからすべてのレコードを取得
        return response()->json($users); // JSON形式で返す
    }
}
