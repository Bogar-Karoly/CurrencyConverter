<?php

error_reporting(E_ALL & ~E_NOTICE);

include_once 'config.php';

spl_autoload_register(function($class) {
    include_once str_replace("\\", "/", $class).".php";
});

$app = new Application();
$app->run();

?>