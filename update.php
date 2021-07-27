<?php 
    // Controller
    
    // 外部ファイルの読み込み
    require_once 'filters/post_filter.php';
    require_once 'models/Message.php';
    
    // セッション開始
    session_start();
    
    // フォームからの入力値を取得
    $id = $_POST['id'];
    
    // 注目してるメッセージインスタンスを取得
    $message = Message::find($id);

    // そのような投稿が存在すれば
    if($message !== false){
        // 入力データの取得
        $name = $_POST['name'];
        $title = $_POST['title'];
        $body = $_POST['body'];
        $image = $_FILES['image']['name'];
        
        // 画像が選択されていれば
        if($_FILES['image']['size'] === 0){
            $image = $message->image;
        }else{
            // 前回の画像ファイル名を取得
            $pre_image = $message->image;
        }
        
        // インスタンス情報の更新
        $message->name = $name;
        $message->title = $title;
        $message->body = $body;
        $message->image = $image;
        
        // 入力チェック
        $errors = $message->validate();
        
        // 入力エラーが1つもなければ
        if(count($errors) === 0){
            // 新しい画像が選択されていれば
            if($_FILES['image']['size'] !== 0){
                // 前回の画像の物理削除
                unlink(IMAGE_DIR . $pre_image);
                // 新規画像の物理的アップロード
                $image = Message::upload();
                // インスタンスの画像ファイル名の更新
                $message->image = $image;
            }
            
            // データベースの更新
            $flash_message = $message->save();
            
            // セッションにフラッシュメッセージを保存        
            $_SESSION['flash_message'] = $flash_message;
            
            // リダイレクト
            header('Location: show.php?id=' . $id);
            exit;
            
        }else{
            // セッションにエラー配列をセット
            $_SESSION['errors'] = $errors;
            // リダイレクト
            header('Location: edit.php?id=' . $id);
            exit;
        }
        
    }else{
        // セッションにエラーメッセージをセット
        $_SESSION['error'] = '存在しない投稿です';
        // リダイレクト
        header('Location: index.php');
        exit;
    }
