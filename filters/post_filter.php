<?php
    
    // POST通信の時だけアクセスできるようにするfilter
    
    // セッション開始
    session_start();
    // GET通信ならば
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        
        // セッションにエラーをセット
        $_SESSION['error'] = '不正アクセスです';
        
        // 画面遷移
        header('Location: index.php');
        exit;
        
    }