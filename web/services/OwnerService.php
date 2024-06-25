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

        $stmt = $pdo->prepare('INSERT INTO _Owner (ownerID, isValidated, identityCardFront, identityCardBack, bankDetails, swiftCode, IBAN) VALUES (:ownerID, 0, :identityCardFront, :identityCardBack, :bankDetails, :swiftCode, :IBAN);');

        $stmt->execute(array(
            'ownerID' => $current_id,
            'identityCardFront' => $owner->getIdentityCardFront(),
            'identityCardBack' => $owner->getIdentityCardBack(),
            'bankDetails' => $owner->getBankDetails(),
            'swiftCode' => $owner->getSwiftCode(),
            'IBAN' => $owner->getIBAN(),
        ));

        return new Owner($current_id, $owner->getMail(), $owner->getFirstname(), $owner->getLastname(), $owner->getNickname(), $owner->getPassword(), $owner->getPhoneNumber(), $owner->getBirthDate(), $owner->getConsent(), $owner->getLastConnection(), $owner->getCreationDate(),$owner->getIsValidated(), $owner->getIdentityCardFront(), $owner->getIdentityCardBack(), $owner->getBankDetails(), $owner->getSwiftCode(), $owner->getIBAN(), $owner->getImage(), $owner->getGender(), $owner->getAddress(), null, null);
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

    public static function updateUserPasswordByOwnerId($newPassword, $ownerId)
    {
        $pdo = self::getPDO();
        $newPassword_hash = password_hash($newPassword, PASSWORD_DEFAULT); // Utilisation de password_hash
        $stmt = $pdo->prepare("
        UPDATE Owner
        SET password = :newPassword_hash
        WHERE ownerID = :ownerId
    ");
        $stmt->bindParam(':newPassword_hash', $newPassword_hash);
        $stmt->bindParam(':ownerId', $ownerId);
        $stmt->execute();
    }

    public static function GetOwnerByToken(string $token): ?Owner
    {
        $pdo = self::getPDO();
        $token_hash = hash("sha256", $token);
        $stmt = $pdo->prepare('SELECT * FROM Owner WHERE reset_token_hash = :token_hash');
        $stmt->bindParam(':token_hash', $token);

        if ($stmt->execute()) {
            $row = $stmt->fetch();
            // retourne une erreur si le owner n'existe pas
            if (!$row) {
                return null;
            }
            return self::OwnerHandler($row);
        } else {
            throw new Exception('Failed to execute query');
        }
    }

    public static function updateUserTokenByEmail(string $ownerEmail)
    {
        $token = bin2hex(random_bytes(32));
        $token_hash = hash("sha256", $token);
        //        $expiry = date("Y-m-d H:i:s", time() + 60 * 20);

        // Obtenez le fuseau horaire par défaut du serveur
        $timezone = date_default_timezone_get();

        // Créez un nouvel objet DateTime avec le fuseau horaire spécifique
//        $date_expiration = new DateTime(null, new DateTimeZone($timezone));
        $date_expiration = new DateTime("now", new DateTimeZone('Europe/Paris'));

        // Ajoutez 20 minutes à l'heure actuelle
        $date_expiration->add(new DateInterval('PT20M'));

        // Formattez la date et l'heure au format souhaité
        $expiry = $date_expiration->format('Y-m-d H:i:s');


        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE Owner
            SET reset_token_hash = :token_hash,
                reset_token_expires_at = :expiry
            WHERE mail = :email
        ");
        $stmt->bindParam(':token_hash', $token_hash);
        $stmt->bindParam(':expiry', $expiry);
        $stmt->bindParam(':email', $ownerEmail);

        if ($stmt->execute()) {
            return $token_hash;
        } else {
            return null;
        }
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
            $row['identityCardFront'],
            $row['identityCardBack'],
            $row['bankDetails'],
            $row['swiftCode'],
            $row['IBAN'],
            $image,
            $gender,
            $address,
            $row['reset_token_hash'] ?? null,
            isset($row['reset_token_expires_at']) ? new DateTime($row['reset_token_expires_at']) : null
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
            'lastConnection' => $owner->getLastConnection() ? $owner->getLastConnection()->format('Y-m-d H:i:s') : null,
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
