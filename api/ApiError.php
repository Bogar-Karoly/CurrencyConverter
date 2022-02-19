<?php

class ApiError {
    protected function getErrorMessage() {
        return [
            ['code' => 101,'type' => 'api-request','info' => 'Invalid request!'],
            ['code' => 110,'type' => 'from-input','info' => 'Invalid currency!'],
            ['code' => 111,'type' => 'to-input','info' => 'Invalid currency!'],
            ['code' => 112,'type' => 'input','info' => 'Invalid value!'],
        ];
    }
    public function getErrorByCode(Int $code) {
        return end(array_filter(self::getErrorMessage(), function($e) use ($code) { return $e['code'] === $code; }));
    }
}

?>