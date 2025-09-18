<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'app_db');
define('DB_USER', 'root'); 
define('DB_PASS', '');

define('APP_URL', 'http://localhost/PROYECTO_MVC');

class Database {
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'app_db';
        $user = 'root';
        $pass = '';
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        try {
            return new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
