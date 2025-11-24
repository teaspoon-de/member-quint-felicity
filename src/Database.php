<?php

class Database {

    private static ?PDO $pdo = null;

    public static function getConnection(): PDO {
        if (self::$pdo === null) {
            $host = "localhost";
            $db = "quint_felicity";
            $user = "www_quint_felicity";
            $pass = "YqDW4k6EMKp1lBS8IatiP0lh2Mruvohe";
            $charset = "utf8";

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,   
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                die("DB-Verbindung fehlgeschlagen: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

}

?>