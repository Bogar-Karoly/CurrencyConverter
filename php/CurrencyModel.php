<?php

class CurrencyModel extends DbModel {

    public Int $id;
    public String $name;
    public Float $value;

    public static function tableName() {
        return "currencies";
    }
    public static function attributes() {
        return ['name', 'value'];
    }
}


?>