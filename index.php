<?php 
    // Controller //
    
    // 外部ファイルの読み込み   
    require_once 'models/Message.php';

    // セッション開始
    session_start();
    
    // Modelを使って投稿一覧を取得
    $messages = Message::all();
    
    // セッションからフラッシュメッセージの取得、削除
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;
    
    // セッションからエラーメッセージの取得、削除
    $error = $_SESSION['error'];
    $_SESSION['error'] = null;
    
    // view の表示
    include_once 'views/index_view.php';
        
    
    