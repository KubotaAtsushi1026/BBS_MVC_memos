<?php
    // Controller //
    
    // セッション開始
    session_start();
    
    // セッションからエラーメッセージを取得、session情報破棄
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = null;
    
    // view のインクルード
    include_once 'views/new_view.php';
