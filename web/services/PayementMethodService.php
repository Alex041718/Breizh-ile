<?php

require_once 'Service.php';
require_once __ROOT__.'/models/PayementMethod.php';


class PayementMethodService extends Service
{
    public static function getAllPayementMethod(): array{
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _PaymentMethod');
        $payementMethodList = [];

        while ($row = $stmt->fetch()) {
            $payementMethodList[] = new PayementMethod($row['payMethodID'], $row['label']);
        }

        return $payementMethodList;

    }

    public static function GetPayementMethodById($payMethodID): PayementMethod
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _PaymentMethod WHERE payMethodID = ' . $payMethodID);
        $row = $stmt->fetch();
        return new PayementMethod($row['payMethodID'], $row['label']);
    }
}