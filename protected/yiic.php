<?php
defined('YII_DEBUG') or define('YII_DEBUG',true);
// change the following paths if necessary
$yiic=dirname(__FILE__).'/../../YII/yii.php';
$config=dirname(__FILE__).'/config/console.php';

require_once($config);
//require_once($yiic);
YII::createConsoleApplication($config)->run();
