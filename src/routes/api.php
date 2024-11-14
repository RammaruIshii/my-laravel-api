<?php
// 全体の流れ
// ①ブラウザからエンドポイントへリクエスト:
// ユーザーがブラウザやAPIクライアントを用いて、/usersエンドポイントへアクセスし、GET/usersリクエストが送信される。

// ②ルートが呼ばれる
// routes/api.phpで/usersがUserController@indexメソッドにルーティングされているため、
// リクエストがUserControllerのindexメソッドに渡される。
// Route::get('/users', [UserController::class, 'index']);

// ③コントローラーが呼ばれる（UserController）
// リクエストがルート経由でUserControllerのindexメソッドが呼び出し、、
// indexメソッド内で、User::all()を呼びだし、usersテーブルから全ユーザー情報を取得する。

// ④モデルでのデータベース操作: 
// （データ操作が必要な場合）コントローラーはモデル（Userモデル）を通じて、
// データベース（usersテーブル）にアクセスする。
// User::all()でusersテーブルの全データを取得する。
// public function index(): JsonResponse
// {
//     $users = User::all();
//     return response()->json($users); 
// }

// ⑤レスポンスの作成
// コントローラーが取得したデータを元にレスポンスを作成し、ユーザーに返す。
// APIの場合は、JSON形式でのレスポンスが多く用いられる。


// ここでは、各リクエスト（GET, POST, PUT, DELETE）に対して
// どのメソッドを呼び出すかを指定する。
// このファイルでエンドポイントを定義する。

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// GET /api/users でUserControllerのindexメソッドなど各々メソッドを呼び出す。

// GETリクエスト：ユーザー一覧の取得
Route::get('/users', [UserController::class, 'index']);

// GETリクエスト：条件付きのユーザー取得
Route::get('/users/filter', [UserController::class, 'filter']);

// POSTリクエスト：新しいユーザーの追加
Route::post('/users', [UserController::class, 'store']);

// PUTリクエスト：既存ユーザーの更新
Route::put('/users/{id}', [UserController::class, 'update']);

// DELETEリクエスト：特定ユーザーの削除
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// DELETEリクエスト：全ユーザーのクリア
Route::delete('/users', [UserController::class, 'clear']);
