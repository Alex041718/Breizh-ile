<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Address.php';
class AddressService extends Service
{

    // Create a new address
    public static function CreateAddress(Address $address): Address
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Address (city, postalCode, postalAddress) VALUES (:city, :postalCode, :postalAddress)');
        $stmt->execute([
            'city' => $address->getCity(),
            'postalCode' => $address->getPostalCode(),
            'postalAddress' => $address->getPostalAddress()
        ]);

        return new Address($pdo->lastInsertId(), $address->getCity(), $address->getPostalCode(), $address->getPostalAddress());
    }
    public static function GetAllAddresses(): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Address');
        $addresses = [];

        while ($row = $stmt->fetch()) {
            $addresses[] = new Address($row['addressID'], $row['city'], $row['postalCode'], $row['postalAddress']);
        }

        return $addresses;
    }

    public static function GetAddressById(int $addressID): Address
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Address WHERE addressID = ' . $addressID);
        $row = $stmt->fetch();
        return new Address($row['addressID'], $row['city'], $row['postalCode'], $row['postalAddress']);
    }
}
?>
