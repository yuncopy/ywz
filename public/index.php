<?php
#define('APPLICATION_PATH', dirname(__FILE__));

define('APPLICATION_PATH', dirname(__DIR__));

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");
$application->bootstrap()->run();
?>
