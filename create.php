<?php

    // controller
    
    // 外部ファイルの読み込み
    require_once 'MessageDAO.php';

    // セッション開始
    session_start();

    // POST通信ならば（= 新規投稿ボタンが押された時）
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        // フォームからの入力値を取得
        $name = $_POST['name'];
        $title = $_POST['title'];
        $body = $_POST['body'];

        // 例外処理
        try {

            // 画像ファイルの物理的アップロード処理
            $image = MessageDAO::upload();
            
            // 新しいメッセージインスタンスを生成
            $message = new Message($name, $title, $body, $image);

            // データベースにデータを1件保存
            MessageDAO::insert($message);
            
            // セッションにフラッシュメッセージを保存        
            $_SESSION['flash_message'] = "投稿が成功しました。";
            
            // 画面遷移
            header('Location: index.php');
            exit;
            
        } catch (PDOException $e) {
            echo 'PDO exception: ' . $e->getMessage();
            exit;
        }
    }else{
        // フラッシュメッセージのセット
        $_SESSION['flash_message'] = '不正アクセスです';
        
        // 画面遷移
        header('Location: index.php');
        exit;
    }
    