<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Gender.php';
class GenderService extends Service
{
    public static function GetAllGenders()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Gender');
        $genders = [];

        while ($row = $stmt->fetch()) {
            $genders[] = new Gender($row['genderID'], $row['genderName']);
        }

        return $genders;
    }
    public static function GetGenderById(int $genderID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Gender WHERE genderID = ' . $genderID);
        $row = $stmt->fetch();
        return new Gender($row['genderID'], $row['genderName']);
    }
}
?>
