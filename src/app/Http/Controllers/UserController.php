<?php
// このファイルは、Laravelでデータベースにアクセスし、データを取得・追加・更新・削除するためのメソッドを定義するコントローラー。
// コントローラーは、データベースとユーザーのやりとりを管理し、リクエストされた操作を実行する。 


namespace App\Http\Controllers;

use App\Models\User; // Userモデルをインポート
use Illuminate\Http\Request; // リクエストクラスをインポート
use Illuminate\Http\JsonResponse; // JSONでのレスポンスを扱うクラス

class UserController extends Controller
{
    // GET /api/users にアクセスした際に呼び出されるメソッド

    // ユーザーの一覧を取得する
    public function index(): JsonResponse
    {
        // Userモデルを使って全ユーザー情報を取得
        $users = User::all(); // users テーブルからすべてのレコードを取得
        return response()->json($users); // JSON形式で返す
    }

    // 特定条件でフィルターしたユーザーを取得するメソッド
    // 統合させるprofilesテーブルは別途作成し、profilesテーブルをデータベースに作成する必要がある（マイグレーションを用意してから、マイグレーションコマンドを実行してテーブルを作成）
    public function filter(Request $request): JsonResponse
    {
        $name = $request->input('name'); // リクエストデータから名前を取得

        $users = User::where('name', $name)
                     ->join('profiles', 'users.id', '=', 'profiles.user_id') // profilesテーブルとusersテーブルを結合
                     ->select('users.*', 'profiles.bio') // 必要なカラムだけを取得
                     ->get();

        return response()->json($users);
    }

    // 新しいユーザーを追加するメソッド
    public function store(Request $request): JsonResponse
    {
        // フォームやリクエストから送られたデータを使ってUserモデルを新規作成
        $user = User::create([
            'name' => $request->input('name'), // リクエストデータから名前を取得
            'email' => $request->input('email') // リクエストデータからメールアドレスを取得
        ]);
        return response()->json($user, 201); // 201は「作成成功」を意味するHTTPステータスコード
    }
     
     // 既存のユーザー情報を更新するメソッド
     public function update(Request $request, $id): JsonResponse
     {
        $user = User::findOrFail($id); // 該当するユーザーをIDで検索
        $user->update($request->only(['name', 'email'])); // 名前とメールアドレスを更新

        return response()->json($user);
    }

     // 特定のユーザーを削除するメソッド
     public function destroy($id): JsonResponse
     {
        $user = User::findOrFail($id); // ユーザーIDで検索
        $user->delete(); // ユーザーを削除

        return response()->json(['message' => 'User deleted successfully']);
     }

     // 全ユーザー情報を削除するメソッド
    public function clear(): JsonResponse
    {
        User::truncate(); // usersテーブル内の全データをクリア

        return response()->json(['message' => 'All users cleared successfully']);
    }
}

