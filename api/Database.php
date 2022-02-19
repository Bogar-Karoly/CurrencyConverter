<?php


class Database {
    public PDO $pdo;

    function __construct() {
        $this->pdo = new PDO("mysql:host=".db_host.";port=".db_port.";dbname=".db_name.";charset=".db_charset, db_username, db_password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}


?>