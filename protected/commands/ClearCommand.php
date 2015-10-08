<?php

class ClearCommand extends CConsoleCommand{

  public function run($args){
    $cahce = Yii::app()->cache;
    $keys = $cache->keys("parts659_*");
    var_dump($keys);
  }

}
