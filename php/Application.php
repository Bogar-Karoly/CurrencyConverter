<?php

class Application {
    public static Application $app;
    public static Database $db;
    public Request $request;

    function __construct() {
        self::$app = $this;
        self::$db = new Database;
        $this->request = new Request;
    }

    public function run() {
        echo $this->request->resolve();
    }
}

?>