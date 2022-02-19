<?php

abstract class DbModel {
    abstract public static function attributes();
    abstract public static function tableName();

    public static function prepare($query) {
        return Application::$db->pdo->prepare($query);
    }
    
    public static function find(Array $condition) {
        $tablename = static::tableName();
        $where = array_map(function($k) { return "$k = :$k"; },array_keys($condition));
        $stmt = self::prepare("SELECT * FROM $tablename WHERE ".implode(' AND ',$where)."");
        foreach($condition as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute() && $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_CLASS) : false;
    }
    public static function first(Array $condition = [], Array $order = []) {
        $tablename = static::tableName();
        $where = empty($condition) ? "" : "WHERE ".implode(' AND ',array_map(function($k) { return "$k = :$k"; },array_keys($condition)));
        $order = empty($order) ? "" : "ORDER BY ".implode(' , ',array_map(function($k,$v) { return "$k $v"; }, array_keys($order), $order));
        $stmt = self::prepare("SELECT * FROM $tablename $where $order LIMIT 1");
        foreach($condition as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute() && $stmt->rowCount() === 1 ? $stmt->fetch(PDO::FETCH_OBJ) : false;
    }
    public static function all() {
        $tablename = static::tableName();
        $stmt = self::prepare("SELECT * FROM $tablename");
        return $stmt->execute() && $stmt->rowCount() > 0 ? $stmt->fetchAll(PDO::FETCH_CLASS) : false;
    }
    public static function save(Array $values = []) {
        $tablename = static::tableName();
        $attributes = array_map(function($e) { 
            if(isset($values[$e]))
                return $e;
        },static::attributes());
        $params = array_map(function($e){ return ":$e"; },$values);
        $stmt = self::prepare("INSERT INTO $tablename (".implode(',', $attributes).") VALUES (".implode(',',$params).")");
        foreach($attributes as $attr) {
            if(isset($values[$attr]))
                $stmt->bindValue(":$attr", $values[$attr]);
        }
        return $stmt->execute() && $stmt->rowCount() > 0 ? true : false;
    }
    
    public static function update($condition, $values) {
        $tablename = static::tableName();
        $attributes = array_filter(static::attributes(),function($e) use ($values) { 
            return isset($values[$e]) && !empty($values[$e]) && $values[$e] || isset($values[$e]) && empty($values[$e]) && $values[$e] === null; 
        }); // ignores properties with null or no value
        $where = array_map(function($k) { return "$k = :$k"; }, array_keys($condition));
        $attributes = array_map(function($e){ return "$e = :$e"; },$attributes);
        $stmt = self::prepare("UPDATE $tablename SET ".implode(',',$attributes)." WHERE ".implode(' AND ',$where)."");
        foreach($condition as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach($values as $key => $value) {
                $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute() && $stmt->rowCount() !== 0 ? true : false;
    }
    
}

?>