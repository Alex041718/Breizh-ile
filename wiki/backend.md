# Bienvenue sur la documentation de la partie back de notre projet

# Sommaire

- [Introduction](#introduction)
- [C'est quoi un model ?](#cest-quoi-un-model-)
- [Qu'est-ce qu'un service ?](#quest-ce-quun-service-)

# Introduction
Le backend de notre projet est composé de plusieurs parties :

 - Les models `app/models`
 - Les services `app/services`
 - Les controllers `app/controllers`

> Les models et les services sont des class PHP.
> 
> Seul les Services font des requêtes à la base de donnée

>Les controllers sont des scripts PHP qui reçoivent des requêtes HTTP  de type POST pour traiter un formulaire.



# C'est quoi un model ?
Un model est une classe PHP qui représente un object de notre application.
Ils sont utilisés pour uniformiser les données de notre application.

Voici un exemple du model Owner :

```php
<?php

class Owner {
    private ?int $ownerID;
    private string $identityCard;
    private string $mail;
    private string $firstname;
    private string $lastname;
    private string $nickname;
    private string $password;
    private string $phoneNumber;
    private DateTime $birthDate;
    private bool $consent;
    private DateTime $lastConnection;
    private DateTime $creationDate;
    private Image $image;
    private Gender $gender;
    private Address $address;

    public function __construct(?int $ownerID,
                                string $identityCard,
                                string $mail,
                                string $firstname,
                                string $lastname,
                                string $nickname,
                                string $password,
                                string $phoneNumber,
                                DateTime $birthDate,
                                bool $consent,
                                DateTime $lastConnection,
                                DateTime $creationDate,
                                Image $image,
                                Gender $gender,
                                Address $address) {
        $this->ownerID = $ownerID;
        $this->identityCard = $identityCard;
        $this->mail = $mail;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->birthDate = $birthDate;
        $this->consent = $consent;
        $this->lastConnection = $lastConnection;
        $this->creationDate = $creationDate;
        $this->image = $image;
        $this->gender = $gender;
        $this->address = $address;
    }

    
    //Getters and Setters
    //...
}
```

> Les models ne doivent pas contenir de requêtes SQL

> Les models ne sont pas des reflets des tables de la base de donnée mais des objets de notre application
>
> Les models peuvent contenir des objets d'autres models
> 
> Par exemple, le model Owner contient des objets Image, Address et Gender ce qui est différent de la base de donnée qui contient uniquement des ID


# Qu'est-ce qu'un service ?

Un service est une classe PHP qui contient des méthodes qui permettent de faire des requêtes à la base de donnée.

Chaque service est associé à un model. Mais un service peut contenir des méthodes qui font des requêtes sur plusieurs tables.

Pour faire des requette à la base de donnée, on utilise PDO qui est unitialisé dans le service `Service.php` qu'hérite tous les services.

>Ainsi via cette héritage (extends Service), chaque service a accès à la propriété `$pdo` qui est une instance de PDO pour faire des requêtes SQL.


Prenons l'exemple du service OwnerService :

```php
<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Owner.php';
require_once 'ImageService.php';
require_once 'AddressService.php';

class OwnerService extends Service
{


    public static function CreateOwner(Owner $owner) : Owner
    {
        // Étape 1 : Enregistrer en base de donnée l'image et l'adresse de l'owner
        $image = ImageService::CreateImage($owner->getImage());
        $address = AddressService::CreateAddress($owner->getAddress());

        $owner->setImage($image);
        $owner->setAddress($address);

        // Étape 2 : Enregistrer en base l'owner

        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Owner (identityCard, mail, firstname, lastname, nickname, password, phoneNumber, birthDate, consent, lastConnection, creationDate, imageID, genderID, addressID) VALUES (:identityCard, :mail, :firstname, :lastname, :nickname, :password, :phoneNumber, :birthDate, :consent, :lastConnection, :creationDate, :imageID, :genderID, :addressID)');

        $stmt->execute(array(
            'identityCard' => $owner->getIdentityCard(),
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
            'addressID' => $owner->getAddress()->getAddressID()
        ));

        return new Owner($pdo->lastInsertId(), $owner->getIdentityCard(), $owner->getMail(), $owner->getFirstname(), $owner->getLastname(), $owner->getNickname(), $owner->getPassword(), $owner->getPhoneNumber(), $owner->getBirthDate(), $owner->getConsent(), $owner->getLastConnection(), $owner->getCreationDate(), $owner->getImage(), $owner->getGender(), $owner->getAddress());
    }
    public static function GetAllOwners()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Owner');
        $owners = [];

        while ($row = $stmt->fetch()) {
            $owners[] = self::OwnerHandler($row);
        }

        return $owners;
    }
    public static function GetOwnerById(int $ownerID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Owner WHERE ownerID = ' . $ownerID);
        $row = $stmt->fetch();
        return self::OwnerHandler($row);
    }

    public static function OwnerHandler(array $row): Owner
    {
        // Son Job est de traiter les données de la base de données pour les convertir en objet Owner parce que la table _Owner n'est pas identique à la classe Owner (par exemple, au la bdd possède genderID et la classe Owner, elle gère le genre de l'owner en string. Idem avec l'adresse qui est un ID dans la bdd et un objet Address dans la classe Owner)

        // Gestion du genre
        // appel de la méthode GetGenderById de la classe GenderService
        $gender = GenderService::GetGenderById($row['genderID']);

        // Gestion de l'adresse
        // appel de la méthode GetAddressById de la classe AddressService
        $adress = AddressService::GetAddressById($row['addressID']);

        // Gestion de l'image
        // appel de la méthode GetUserImageById de la classe ImageService
        $image = ImageService::GetImageById($row['imageID']);


        return new Owner($row['ownerID'], $row['identityCard'], $row['mail'], $row['firstname'], $row['lastname'], $row['nickname'], $row['password'], $row['phoneNumber'], $row['birthDate'], $row['consent'], $row['lastConnection'], $row['creationDate'], $image, $gender, $adress);
    }

}
```

On se retrouve avec différentes méthodes en rapport avec les owners :
- `CreateOwner` : Permet de créer un owner
- `GetAllOwners` : Permet de récupérer tous les owners
- `GetOwnerById` : Permet de récupérer un owner par son ID
- `OwnerHandler` : Permet de traiter les données de la base de donnée pour les convertir en objet Owner

> Dans le cas de la méthode `CreateOwner`, on voit que l'on fait appel à d'autres services pour créer un owner. En effet, un owner possède une image et une adresse. On doit donc créer ces objets avant de créer l'owner.
