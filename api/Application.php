<?php

class Application {
    public Request $request;
    public ApiError $error;
    //public Response $response;
    public static Application $app;
    public static Database $db;

    function __construct() {
        //$this->response = new Response;
        $this->error = new ApiError;
        $this->request = new Request;
        self::$db = new Database;
        self::$app = $this;
    }

    public function run() {
        echo $this->request->resolve();
    }
}

?>