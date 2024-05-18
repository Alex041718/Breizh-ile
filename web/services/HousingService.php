<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Housing.php';
require_once __ROOT__.'/models/Address.php';

class HousingService extends Service
{
    public static function CreateHousing(Housing $housing)
    {

        $address = AddressService::CreateAddress($housing->getAddress());

        $housing->setAddress($address);

        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Housing (title, shortDesc, longDesc, priceExcl, priceIncl, nbRoom, nbDoubleBed, nbSimpleBed, longitude, latitude, isOnline, noticeCount, beginDate, endDate, creationDate, imageSrc, surfaceInM2, typeID, categoryID, addressID, ownerID) VALUES ( :title, :shortDesc, :longDesc, :priceExcl, :priceIncl, :nbRoom, :nbDoubleBed, :nbSimpleBed, :longitude, :latitude, :isOnline, :noticeCount, :beginDate, :endDate, :creationDate, :surfaceInM2, :typeID, :categoryID, :addressID, :ownerID)');
        $stmt->execute(array(
            'title' => $housing->getTitle(),
            'shortDesc' => $housing->getShortDesc(),
            'longDesc' => $housing->getLongDesc(),
            'priceExcl' => $housing->getPriceExcl(),
            'priceIncl' => $housing->getPriceIncl(),
            'nbRoom' => $housing->getNbRoom(),
            'nbDoubleBed' => $housing->getNbDoubleBed(),
            'nbSimpleBed' => $housing->getNbSimpleBed(),
            'longitude' => $housing->getLongitude(),
            'latitude' => $housing->getLatitude(),
            'isOnline' => $housing->getIsOnline(),
            'noticeCount' => $housing->getNoticeCount(),
            'beginDate' => $housing->getBeginDate()->format('Y-m-d H:i:s'),
            'endDate' => $housing->getEndDate()->format('Y-m-d H:i:s'),
            'creationDate' => $housing->getCreationDate(),
            'imageID' => $housing->getImage()->getImageSrc(),
            'surfaceInM2' => $housing->getSurfaceInM2(),
            'typeID' => $housing->getType()->getTypeID(),
            'categoryID' => $housing->getCategory()->getCategoryID(),
            'addressID' => $housing->getAddress()->getAddressID(),
            'ownerID' => $housing->getOwner()->getOwnerID()
        ));
        return new Housing($pdo->lastInsertId(), $housing->getTitle(), $housing->getShortDesc(), $housing->getLongDesc(), $housing->getPriceExcl(), $housing->getPriceIncl(), $housing->getNbRoom(), $housing->getNbDoubleBed(), $housing->getNbSimpleBed(), $housing->getLongitude(), $housing->getLatitude(), $housing->getIsOnline(), $housing->getNoticeCount(), $housing->getBeginDate(), $housing->getEndDate(), $housing->getCreationDate(), $housing->getSurfaceInM2(), $housing->getType(), $housing->getCategory(), $housing->getAddress(), $housing->getOwner(), $housing->getImage(), $housing->getArrangement());
    }

    public static function HousingHandler(array $row): Housing
    {
        /* Son job est de créer un objet Housing à partir d'un tableau associatif provenant de la bdd. car la table _Housing 
        n'est pas identique à la classe Housing (par exemple, au la bdd possède typeID et la classe Housing, elle gère le 
        type de l'housing avec l'objet Type. Idem avec la catégorie qui est un ID dans la bdd et un objet Category dans la 
        classe Housing) */

        // Gestion du type
        // appel de la méthode GetTypeById de la classe TypeService
        $type = TypeService::GetTypeById($row['typeID']);

        // Gestion de la catégorie
        // appel de la méthode GetCategoryById de la classe CategoryService
        $category = CategoryService::GetCategoryById($row['categoryID']);

        // Gestion de l'adresse
        // appel de la méthode GetAddressById de la classe AddressService
        $address = AddressService::GetAddressById($row['addressID']);

        // Gestion du propriétaire
        // appel de la méthode GetOwnerById de la classe OwnerService
        $owner = OwnerService::GetOwnerById($row['ownerID']);

        // Gestion des images
        // appel de la méthode GetHousingImages de la classe ImageService
        $image = ImageService::GetImageById($row['profileImageID']);

        // Gestion des arrangements
        // appel de la méthode GetArrangmentByHousingId de la classe ArrangementService
        $arrangements = ArrangementService::GetArrangmentsByHousingId($row['housingID']);

        if($row['priceIncl'] == null) $row['priceIncl'] = 0;
        if($row['priceIncl'] == null) $row['beginDate'] = new DateTime("now");
        if($row['beginDate'] == null) $row['beginDate'] = new DateTime("now");
        if($row['endDate'] == null) $row['endDate'] = new DateTime("now");
        $row['creationDate'] = new DateTime("now");

        return new Housing($row['housingID'], $row['title'], $row['shortDesc'], $row['longDesc'], $row['priceExcl'], $row['priceIncl'], $row['nbRoom'], $row['nbDoubleBed'], $row['nbSimpleBed'], $row['longitude'], $row['latitude'], $row['isOnline'], $row['noticeCount'], $row['beginDate'], $row['endDate'], $row['creationDate'], $row['surfaceInM2'], $type, $category, $address, $owner, $image, $arrangements);
    }
    public static function GetAllHousings()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT *, _Housing.imageID AS profileImageID FROM _Housing INNER JOIN Owner ON _Housing.ownerID = Owner.ownerID WHERE housingID <= 9;');
        $housings = [];

        while ($row = $stmt->fetch()) {

            // Get the owner

            // $owner = new Owner($rowOwner['ownerID'], $rowOwner['identityCard'], $rowOwner['mail'], $rowOwner['firstname'], $rowOwner['lastname'], $rowOwner['nickname'], $rowOwner['password'], $rowOwner['phoneNumber'], $rowOwner['birthDate'], $rowOwner['consent'], $rowOwner['lastConnection'], $rowOwner['creationDate'], "", $rowOwner['genderID'], $rowOwner['addressID']);

            // Get the images

            $housings[] = self::HousingHandler($row);
        }

        return $housings;
    }

    public static function GetHousingsByOffset($offset, $order, $desc = false) {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT *, _Housing.imageID AS profileImageID FROM _Housing INNER JOIN Owner ON _Housing.ownerID = Owner.ownerID ORDER BY '. $order .' ' . ($desc ? 'DESC' : '') .' LIMIT 9 OFFSET ' . $offset .';');
        $housings = [];

        while ($row = $stmt->fetch()) {

            $housings[] = self::HousingHandler($row);
        }

        if(sizeof($housings) == 0) return false;

        return $housings;
    }
}