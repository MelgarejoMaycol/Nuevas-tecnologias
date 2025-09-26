<?php
// 🔹 Configuración de la base de datos en InfinityFree
define('DB_HOST', 'sqlXXX.infinityfree.com');
define('DB_NAME', 'if0_40027615_proyecto_tickets');
define('DB_USER', 'if0_40027615'); 
define('DB_PASS', 'uZQW4GamAf1cl7'); 

define('APP_URL', 'https://proyectoticketsuts.page.gd');

class Database {
    public static function getConnection() {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            return new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            die("❌ Error de conexión: " . $e->getMessage());
        }
    }
}
?>
