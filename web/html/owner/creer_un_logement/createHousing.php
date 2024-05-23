<?php
require_once("../../../services/HousingService.php");
require_once("../../../services/OwnerService.php");
require_once("../../../services/AddressService.php");
require_once("../../../services/ImageService.php");
require_once("../../../services/HasForActivityService.php");
require_once("../../../services/HasForArrangementService.php");
require_once("../../../services/SessionService.php");
require_once("../../../services/CategoryService.php");
require_once("../../../services/TypeService.php");

session_start();
$owner = $_SESSION["owner"];

$title = $_POST['title'];
$shortDesc = $_POST['shortDesc'];
$longDesc = $_POST['longDesc'];
$priceExcl = $_POST['price'];
$priceIncl = $priceExcl * 1.10;
$nbPerson = $_POST['nbPerson'];
$nbRooms = $_POST['nbRooms'];
$nbSimpleBed = $_POST['nbSimpleBed'];
$nbDoubleBed = $_POST['nbDoubleBed'];
$beginDate = new DateTime($_POST['beginDate']);
$endDate = new DateTime($_POST['endDate']);
$surfaceInM2 = (float) $_POST['surfaceInM2'];
$latitude = (float) $_POST['latitude'];
$longitude = (float) $_POST['longitude'];
$postalAddress = $_POST['postalAddress'];
$city = $_POST['city'];
$postalCode = $_POST['postalCode'];
$arrangements = explode(",", $_POST['arrangements']);
$activites = explode(",", $_POST['activities']);
$image = $_POST['image'];
$type = TypeService::GetTypeById($_POST['type']);
$category = CategoryService::GetCategoryById($_POST['category']);

$addressObject = AddressService::CreateAddress(new Address(0, $city, $postalCode, $postalAddress));
$imageObject = ImageService::CreateImage(new Image(0, $image));

/*
public function __construct(int $housingID,
                                string $title,
                                string $shortDesc,
                                string $longDesc,
                                float $priceExcl,
                                float $priceIncl,
                                int $nbPerson,
                                int $nbRoom,
                                int $nbDoubleBed,
                                int $nbSimpleBed,
                                float $longitude,
                                float $latitude,
                                bool $isOnline,
                                int $noticeCount,
                                DateTime $beginDate,
                                DateTime $endDate,
                                DateTime $creationDate,
                                float $surfaceInM2,
                                Type $type,
                                Category $category,
                                Address $address,
                                Owner $owner,
                                Image $image,
                                array $arrangement) {
*/

$housing = new Housing(0, $title, $shortDesc, $longDesc, $priceExcl, $priceIncl, $nbPerson, $nbRooms, $nbDoubleBed, $nbSimpleBed, $longitude, $latitude, true, 0, $beginDate, $endDate, new DateTime(), $surfaceInM2, $type, $category, $addressObject, $owner, $imageObject);
$housing = HousingService::CreateHousing($housing);
print_r($housing);

foreach ($activites as $activite) {
    $activityAndPerimeter = explode("|", $activite);
    HasForActivityService::CreateHasForActivity(new HasForActivity($housing->getHousingID(), $activityAndPerimeter[0], $activityAndPerimeter[1]));
}

foreach ($arrangements as $arrangement) {
    HasForArrangementService::CreateHasForArrangement(new HasForArrangement($housing->getHousingID(), $arrangement));
}

?>