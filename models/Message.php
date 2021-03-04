<?php
    // Model //
    // 一件分のデータを格納するクラス
    class Message{
        // プロパティ
        public $id;
        public $name;
        public $title;
        public $body;
        public $image;
        public $created_at;
        
        // コンストラクタ
        public function __construct($name="", $title="", $body="", $image=""){
            $this->name = $name;
            $this->title = $title;
            $this->body = $body;
            $this->image = $image;
        }
        
        // 入力チェック
        public function validate(){
            
            // エラー配列を空で作成
            $errors = array();
            
            // 名前が入力されていなければ
            if($this->name === ''){
                $errors[] = '名前を入力してください';
            }
            // タイトルが入力されていなければ
            if($this->title === ''){
                $errors[] = 'タイトルを入力してください';
            }
            // 本文が入力されていなければ
            if($this->body === ''){
                $errors[] = '本文を入力してください';
            }
            // 画像が選択されていなければ
            if($this->image === ''){
                $errors[] = '画像を選択してください';
            }
            
            // エラー配列を返す
            return $errors;
        }
    }