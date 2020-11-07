<?php
// 外部ファイルの読み込み
require_once 'Const.php';
require_once 'Message.php';

// データベースとやり取りを行う便利なクラス
class MessageDAO{
    
    // データベースと接続を行うメソッド
    private static function get_connection(){
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
          );
        $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD, $options);
        return $pdo;
    }
    
    // データベースとの切断を行うメソッド
    private static function close_connection($pdo, $stmp){
        $pdo = null;
        $stmp = null;
    }
    
    // 全テーブル情報を取得するメソッド
    public static function get_all_messages(){
        $pdo = self::get_connection();
        $stmt = $pdo->query('SELECT * FROM messages ORDER BY id DESC');
        // フェッチの結果を、messageクラスのインスタンスにマッピングする
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Message');
        $messages = $stmt->fetchAll();
        self::close_connection($pdo, $stmp);
        // メッセージクラスのインスタンスの配列を返す
        return $messages;
    }
    
    // id値からデータを抜き出すメソッド
    public static function get_message_by_id($id){
        $pdo = self::get_connection();
        $stmt = $pdo->prepare('SELECT * FROM messages WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Message');
        $message = $stmt->fetch();
        self::close_connection($pdo, $stmp);
        // メッセージクラスのインスタンスを返す
        return $message;
    }
    
    // 画像ファイル名を取得するメソッド（uploadフォルダ内のファイルを物理削除するため）
    public static function get_image_name_by_id($id){
        $pdo = self::get_connection();
        $stmt = $pdo->prepare('SELECT * FROM messages WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Message');
        $message = $stmt->fetch();

        self::close_connection($pdo, $stmp);
        
        return $message->image;
    }
    
    // データを1件登録するメソッド
    public static function insert($message){
        $pdo = self::get_connection();
        $stmt = $pdo -> prepare("INSERT INTO messages (name, title, body, image) VALUES (:name, :title, :body, :image)");
        // バインド処理
        $stmt->bindParam(':name', $message->name, PDO::PARAM_STR);
        $stmt->bindParam(':title', $message->title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $message->body, PDO::PARAM_STR);
        $stmt->bindParam(':image', $message->image, PDO::PARAM_STR);
        $stmt->execute();
        self::close_connection($pdo, $stmp);
    }
    
    
    // データを更新するメソッド
    public static function update($message){
        $pdo = self::get_connection();
        $image = self::get_image_name_by_id($message->id);
        $stmt = $pdo->prepare('UPDATE messages SET title=:title, body=:body, image=:image WHERE id = :id');
                        
        $stmt->bindParam(':title', $message->title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $message->body, PDO::PARAM_STR);
        $stmt->bindParam(':image', $message->image, PDO::PARAM_STR);
        $stmt->bindParam(':id', $message->id, PDO::PARAM_INT);
        
        $stmt->execute();
        self::close_connection($pdo, $stmp);
        
        // 画像の物理削除
        if($image !== $message->image){
            unlink(IMAGE_DIR . $image);
        }
    }
    
    // データを削除するメソッド
    public static function delete($id){
        $pdo = self::get_connection();
        $image = self::get_image_name_by_id($id);
        
        $stmt = $pdo->prepare('DELETE FROM messages WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
        self::close_connection($pdo, $stmp);
        
        unlink(IMAGE_DIR . $image);

    }
    
    // ファイルをアップロードするメソッド
    public static function upload(){
        // ファイルを選択していれば
        if (!empty($_FILES['image']['name'])) {
            // ファイル名をユニーク化
            $image = uniqid(mt_rand(), true); 
            // アップロードされたファイルの拡張子を取得
            $image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1);

            $file = IMAGE_DIR . $image;

            // uploadディレクトリにファイル保存
            move_uploaded_file($_FILES['image']['tmp_name'], $file);
            
            return $image;
        }else{
            return null;
        }
    }
}
