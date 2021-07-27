<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>簡易掲示板</title>
    </head>
    <body>
        <div class="container">
            <div class="row mt-3">
                <h1 class=" col-sm-12 text-center">投稿一覧</h1>
            </div>
            
            <?php if($flash_message !== null): ?>
            <div class="row mt-2">
                <h2 class="text-center col-sm-12"><?= $flash_message ?></h1>
            </div>
            <?php endif; ?>
            <?php if($error !== null): ?>
            <div class="row mt-2">
                <h2 class="text-center col-sm-12"><?= $error ?></h1>
            </div>
            <?php endif; ?>
            
            <div class="row mt-2">
            <?php if($messages !== null): ?>
            <?php if(count($messages) !== 0): ?> 
                <table class="col-sm-12 table table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <th>ユーザ名</th>
                        <th>タイトル</th>
                        <th>内容</th>
                        <th>投稿時間</th>
                    </tr>
                    </tr>
                <?php foreach($messages as $message): ?>
                    <tr>
                        <td><a href="show.php?id=<?= $message->id ?>"><?= $message->id ?></a></td>
                        <td><?= $message->name ?></td>
                        <td><?= $message->title ?></td>
                        <td><?= $message->body ?></td>
                        <td><?= $message->created_at ?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            <?php else: ?>
                    <p>データ一件もありません。</p>
            <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="row mt-5">
                <a href="create.php" class="btn btn-primary">新規投稿</a>
            </div> 
        </div>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS, then Font Awesome -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>
