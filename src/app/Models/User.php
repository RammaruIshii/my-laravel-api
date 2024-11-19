<?php
// User.php は、 usersテーブルとLaravelのモデルを関連付けるためのファイル。
// モデルとは、データベーステーブルに対応するクラスで、データ操作を行うために利用される。

// なぜこのUserクラスだけで、このクラスがusersデーブルに対応すると判断できるのか？
// Laravelの規約であり、モデル名が単数系の場合、対応するテーブルは複数形となるため、
// Laravel側が自動的に、Userモデルをusersテーブルに関連づける（紐づける）
// では、紐づけるモデルとテーブル名を変更するには？
// $tableを使う。
// protected $table = 'members'; // モデルが指し示すテーブル名


// namespace: このファイルが属している名前空間を指定
// クラスや機能が衝突しないように整理する仕組み
// App/Modelsは、Laravelのデフォルトのモデルが格納される名前空間
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // HasFactory: ファクトリー機能を使えるようにする。これによりテスト用データを簡単に作成できる。
use Illuminate\Database\Eloquent\Model; // Model: このクラスを継承すると、データベースとのやりとり（Eloquent ORMの基本機能）を利用できる。

// UserクラスはModelクラスを継承
// これにより、Eloquent ORMの機能（データベースと簡単にやりとりできる機能）を持つモデルクラスとして動作する。
// デフォルトでは、このモデルはusersという名前のテーブルに対応する。
class User extends Model
{
    // ファクトリー機能を使用するためのトレイト
    // たとえば、テストで大量のダミーデータを作成する際に役立つ
    use HasFactory;

    // 'users'テーブルに関連付けられた、'name', 'email', 'created_at', 'updated_at' のカラムを自動で利用します。

    // フィールドのマスアサインメントを可能にする設定
    // マスアセスメント: 配列やJSONデータを使って、複数のカラムに一度に値を割り当てる仕組み
    // ↑のイメージを下記に記述
    // マスアサインメントを使わずにデータベースのレコードを作成する際、通常、1つ1つのカラムに値を代入する必要がある。
    // 例: 個別に値を設定する
    // $user = new User();
    // $user->name = '山田太郎';
    // $user->email = 'yamada@example.com';
    // $user->save();

    // ↑を配列形式でまとめて登録する方法が増すマスアサインメント
    // 下記のように、カラム名をキー、値をバリューとして持つ配列を渡せば、一度にデータを保存できる
    // 例: マスアサインメント
    // User::create([
    //     'name' => '山田太郎',
    //     'email' => 'yamada@example.com',
    // ]);
    //

    // しかし、マスアサインメントを使うときにセキュリティ面で問題がある。
    // マスアサインメントを使う場合、入力データ全体が直接データベースに保存されるリスク。
    // たとえば、次のような不正なリクエストがあったとする。
    // POST /users
    // {
    // "name": "山田太郎",
    // "email": "yamada@example.com",
    // "is_admin": true
    // }
    // この場合、もし何も制限をかけていなければ、is_adminカラムも保存され、悪意のあるユーザーが自分を管理者にする可能性がある。

    // ↑の不正なデータベースへのリクエストを制御するために、防御策がある。それが
    // $fillable と $guarded
    // ララベルでは、$fillable か $quarded をモデルに設定すると、どのカラムをマスアサインメントで書き込み可能にするか制御できる
    // $fillable: マスアサインメントで許可するカラムを明示的に指定。
    // nameとemailのみがマスアサインメントで書き込み可能になる。
    // 通常、$fillable と $guarded はどちらか片方を使う。両方同時に設定すると混乱する。
    protected $fillable = ['name', 'email']; // データベースに保存する項目を指定（例：name, email）


    // また、マスアサインメントが有効になるのは、以下のような操作を行うとき
    // 1) create メソッド: 新しいレコードを作成するとき。
    // User::create([
    //     'name' => '山田太郎',
    //     'email' => 'yamada@example.com',
    // ]);

    // 2) update メソッド: 既存のレコードを更新するとき。
    // $user = User::find(1);
    // $user->update([
    // 'name' => '佐藤一郎',
    // ]);

    // 3) fill メソッド: オブジェクトに配列形式でデータを代入するとき。
    // $user = new User();
    // $user->fill([
    // 'name' => '田中花子',
    // 'email' => 'tanaka@example.com',
    // ]);
    // $user->save();

    // アクセス修飾子の種類
    // public: どこからでもアクセス可能（同じクラス、継承クラス、外部）
    // protected: 同じクラスと継承クラスからのみアクセス可能（外部からはアクセスできない）
    // private: 同じクラスからのみアクセス可能（継承クラスや外部からはアクセスできない）

    // protected の使いどころ
    // protected は、クラス内部や継承クラスでデータを操作するために使う。外部から直接アクセスさせたくないデータやメソッドを保護する目的で使用。
    // class User {
    //     protected $password;
    
    //     public function setPassword($password) {
    //         $this->password = password_hash($password, PASSWORD_BCRYPT);
    //     }
    
    //     public function getPassword() {
    //         return $this->password; // クラス内部からはアクセス可能
    //     }
    // }
    
    // $user = new User();
    // $user->setPassword('my_secure_password');
    // // $user->password; // エラー: 外部から直接アクセスできない
    

    

    




}
