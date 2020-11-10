<?php 

    // controller
    
    // 外部ファイルの読み込み
    require_once 'MessageDAO.php';
    
    // セッション開始
    session_start();
    
    // POST通信ならば
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        // 入力値を取得
        $id = $_POST['id'];
        $name = $_POST['name'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        
        // 画像アップロード
        $image = MessageDAO::upload();
        
        // メッセージインスタンス作成
        $message = new Message($name, $title, $body, $image);
        
        // idをセット
        $message->id = $id;
        
        // 更新
        MessageDAO::update($message);
        
        // フラッシュメッセージのセット
        $_SESSION['flash_message'] = '投稿の更新が完了しました';
        
        // 画面遷移
        header('Location: show.php?id=' . $id);
        exit;
        
    }else{
        
        // フラッシュメッセージのセット
        $_SESSION['flash_message'] = '不正アクセスです';
        
        // 画面遷移
        header('Location: index.php');
        exit;
    }