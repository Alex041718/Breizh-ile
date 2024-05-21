<?php

require_once 'Service.php';
require_once 'ImageService.php';
require_once 'AddressService.php';
require_once 'GenderService.php';
require_once __ROOT__.'/models/Client.php';

class ClientService extends Service
{
    public static function CreateClient(Client $client) : Client
    {
        $image = ImageService::CreateImage($client->getImage());
        $address = AddressService::CreateAddress($client->getAddress());

        $client->setImage($image);
        $client->setAddress($address);

        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _User (mail, firstname, lastname, nickname, password, phoneNumber, birthDate, consent, lastConnection, creationDate, imageID, genderID, addressID) VALUES (:mail, :firstname, :lastname, :nickname, :password, :phoneNumber, :birthDate, :consent, :lastConnection, :creationDate, :imageID, :genderID, :addressID)');

        $stmt->execute(array(
            'mail' => $client->getMail(),
            'firstname' => $client->getFirstname(),
            'lastname' => $client->getLastname(),
            'nickname' => $client->getNickname(),
            'password' => $client->getPassword(),
            'phoneNumber' => $client->getPhoneNumber(),
            'birthDate' => $client->getBirthDate()->format('Y-m-d H:i:s'),
            'consent' => $client->getConsent(),
            'lastConnection' => $client->getLastConnection()->format('Y-m-d H:i:s'),
            'creationDate' => $client->getCreationDate()->format('Y-m-d H:i:s'),
            'imageID' => $client->getImage()->getImageID(),
            'genderID' => $client->getGender()->getGenderID(),
            'addressID' => $client->getAddress()->getAddressID()
        ));

        $current_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare('INSERT INTO _Client (clientID, isBlocked) VALUES (:clientID, :isBlocked);');

        $stmt->execute(array(
            'clientID' => $current_id,
            'isBlocked' => $client->getIsBlocked()
        ));

        return new Client($current_id, $client->getIsBlocked(), $client->getMail(), $client->getFirstname(), $client->getLastname(), $client->getNickname(), $client->getPassword(), $client->getPhoneNumber(), $client->getBirthDate(), $client->getConsent(), $client->getLastConnection(), $client->getCreationDate(), $client->getImage(), $client->getGender(), $client->getAddress());
    }

    public static function GetAllClients()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM Client');
        $clients = [];

        while ($row = $stmt->fetch()) {
            $clients[] = self::ClientHandler($row);
        }

        return $clients;
    }

    public static function GetClientById(int $clientID) : CLient
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM Client WHERE clientID = ' . $clientID);
        $row = $stmt->fetch();
        // retourne une erreur si le client n'existe pas
        if (!$row) {
            throw new Exception('Client not found');
        }
        return self::ClientHandler($row);
    }
    
    public static function ClientHandler(array $row): Client
    {
        $gender = GenderService::GetGenderById($row['genderID']);
        $address = AddressService::GetAddressById($row['addressID']);
        $image = ImageService::GetImageById($row['imageID']);


        return new Client($row['clientID'], $row['isBlocked'], $row['mail'], $row['firstname'], $row['lastname'], $row['nickname'], $row['password'], $row['phoneNumber'], new DateTime($row['birthDate']), $row['consent'], new DateTime($row['lastConnection']), new DateTime($row['creationDate']), $image, $gender, $address);
    }
}

?>
