 <?php 
 
    // controller
    
    // 外部ファイルの読み込み   
    require_once 'MessageDAO.php';

    // セッション開始
    session_start();
    
    // 投稿一覧を保存する配列
    $messages = array();

    // フラッシュメッセージを保存する変数
    $flash_message = "";

    // 例外処理
    try {

        // 投稿一覧を取得
        $messages = MessageDAO::get_all_messages();
        
        // セッションからフラッシュメッセージの取得、削除
        if(isset($_SESSION['flash_message']) === true){
            $flash_message = $_SESSION['flash_message'];
            $_SESSION['flash_message'] = null;
        }
        
        // view のインクルード
        include_once 'index_view.php';
        
    } catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
    }
    
    