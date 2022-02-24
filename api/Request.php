<?php

class Request {
    public function resolve() {
        $param = $this->getBody();
        //print_r($param);
        if(!isset($param['api']) || empty($param['api'])) {
            http_response_code(404);
            return "Missing param!";
        }
        $controller = new Controller;
        if(!method_exists($controller, $param['api']))
            return new Response(false,Application::$app->error->getErrorByCode(101));
        return json_encode($controller->{$param['api']}($param));
    }
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
    public function getBody() {
        $body = [];
        if($this->getMethod() === 'get') {
            foreach($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if($this->getMethod() === 'post') {
            foreach($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}

?>