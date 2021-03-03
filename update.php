<?php 
    // Controller
    
    // 外部ファイルの読み込み
    require_once 'filters/post_filter.php';
    require_once 'daos/MessageDAO.php';
    
    // セッション開始
    session_start();
    
    // フォームからの入力値を取得
    $id = $_POST['id'];
    
    // 注目してるメッセージインスタンスを取得
    $message = MessageDAO::get_message_by_id($id);

    // そのような投稿が存在すれば
    if($message !== false){
        // 入力データの取得
        $name = $_POST['name'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        
        // 画像が選択されていれば
        if($_FILES['image']['size'] !== 0){
            // 画像ファイルの物理的アップロード処理
            $image = MessageDAO::upload();
        }else {
            $image = $message->image;
        }
        
        // インスタンス情報の更新
        $message->name = $name;
        $message->title = $title;
        $message->body = $body;
        $message->image = $image;
        
        // 入力チェック
        $errors = MessageDAO::validate($message);
        
        // 入力エラーが1つもなければ
        if(count($errors) === 0){
            // データベースを更新
            $flash_message = MessageDAO::update($message);
            
            // セッションにフラッシュメッセージを保存        
            $_SESSION['flash_message'] = $flash_message;
            
            // 画面遷移
            header('Location: show.php?id=' . $id);
            exit;
            
        }else{
            // セッションにエラー配列をセット
            $_SESSION['errors'] = $errors;
            // 画面遷移
            header('Location: edit.php?id=' . $id);
            exit;
        }
        
    }else{
        $_SESSION['error'] = '存在しない投稿です';
        header('Location: index.php');
        exit;
    }
