<?php

class PartProducer extends CModel{
    public $name;
    public $id;
    public $producer;
    
    public function attributeNames(){
        return array('id','name','producer');
    }
}

