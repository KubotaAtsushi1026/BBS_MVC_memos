<?php

    // controller
    
    // 外部ファイルの読み込み
    require_once 'MessageDAO.php';
    
    // セッション開始
    session_start();
    
    // 注目している投稿のID
    $message_id = "";
    
    // 注目している投稿
    $message = "";

    // 注目している投稿のIDを取得
    if(isset($_GET['id']) === true){
        $message_id = $_GET['id'];
    }else{
        // 画面遷移
        header('Location: index.php');
        exit;
    }
    // 例外処理
    try {
        
        // 注目しているメッセージインスタンスの取得
        $message = MessageDAO::get_message_by_id($message_id);
        
        // view のインクルード
        include_once 'edit_view.php';
    
    } catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
    }
