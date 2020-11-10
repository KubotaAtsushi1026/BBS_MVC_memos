<?php

    // controller
    
    // 外部ファイルの読み込み
    require_once 'MessageDAO.php';
    
    // セッションスタート
    session_start();
    
    // 削除する投稿のID
    $message_id = "";
    
    // POST通信でid値が飛んできたのであれば、
    if(isset($_POST['id']) === true){
        
        // 飛んできたidを取得
        $message_id = $_POST['id'];
        
        // 削除
        MessageDAO::delete($message_id);
        
        // フラッシュメッセージのセット
        $_SESSION['flash_message'] = '投稿を削除しました';
        
        // 画面遷移
        header('Location: index.php');
        exit;
        
    }else{
        
        $_SESSION['flash_message'] = '不正アクセスです';
        // 画面遷移
        header('Location: index.php');
        exit;
        
    }
    