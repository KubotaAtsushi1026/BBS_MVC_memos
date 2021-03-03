<?php
    // Controller
    
    // 外部ファイルの読み込み
    require_once 'filters/post_filter.php';
    require_once 'daos/MessageDAO.php';
    
    // セッションスタート
    session_start();
    
    // 飛んできたidを取得
    $id = $_POST['id'];
        
    // idを指定せずに実行されたならば
    if($id === ""){
        $_SESSION['error'] = '不正アクセスです';
        header('Location: index.php');
        exit;
    }
    
    // 注目してるメッセージインスタンスを取得
    $message = MessageDAO::get_message_by_id($id);
    
    // そのような投稿が存在すれば
    if($message !== false){
        // データベースからデータ削除
        $flash_message = MessageDAO::delete($id);
        
        // フラッシュメッセージのセット
        $_SESSION['flash_message'] = $flash_message;
        
        // 画面遷移
        header('Location: index.php');
        exit;

    }else{
        $_SESSION['error'] = '存在しない投稿です';
        header('Location: index.php');
        exit;
    }

    