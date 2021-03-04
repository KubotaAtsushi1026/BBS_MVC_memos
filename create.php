<?php
    // Controller //
    
    // 外部ファイルの読み込み
    require_once 'filters/post_filter.php';
    require_once 'daos/MessageDAO.php';

    // セッション開始
    session_start();

    // フォームからの入力値を取得
    $name = $_POST['name'];
    $title = $_POST['title'];
    $body = $_POST['body'];

    // 画像が選択されていれば
    if($_FILES['image']['size'] !== 0){
        // 画像ファイルの物理的アップロード処理
        $image = MessageDAO::upload();
    }else {
        $image = "";
    }
        
    // 新しいメッセージインスタンスを生成
    $message = new Message($name, $title, $body, $image);

    // 入力チェック
    $errors = $message->validate($message);

    // 入力エラーが1つもなければ
    if(count($errors) === 0){
        // データベースにデータを1件保存
        $flash_message = MessageDAO::insert($message);
        
        // セッションにフラッシュメッセージを保存        
        $_SESSION['flash_message'] = $flash_message;
        
        // 画面遷移
        header('Location: index.php');
        exit;
    }else{
        // セッションにエラー配列をセット
        $_SESSION['errors'] = $errors;
        // 画面遷移
        header('Location: new.php');
        exit;
    }