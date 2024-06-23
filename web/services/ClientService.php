<?php

require_once 'Service.php';
require_once 'ImageService.php';
require_once 'AddressService.php';
require_once 'GenderService.php';
require_once __ROOT__ . '/models/Client.php';

class ClientService extends Service
{
    public static function CreateClient(Client $client): Client
    {
        $image = ImageService::CreateImage($client->getImage());
        $address = AddressService::CreateAddress($client->getAddress());
        $lastConnection = $client->getLastConnection() ? $client->getLastConnection()->format('Y-m-d H:i:s') : null;

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
            'lastConnection' => $lastConnection,
            'creationDate' => $client->getCreationDate()->format('Y-m-d H:i:s'),
            'imageID' => $client->getImage()->getImageID(),
            'genderID' => $client->getGender()->getGenderID(),
            'addressID' => $client->getAddress()->getAddressID()
        ));

        $current_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare('INSERT INTO _Client (clientID, isBlocked) VALUES (:clientID, 0);');

        $stmt->execute(array(
            'clientID' => $current_id,
        ));

        return new Client($current_id, $client->getIsBlocked(), $client->getMail(), $client->getFirstname(), $client->getLastname(), $client->getNickname(), $client->getPassword(), $client->getPhoneNumber(), $client->getBirthDate(), $client->getConsent(), null, $client->getCreationDate(), $client->getImage(), $client->getGender(), $client->getAddress(), null, null);
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

    public static function encryptClient($client) {
        // Sérialiser l'objet
        $serializedObject = serialize($client);
    
        // // Générer un vecteur d'initialisation (IV) sécurisé
        // $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        // $iv = openssl_random_pseudo_bytes($ivLength);
    
        // // Chiffrer l'objet sérialisé
        // $encryptedData = openssl_encrypt($serializedObject, 'aes-256-cbc', "LaCrepeTech", 0, $iv);
    
        // // Combiner le IV et les données chiffrées pour le stockage
        // $encryptedObject = base64_encode($iv . $encryptedData);
    
        return $serializedObject;
    }

    public static function decryptClient($client) {
        // Décoder les données de l'objet chiffré
        // $data = base64_decode($client);
    
        // // Extraire le vecteur d'initialisation (IV) et les données chiffrées
        // $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        // $iv = substr($data, 0, $ivLength);
        // $encryptedData = substr($data, $ivLength);
    
        // // Déchiffrer les données
        // $serializedObject = openssl_decrypt($encryptedData, 'aes-256-cbc', "LaCrepeTech", 0, $iv);

        // echo $serializedObject;
    
        // Désérialiser les données pour récupérer l'objet original
        $object = unserialize($client);
    
        return $object;
    }

    public static function GetClientById(int $clientID): Client
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

    public static function isExistingClient(string $clientMail): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM Client WHERE mail = "' . $clientMail . '"');
        $row = $stmt->fetch();
        // retourne une erreur si le client n'existe pas
        if (!$row) {
            return false;
        }
        return true;
    }

    public static function updateUserTokenByEmail(string $clientEmail)
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
        UPDATE Client
        SET reset_token_hash = :token_hash,
            reset_token_expires_at = :expiry
        WHERE mail = :email
        ");
        $stmt->bindParam(':token_hash', $token_hash);
        $stmt->bindParam(':expiry', $expiry);
        $stmt->bindParam(':email', $clientEmail);

        if ($stmt->execute()) {
            return $token_hash;
        } else {
            return null;
        }
    }

    public static function getEncryptToken(string $token)
    {
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
 
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';
        
        // Store the encryption key
        $encryption_key = "LaCrepeTech";

        // Use openssl_encrypt() function to encrypt the data
        return openssl_encrypt($token, $ciphering, $encryption_key, $options, $encryption_iv);
    }

    public static function GetClientByToken(string $token): Client
    {
        $pdo = self::getPDO();
        $token_hash = hash("sha256", $token);
        $stmt = $pdo->prepare('SELECT * FROM Client WHERE reset_token_hash = :token_hash');
        $stmt->bindParam(':token_hash', $token);

        if ($stmt->execute()) {
            $row = $stmt->fetch();
            // retourne une erreur si le client n'existe pas
            if (!$row) {
                throw new Exception('Client not found');
            }
            return self::ClientHandler($row);
        } else {
            throw new Exception('Failed to execute query');
        }
    }

    public static function genRandomCode() {
        // Génère un nombre aléatoire entre 0 et 999999
        $code = rand(0, 999999);
        // Formate le code en une chaîne de caractères de 6 chiffres, avec des zéros en tête si nécessaire
        $formattedCode = str_pad($code, 6, '0', STR_PAD_LEFT);
        return $formattedCode;
    }
    

    public static function updateUserPasswordByClientId($newPassword, $clientId)
    {
        $pdo = self::getPDO();
        $newPassword_hash = password_hash($newPassword, PASSWORD_DEFAULT); // Utilisation de password_hash
        $stmt = $pdo->prepare("
        UPDATE Client
        SET password = :newPassword_hash
        WHERE clientID = :clientId
    ");
        $stmt->bindParam(':newPassword_hash', $newPassword_hash);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->execute();
    }


    public static function ClientHandler(array $row): Client
    {
        $gender = GenderService::GetGenderById($row['genderID']);
        $address = AddressService::GetAddressById($row['addressID']);
        $image = ImageService::GetImageById($row['imageID']);
        $lastConnection = $row['lastConnection'] ? $row['lastConnection'] : null;


        return new Client(
            $row['clientID'],
            $row['isBlocked'],
            $row['mail'],
            $row['firstname'],
            $row['lastname'],
            $row['nickname'],
            $row['password'],
            $row['phoneNumber'],
            new DateTime($row['birthDate']),
            $row['consent'],
            $lastConnection,
            new DateTime($row['creationDate']),
            $image,
            $gender,
            $address,
            $row['reset_token_hash'] ?? null,
            isset($row['reset_token_expires_at']) ? new DateTime($row['reset_token_expires_at']) : null
        );
    }

    public static function ModifyClient(Client $client): bool
    {
        $existingClient = self::GetClientById($client->getClientID());

        if (!$existingClient) {
            throw new Exception('Client not found');
        }

        // Modifie l'image si elle a été modifiée
        if ($client->getImage() !== $existingClient->getImage()) {
            $image = ImageService::CreateImage($client->getImage());
            $client->setImage($image);
        }

        // Modifie l'adresse si elle a été modifiée
        if ($client->getAddress() !== $existingClient->getAddress()) {
            $address = AddressService::CreateAddress($client->getAddress());
            $client->setAddress($address);
        }

        // Modifie le genre si il a été modifié
        if ($client->getGender() !== $existingClient->getGender()) {
            $gender = GenderService::GetGenderById($client->getGender()->getGenderID());
            $client->setGender($gender);
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
            'addressID' => $client->getAddress()->getAddressID(),
            'userID' => $client->getClientID()
        ));

        if (!$success) {
            throw new Exception('Failed to modify client');
        }

        // Modifier si le client est bloqué
        if ($client->getIsBlocked() !== $existingClient->getIsBlocked()) {
            $stmt = $pdo->prepare('UPDATE _Client SET isBlocked = :isBlocked WHERE clientID = :clientID');
            $stmt->execute(array(
                'isBlocked' => $client->getIsBlocked(),
                'clientID' => $client->getClientID()
            ));
        }
        return true;
    }


}

?>
