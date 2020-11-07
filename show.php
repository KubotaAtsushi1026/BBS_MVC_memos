<?php

    // 外部ファイルの読み込み
    require_once 'MessageDAO.php';
    
    // セッション開始
    session_start();
    
    // 注目している投稿のID
    $message_id = "";
    
    // 注目している投稿
    $message = "";

    // フラッシュメッセージを保存する変数
    $flash_message = "";
    
    // セッションからフラッシュメッセージの取得、削除
    if(isset($_SESSION['flash_message']) === true){
        $flash_message = $_SESSION['flash_message'];
        $_SESSION['flash_message'] = null;
    }

    // 注目している投稿のIDを取得
    if(isset($_GET['id']) === true){
        $message_id = $_GET['id'];
    }else{
        // 画面遷移
        header('Location: index.php');
        exit;
    }
    
    // 例外処理
    try {
        
        // 注目してるメッセージインスタンスを取得
        $message = MessageDAO::get_message_by_id($message_id);
    
    } catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
    }

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="shortcut icon" href="favicon.ico">

        <title>投稿詳細</title>
        <style>
            h2{
                color: red;
                background-color: pink;
            }
            img{
                width: 60%;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row mt-2">
                <h1 class="text-center col-sm-12">id: <?= $message_id ?> の投稿詳細</h1>
            </div>
            <div class="row mt-2">
                <h2 class="text-center col-sm-12"><?= $flash_message ?></h1>
            </div>
            <div class="row mt-2">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>id</th>
                        <td><?= $message->id ?></td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td><?= $message->name ?></td>
                    </tr>
                    <tr>
                        <th>タイトル</th>
                        <td><?= $message->title ?></td>
                    </tr>
                    <tr>
                        <th>内容</th>
                        <td><?= $message->body ?></td>
                    </tr>
                    <tr>
                        <th>画像</th>
                        <td><img src="<?= IMAGE_DIR . $message->image ?>" alt="表示する画像がありません。"></td>
                    </tr>
                </table>
            </div> 
            
            <div class="row">
                <a href="edit.php?id=<?= $message_id ?>" class="col-sm-6 btn btn-primary">編集</a>
                <form class="col-sm-6" action="delete.php" method="POST">
                    <input type="hidden" name="id" value="<?= $message_id ?>">
                    <button type="submit" class="btn btn-danger col-sm-12" onclick="return confirm('投稿を削除します。よろしいですか？')">削除</button>
                </form>
            </div>       
        
             <div class="row mt-5">
                <a href="index.php" class="btn btn-primary">投稿一覧</a>
            </div>
        </div>
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS, then Font Awesome -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script>
            function previewImage(obj)
            {
            	var fileReader = new FileReader();
            	fileReader.onload = (function() {
            		document.getElementById('preview').src = fileReader.result;
            	});
            	fileReader.readAsDataURL(obj.files[0]);
            }
        </script>
    </body>
</html>