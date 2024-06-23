<?php

// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Housing.php';
require_once __ROOT__.'/models/Address.php';

require_once 'AddressService.php';
require_once 'TypeService.php';
require_once 'CategoryService.php';
require_once 'OwnerService.php';
require_once 'ImageService.php';
require_once 'ArrangementService.php';

class HousingService extends Service
{
    public static function CreateHousing(Housing $housing)
    {

        $address = AddressService::CreateAddress($housing->getAddress());

        $housing->setAddress($address);

        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Housing (title, shortDesc, longDesc, priceExcl, priceIncl, nbPerson, nbRoom, nbDoubleBed, nbSimpleBed, longitude, latitude, isOnline, noticeCount, beginDate, endDate, creationDate, imageID, surfaceInM2, typeID, categoryID, addressID, ownerID) VALUES ( :title, :shortDesc, :longDesc, :priceExcl, :priceIncl, :nbPerson, :nbRoom, :nbDoubleBed, :nbSimpleBed, :longitude, :latitude, :isOnline, :noticeCount, :beginDate, :endDate, :creationDate, :imageID, :surfaceInM2, :typeID, :categoryID, :addressID, :ownerID)');
        $stmt->execute(array(
            'title' => $housing->getTitle(),
            'shortDesc' => $housing->getShortDesc(),
            'longDesc' => $housing->getLongDesc(),
            'priceExcl' => $housing->getPriceExcl(),
            'priceIncl' => $housing->getPriceIncl(),
            'nbPerson' => $housing->getNbPerson(),
            'nbRoom' => $housing->getNbRoom(),
            'nbDoubleBed' => $housing->getNbDoubleBed(),
            'nbSimpleBed' => $housing->getNbSimpleBed(),
            'longitude' => $housing->getLongitude(),
            'latitude' => $housing->getLatitude(),
            'isOnline' => $housing->getIsOnline(),
            'noticeCount' => $housing->getNoticeCount(),
            'beginDate' => $housing->getBeginDate()->format('Y-m-d H:i:s'),
            'endDate' => $housing->getEndDate()->format('Y-m-d H:i:s'),
            'creationDate' => $housing->getCreationDate()->format('Y-m-d H:i:s'),
            'imageID' => $housing->getImage()->getImageID(),
            'surfaceInM2' => $housing->getSurfaceInM2(),
            'typeID' => $housing->getType()->getTypeID(),
            'categoryID' => $housing->getCategory()->getCategoryID(),
            'addressID' => $housing->getAddress()->getAddressID(),
            'ownerID' => $housing->getOwner()->getOwnerID()
        ));
        return new Housing($pdo->lastInsertId(), $housing->getTitle(), $housing->getShortDesc(), $housing->getLongDesc(), $housing->getPriceExcl(), $housing->getPriceIncl(), $housing->getNbPerson(), $housing->getNbRoom(), $housing->getNbDoubleBed(), $housing->getNbSimpleBed(), $housing->getLongitude(), $housing->getLatitude(), $housing->getIsOnline(), $housing->getNoticeCount(), $housing->getBeginDate(), $housing->getEndDate(), $housing->getCreationDate(), $housing->getSurfaceInM2(), $housing->getType(), $housing->getCategory(), $housing->getAddress(), $housing->getOwner(), $housing->getImage());
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

        $beginDate = new DateTime($row['beginDate']);
        $endDate = new DateTime($row['endDate']);
        $creationDate = new DateTime($row['creationDate']);

        if($row['priceIncl'] == null) $row['priceIncl'] = 0;
        if($row['priceExcl'] == null) $row['priceExcl'] = 0;

      
        $row['beginDate'] = ($row['beginDate'] == null) ? new DateTime("now") : new DateTime($row['beginDate']);
        $row['endDate'] = ($row['endDate'] == null) ? new DateTime("now") : new DateTime($row['endDate']);
        $row['creationDate'] = new DateTime("now");

        return new Housing($row['housingID'] , $row['title'], $row['shortDesc'], $row['longDesc'], $row['priceExcl'], $row['priceIncl'], $row['nbPerson'],$row['nbRoom'], $row['nbDoubleBed'], $row['nbSimpleBed'], $row['longitude'], $row['latitude'], $row['isOnline'], $row['noticeCount'], $beginDate, $endDate, $creationDate, $row['surfaceInM2'], $type, $category, $address, $owner, $image, $arrangements);

    }
    public static function GetAllHousings()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT *, _Housing.imageID AS profileImageID FROM _Housing INNER JOIN Owner ON _Housing.ownerID = Owner.ownerID;');
        $housings = [];
        

