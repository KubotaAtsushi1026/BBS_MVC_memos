<?php
    // Controller //
    
    // 外部ファイルの読み込み
    require_once 'models/Message.php';
    
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
        // セッションにエラー目セージを保存
        $_SESSION['error'] = 'IDが指定されていません';
        // リダイレクト
        header('Location: index.php');
        exit;
    }

    // 注目してるメッセージインスタンスを取得
    $message = Message::find($id);

    // そのような投稿が存在すれば
    if($message !== false){
        // view の表示
        include_once 'views/show_view.php';
    }else{
        // セッションにエラーメッセージを保存
        $_SESSION['error'] = '存在しない投稿です';
        // リダイレクト
        header('Location: index.php');
        exit;
    }
    