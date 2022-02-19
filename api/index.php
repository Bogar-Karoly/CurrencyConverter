<?php

include_once 'config.php';

spl_autoload_register(function($class) {
    include_once str_replace("\\", "/", $class).".php";
});

$app = new Application();
$app->run();

?>