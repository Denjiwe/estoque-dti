<?php

    class Conexao {
    private static $host = "db";
    private static $username = "root";
    private static $password = "root";
    private static $db = "db_estoque-dti";

    private static $conexao = null;

    private function __construct() {} 

    public static function getConexao() {
        if (!isset(self::$conexao)) {
            self::$conexao = new PDO("mysql:host=". self::$host.";dbname=".self::$db, self::$username, self::$password);
            self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conexao;
    }

}

/*try {
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}*/