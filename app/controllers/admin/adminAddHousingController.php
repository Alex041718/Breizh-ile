<?php
/**
 * Ce fichier est le contrôleur du formulaire d'ajout d'un logement du dashboard Administrateur. Il récupère les données du formulaire et les utilise pour créer un objet Housing.
 */

// Import de la classe HousingService
require_once '../../services/HousingService.php';
require_once '../../services/ImageService.php';
require_once '../../services/OwnerService.php';
require_once '../../services/TypeService.php';
require_once '../../services/CategoryService.php';
require_once '../../services/AddressService.php';
require_once '../../models/Housing.php';


// Vérifier la méthode de la requête et l'existence des données
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['title']) || !isset($_POST['shortDesc']) || !isset($_POST['longDesc']) || !isset($_POST['priceExcl']) || !isset($_POST['priceIncl']) || !isset($_POST['nbRoom']) || !isset($_POST['nbDoubleBed']) || !isset($_POST['nbSimpleBed']) || !isset($_POST['longitude']) || !isset($_POST['latitude']) || !isset($_POST['isOnline']) || !isset($_POST['noticeCount']) || !isset($_POST['beginDate']) || !isset($_POST['endDate']) || !isset($_POST['surfaceInM2']) || !isset($_POST['typeID']) || !isset($_POST['categoryID']) || !isset($_POST['city']) || !isset($_POST['postalCode']) || !isset($_POST['postalAddress']) || !isset($_POST['ownerID'])) {

    header('Location: ../../views/admin/housingDashboard.php?error=missingFields');
    exit();
}

// Récupération des données du formulaire
$title = $_POST['title'];
$shortDesc = $_POST['shortDesc'];
$longDesc = $_POST['longDesc'];
$priceExcl = $_POST['priceExcl'];
$priceIncl = $_POST['priceIncl'];
$nbRoom = $_POST['nbRoom'];
$nbDoubleBed = $_POST['nbDoubleBed'];
$nbSimpleBed = $_POST['nbSimpleBed'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$isOnline = $_POST['isOnline'] === 'true';
$noticeCount = $_POST['noticeCount'];
$beginDate = new DateTime($_POST['beginDate']);
$endDate = new DateTime($_POST['endDate']);
$surfaceInM2 = $_POST['surfaceInM2'];

// TODO: arrangement et images
// arrangement et images mockées
$arrangement = ["cuisine", "balcon", "terrasse", "jardin", "piscine"];

$images = [$image = new Image(null, '/FILES/images/12345.webp'),$image = new Image(null, '/FILES/images/12345.webp')];





// Récupération des données du propriétaire depuis la base de données afin de construire l'objet Owner
$ownerID = $_POST['ownerID'];
$owner = OwnerService::GetOwnerById($ownerID);


// Récupération des données de l'adresse du formulaire afin de construire l'objet Address
$city = $_POST['city'];
$postalCode = $_POST['postalCode'];
$postalAddress = $_POST['postalAddress'];
$address = new Address(null, $city, $postalCode, $postalAddress);

// Récupération des données du type depuis la base de données afin de construire l'objet Type
$typeID = $_POST['typeID'];
$type = TypeService::GetTypeById($typeID);

// Récupération des données de la catégorie depuis la base de données afin de construire l'objet Category
$categoryID = $_POST['categoryID'];
$category = CategoryService::GetCategoryById($categoryID);


// Création de l'objet Housing
$housing = new Housing(null, $title, $shortDesc, $longDesc, $priceExcl, $priceIncl, $nbRoom, $nbDoubleBed, $nbSimpleBed, $longitude, $latitude, $isOnline, $noticeCount, $beginDate, $endDate, new DateTime(), $surfaceInM2, $type, $category, $address, $owner, $images, $arrangement);

// Appel de la méthode CreateHousing de la classe HousingService
$housing = HousingService::CreateHousing($housing);

// Redirection vers la page de gestion des logements
header('Location: ../../views/admin/housingDashboard.php');
exit();
