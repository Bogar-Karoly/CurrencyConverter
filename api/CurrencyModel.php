<?php

class CurrencyModel extends DbModel {

    public static function tableName() {
        return "currencies";
    }
    public static function attributes() {
        return ['name', 'value'];
    }
}


?>