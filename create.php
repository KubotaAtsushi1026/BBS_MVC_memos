<?php
    // Controller //
    
    // セッション開始
    session_start();
    
    // セッションからエラーメッセージを取得、session情報破棄
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    
    // view の表示
    include_once 'views/create_view.php';