        while ($row = $stmt->fetch()) {

            // Get the owner

            // $owner = new Owner($rowOwner['ownerID'], $rowOwner['identityCard'], $rowOwner['mail'], $rowOwner['firstname'], $rowOwner['lastname'], $rowOwner['nickname'], $rowOwner['password'], $rowOwner['phoneNumber'], $rowOwner['birthDate'], $rowOwner['consent'], $rowOwner['lastConnection'], $rowOwner['creationDate'], "", $rowOwner['genderID'], $rowOwner['addressID']);

            // Get the images

            $housings[] = self::HousingHandler($row);
        }

        return $housings;
    }

    public static function getAllHousingsByOwnerID(int $ownerID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT *, _Housing.imageID AS profileImageID FROM _Housing WHERE ownerID = ' . $ownerID);
        $housings = [];

        while ($row = $stmt->fetch()) {
            $housings[] = self::HousingHandler($row);
        }

        return $housings;
    }

    public static function GetHousingById(int $housingID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT *, imageID as profileImageID FROM _Housing WHERE housingID = ' . $housingID);
        $row = $stmt->fetch();
        return self::HousingHandler($row);
    }
  
    public static function GetHousingsByOffset($city, $dateBegin, $dateEnd, $nbPerson, $minPrice, $maxPrice, $appartement, $chalet, $maison, $bateau, $villa, $insol, $t1, $t2, $t3, $t4, $t5, $t6, $f1, $f2, $f3, $f4, $f5, $offset, $order, $desc = false) {


        $isAnd = (isset($city) || isset($dateBegin) || isset($dateEnd) || isset($nbPerson) || isset($minPrice) || isset($maxPrice) || $appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1 || $t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1);

        if($isAnd) {
            
            $chaine = "AND ";
    
            if(isset($city)) $chaine = $chaine . '_Address.city = "' . $city . '"' . ((isset($dateBegin) || isset($dateEnd) || isset($nbPerson) || isset($minPrice) || isset($maxPrice) || $appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1 || $t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " AND " : " ");
            
            if(isset($dateBegin)) $chaine = $chaine . "_Housing.beginDate < '" . $dateBegin . "'". ((isset($dateEnd) | isset($nbPerson) || isset($minPrice) || isset($maxPrice) || $appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1 || $t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " AND " : " ");
    
            if(isset($dateEnd)) $chaine = $chaine . "_Housing.endDate > '" . $dateEnd . "'". ((isset($nbPerson) || isset($minPrice) || isset($maxPrice) || $appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1 || $t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " AND " : " ");

            if(isset($nbPerson)) $chaine = $chaine . "_Housing.nbPerson >= " . $nbPerson . ((isset($minPrice) || isset($maxPrice) || $appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1 || $t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " AND " : " ");

            if(isset($minPrice)) $chaine = $chaine . "_Housing.priceIncl >= " . $minPrice . " ". ((isset($maxPrice) || $appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1 || $t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " AND " : " ");

            if(isset($maxPrice)) $chaine = $chaine . "_Housing.priceIncl <= " .  $maxPrice . " ". (($appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1 || $t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " AND " : " ");
            
            if(($appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1)){
                $chaine = $chaine . "(";
                if($appartement == 1) $chaine = $chaine . "_Housing.categoryID = " . 1 . " " . (($chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1) ? " OR " : " ");
                if($chalet == 1) $chaine = $chaine . "_Housing.categoryID = " . 4 . " " . (($maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1) ? " OR " : " ") ;
                if($maison == 1) $chaine = $chaine . "_Housing.categoryID = " . 2 . " " . (($bateau == 1 || $villa == 1 || $insol == 1) ? " OR " : " ");
                if($bateau == 1) $chaine = $chaine . "_Housing.categoryID = " . 5 . " " . (($villa == 1 || $insol == 1) ? " OR " : " ");
                if($villa == 1) $chaine = $chaine . "_Housing.categoryID = " . 3 . " " . (($insol == 1) ? " OR " : " ");
                if($insol == 1) $chaine = $chaine . "_Housing.categoryID = " . 6 . " " ;
                $chaine = $chaine . ") ";

            }

            if (($appartement == 1 || $chalet == 1 || $maison == 1 || $bateau == 1 || $villa == 1 || $insol == 1) && ($t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1)){
                $chaine = $chaine . "AND ";
            }

            if(($t1 == 1 || $t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1)){
                $chaine = $chaine . "(";
                if($t1 == 1) $chaine = $chaine . "_Housing.typeID = " . 2 . " " . (($t2 == 1 || $t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " OR " : " ");
                if($t2 == 1) $chaine = $chaine . "_Housing.typeID = " . 3 . " " . (($t3 == 1 || $t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " OR " : " ") ;
                if($t3 == 1) $chaine = $chaine . "_Housing.typeID = " . 4 . " " . (($t4 == 1 || $t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " OR " : " ");
                if($t4 == 1) $chaine = $chaine . "_Housing.typeID = " . 5 . " " . (($t5 == 1 || $t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " OR " : " ");
                if($t5 == 1) $chaine = $chaine . "_Housing.typeID = " . 6 . " " . (($t6 == 1 || $f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " OR " : " ");
                if($t6 == 1) $chaine = $chaine . "_Housing.typeID = " . 1 . " " . (($f1 == 1 || $f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " OR " : " ");

                if($f1 == 1) $chaine = $chaine . "_Housing.typeID = " . 7 . " " . (($f2 == 1 || $f3 == 1 || $f4 == 1 || $f5 == 1) ? " OR " : " ");
                if($f2 == 1) $chaine = $chaine . "_Housing.typeID = " . 8 . " " . (($f3 == 1 || $f4 == 1 || $f5 == 1 ) ? " OR " : " ") ;
                if($f3 == 1) $chaine = $chaine . "_Housing.typeID = " . 9 . " " . (($f4 == 1 || $f5 == 1 ) ? " OR " : " ");
                if($f4 == 1) $chaine = $chaine . "_Housing.typeID = " . 10 . " " . (($f5 == 1) ? " OR " : " ");
                if($f5 == 1) $chaine = $chaine . "_Housing.typeID = " . 11 . " " ;
                $chaine = $chaine . ") ";

            }
        }
        else $chaine = "";
        
        $query = 'SELECT *, _Housing.imageID AS profileImageID FROM _Housing INNER JOIN Owner ON _Housing.ownerID = Owner.ownerID INNER JOIN _Address ON _Housing.addressID = _Address.addressID WHERE _Housing.isOnline = true ' . $chaine . 'ORDER BY '. $order .' ' . ($desc ? 'DESC' : '') .' LIMIT 9 OFFSET ' . $offset .';';

        $pdo = self::getPDO();
        $stmt = $pdo->query($query);

        $housings = [];

        while ($row = $stmt->fetch()) {

            $housings[] = self::HousingHandler($row);
        }

        if(sizeof($housings) == 0) return false;

        return $housings;
    }

    public static function changeVisibility(Housing $housing): Housing
    {
        $housingID = $housing->getHousingID();

        $newVisibility = (int) !$housing->getIsOnline();
        $housing->setIsOnline($newVisibility);

        $pdo = self::getPDO();
        $stmt = $pdo->prepare('UPDATE _Housing SET isOnline = ? WHERE housingID = ?');
        $stmt->execute([$newVisibility, $housingID]);

        return $housing;
    }
}