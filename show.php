<?php
    // Controller //
    
    // 外部ファイルの読み込み
    require_once 'daos/MessageDAO.php';
    
    // セッション開始
    session_start();
    
    // フラッシュメッセージを保存する変数
    $flash_message = "";
    
    // セッションからフラッシュメッセージの取得、削除
    $flash_message = $_SESSION['flash_message'];
    $_SESSION['flash_message'] = null;

    // 注目している投稿のIDを取得
    $id = $_GET['id'];
    
    // idを指定せずに実行されたならば
    if($id === "" || $id === null){
        $_SESSION['error'] = 'IDが指定されていません';
        header('Location: index.php');
        exit;
    }

    // 注目してるメッセージインスタンスを取得
    $message = MessageDAO::get_message_by_id($id);

    // そのような投稿が存在すれば
    if($message !== false){
        // view のインクルード
        include_once 'views/show_view.php';
    }else{
        $_SESSION['error'] = '存在しない投稿です';
        header('Location: index.php');
        exit;
    }
    

    
    