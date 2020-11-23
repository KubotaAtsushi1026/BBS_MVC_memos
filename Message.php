<?php
    class Message{
        public $id;
        public $name;
        public $title;
        public $body;
        public $image;
        public $created_at;
        
        public function __construct($name="", $title="", $body="", $image=""){
            $this->name = $name;
            $this->title = $title;
            $this->body = $body;
            $this->image = $image;
        }
    }