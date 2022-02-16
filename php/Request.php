<?php

class Request {
    public function resolve() {
        if(!isset($_GET['api']) || empty($_GET['api'])) {
            http_response_code(404);
            return "Missing param!";
        }
        $controller = new Controller;
        $param = $this->getBody();
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