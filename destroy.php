<?php
    // Controller
    
    // 外部ファイルの読み込み
    require_once 'filters/post_filter.php';
    require_once 'models/Message.php';
    
    // セッションスタート
    session_start();
    
    // 飛んできたidを取得
    $id = $_POST['id'];
        
    // idを指定せずに実行されたならば
    if($id === ""){
        // セッションにエラーメッセージを保存
        $_SESSION['error'] = '不正アクセスです';
        // リダイレクト
        header('Location: index.php');
        exit;
    }
    
    // 注目してるメッセージインスタンスを取得
    $message = Message::find($id);
    
    // そのような投稿が存在すれば
    if($message !== false){
        // データベースからデータ削除
        $flash_message = Message::destroy($id);
        
        // フラッシュメッセージのセット
        $_SESSION['flash_message'] = $flash_message;
        
        // リダイレクト
        header('Location: index.php');
        exit;

    }else{
        // エラーメッセージのセット
        $_SESSION['error'] = '存在しない投稿です';
        // リダイレクト
        header('Location: index.php');
        exit;
    }

    