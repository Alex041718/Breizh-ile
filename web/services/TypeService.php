<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Type.php';
class TypeService extends Service
{
    public static function GetAllTypes()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Type');
        $types = [];

        while ($row = $stmt->fetch()) {
            $types[] = new Type($row['typeID'], $row['label']);
        }

        return $types;
    }
    public static function GetTypeById(int $typeID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Type WHERE typeID = ' . $typeID);
        $row = $stmt->fetch();
        return new Type($row['typeID'], $row['label']);
    }
}
