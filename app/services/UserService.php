<?php
namespace services;

require_once 'Service.php';
require_once '../models/User.php';

use model\User;

//use services\Service;


class UserService extends Service {

    public static function GetAllUsers() {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _User');
        $users = [];

        while ($row = $stmt->fetch()) {
            $users[] = new User($row['id'], $row['name'], $row['firstName'], $row['lastName'], $row['email'], $row['password'], $row['role']);
        }

        return $users;
    }
}

?>