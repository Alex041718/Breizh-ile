<?php
// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Perimeter.php';

class PerimeterService extends Service
{
    public static function GetAllPerimeters()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Perimeter');
        $perimeters = [];

        while ($row = $stmt->fetch()) {
            $perimeters[] = new Perimeter($row['perimeterID'], $row['label']);
        }

        return $perimeters;
    }
    public static function GetPerimeterById(int $perimeterID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Perimeter WHERE perimeterID = ' . $perimeterID);
        $row = $stmt->fetch();

        return new Perimeter($row['perimeterID'], $row['label']);
    }

    public static function GetAllPerimetersAsArrayOfString()
    {
        $perimeters = self::GetAllPerimeters();
        $perimetersStrings = [];

        foreach ($perimeters as $perimeter) {
            $perimetersStrings[] = $perimeter->getLabel();
        }

        return $perimetersStrings;
    }
}
