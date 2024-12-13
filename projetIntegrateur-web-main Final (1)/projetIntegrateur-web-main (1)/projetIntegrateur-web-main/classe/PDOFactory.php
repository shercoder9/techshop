<?php
define('MYSQL_SERVER', 'mysql:host=localhost;dbname=dbTechShop;charset=utf8');
define('SQL_USER', 'root');
define('SQL_PASS', '');

class PDOFactory {
    public static function getMySQLConnection() {
        try {
            $db = new PDO(MYSQL_SERVER, SQL_USER, SQL_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo "Error: Unable to connect to the database. " . $e->getMessage();
            exit();  
        }
    }
}
?>
