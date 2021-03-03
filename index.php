<?php 
    // Controller //
    
    // 外部ファイルの読み込み   
    require_once 'daos/MessageDAO.php';

    // セッション開始
    session_start();
    
    // 投稿一覧を取得
    $messages = MessageDAO::get_all_messages();
    
    // セッションからフラッシュメッセージの取得、削除
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;
    
    // セッションからエラーメッセージの取得、削除
    $error = $_SESSION['error'];
    $_SESSION['error'] = null;
    
    // view のインクルード
    include_once 'views/index_view.php';
        
    
    