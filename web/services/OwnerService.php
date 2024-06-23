<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Owner.php';
require_once 'ImageService.php';
require_once 'AddressService.php';
require_once 'GenderService.php';

class OwnerService extends Service
{

    public static function CreateOwner(Owner $owner) : Owner
    {
        // Étape 1 : Enregistrer en base l'image, l'adresse de l'owner
        $image = ImageService::CreateImage($owner->getImage());
        $address = AddressService::CreateAddress($owner->getAddress());
        $lastConnection = $owner->getLastConnection() ? $owner->getLastConnection()->format('Y-m-d H:i:s') : null;

        $owner->setImage($image);
        $owner->setAddress($address);

        // Étape 2 : Enregistrer en base l'owner

        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _User (mail, firstname, lastname, nickname, password, phoneNumber, birthDate, consent, lastConnection, creationDate, imageID, genderID, addressID) VALUES (:mail, :firstname, :lastname, :nickname, :password, :phoneNumber, :birthDate, :consent, :lastConnection, :creationDate, :imageID, :genderID, :addressID)');

        $stmt->execute(array(
            'mail' => $owner->getMail(),
            'firstname' => $owner->getFirstname(),
            'lastname' => $owner->getLastname(),
            'nickname' => $owner->getNickname(),
            'password' => $owner->getPassword(),
            'phoneNumber' => $owner->getPhoneNumber(),
            'birthDate' => $owner->getBirthDate()->format('Y-m-d H:i:s'),
            'consent' => $owner->getConsent()*1,
            'lastConnection' => $lastConnection,
            'creationDate' => $owner->getCreationDate()->format('Y-m-d H:i:s'),
            'imageID' => $owner->getImage()->getImageID(),
            'genderID' => $owner->getGender()->getGenderID(),
            'addressID' => $owner->getAddress()->getAddressID(),
        ));

        $current_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare('INSERT INTO _Owner (ownerID, isValidated, identityCard) VALUES (:ownerID, 0, :identityCard);');

        $stmt->execute(array(
            'ownerID' => $current_id,
            'identityCard' => $owner->getIdentityCard(),
        ));

        return new Owner($current_id, $owner->getIdentityCard(), $owner->getMail(), $owner->getFirstname(), $owner->getLastname(), $owner->getNickname(), $owner->getPassword(), $owner->getPhoneNumber(), $owner->getBirthDate(), $owner->getConsent(), $owner->getLastConnection(), $owner->getCreationDate(),$owner->getIsValidated(), $owner->getImage(), $owner->getGender(), $owner->getAddress());
    }
    public static function GetAllOwners()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM Owner');
        $owners = [];

        while ($row = $stmt->fetch()) {
            $owners[] = self::OwnerHandler($row);
        }

        return $owners;
    }
    public static function GetOwnerById(int $ownerID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM Owner WHERE ownerID = ' . $ownerID);
        $row = $stmt->fetch();
        return self::OwnerHandler($row);
    }

    public static function isExistingOwner(string $ownerMail): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM Owner WHERE mail = "' . $ownerMail . '"');
        $row = $stmt->fetch();
        // retourne une erreur si le propriétaire n'existe pas
        if (!$row) {
            return false;
        }
        return true;
    }

    public static function OwnerHandler(array $row): Owner
    {
        // Son Job est de traiter les données de la base de données pour les convertir en objet Owner parce que la table _Owner n'est pas identique à la classe Owner (par exemple, au la bdd possède genderID et la classe Owner, elle gère le genre de l'owner en string. Idem avec l'adresse qui est un ID dans la bdd et un objet Address dans la classe Owner)

        // Gestion du genre
        // appel de la méthode GetGenderById de la classe GenderService
        $gender = GenderService::GetGenderById($row['genderID']);

        // Gestion de l'adresse
        // appel de la méthode GetAddressById de la classe AddressService
        $address = AddressService::GetAddressById($row['addressID']);

        // Gestion de l'image
        // appel de la méthode GetUserImageById de la classe ImageService
        $image = ImageService::GetImageById($row['imageID']);

        $birthDate = isset($row['birthDate']) ? new DateTime($row['birthDate']) : null;
        $lastConnection = isset($row['lastConnection']) ? new DateTime($row['lastConnection']) : null;
        $creationDate = isset($row['creationDate']) ? new DateTime($row['creationDate']) : new DateTime("now");

        return new Owner(
            $row['ownerID'],
            $row['identityCard'],
            $row['mail'],
            $row['firstname'],
            $row['lastname'],
            $row['nickname'],
            $row['password'],
            $row['phoneNumber'],
            $birthDate,
            $row['consent'],
            $lastConnection,
            $creationDate,
            "true",
            $image,
            $gender,
            $address
        );
    }
    public static function ModifyOwner(Owner $owner): bool
    {
        $existingOwner = self::GetOwnerById($owner->getOwnerID());
        
        if (!$existingOwner) {
            throw new Exception('Owner not found');
        }
        
        // Modifie l'image si elle a été modifiée
        if ($owner->getImage() !== $existingOwner->getImage()) {
            $image = ImageService::CreateImage($owner->getImage());
            $owner->setImage($image);
        }
        
        // Modifie l'adresse si elle a été modifiée
        if ($owner->getAddress() !== $existingOwner->getAddress()) {
            $address = AddressService::CreateAddress($owner->getAddress());
            $owner->setAddress($address);
        }
    
        // Modifie le genre si il a été modifié
        if ($owner->getGender() !== $existingOwner->getGender()) {
            $gender = GenderService::GetGenderById($owner->getGender()->getGenderID());
            $owner->setGender($gender);
        }
    
        // Modifier la table
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('UPDATE _User SET 
            mail = :mail, 
            firstname = :firstname, 
            lastname = :lastname, 
            nickname = :nickname, 
            password = :password, 
            phoneNumber = :phoneNumber, 
            birthDate = :birthDate, 
            consent = :consent, 
            lastConnection = :lastConnection, 
            creationDate = :creationDate, 
            imageID = :imageID, 
            genderID = :genderID, 
            addressID = :addressID 
            WHERE userID = :userID');
    
        $success = $stmt->execute(array(
            'mail' => $owner->getMail(),
            'firstname' => $owner->getFirstname(),
            'lastname' => $owner->getLastname(),
            'nickname' => $owner->getNickname(),
            'password' => $owner->getPassword(),
            'phoneNumber' => $owner->getPhoneNumber(),
            'birthDate' => $owner->getBirthDate()->format('Y-m-d H:i:s'),
            'consent' => $owner->getConsent(),
            'lastConnection' => $owner->getLastConnection()->format('Y-m-d H:i:s'),
            'creationDate' => $owner->getCreationDate()->format('Y-m-d H:i:s'),
            'imageID' => $owner->getImage()->getImageID(),
            'genderID' => $owner->getGender()->getGenderID(),
            'addressID' => $owner->getAddress()->getAddressID(),
            'userID' => $owner->getOwnerID()
        ));
    
        if (!$success) {
            throw new Exception('Failed to modify owner');
        }
        return true;
    }

}
