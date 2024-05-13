<?php


use PDO;


class Service {

    public static function getPDO() {
        // Remplacez ces valeurs par vos informations de connexion
        $host = 'db';
        $db   = 'db';
        $user = 'user';
        $pass = 'pass';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new PDO($dsn, $user, $pass, $options);
    }


}
?>
