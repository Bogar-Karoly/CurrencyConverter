<?php

class Response {
    public function __construct(Bool $success, Array $param) {
        $this->success = $success;
        if(!$success) {
            $this->error = $param;
        } else {
            foreach($param as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}

?>