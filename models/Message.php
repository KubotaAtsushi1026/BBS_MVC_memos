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
    }