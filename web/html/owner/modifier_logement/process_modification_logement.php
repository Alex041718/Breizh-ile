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
$housingID = $_POST['housingID'];
$title = $_POST['title'];
$shortDesc = $_POST['shortDesc'];
$longDesc = $_POST['longDesc'];
$priceExcl = $_POST['price'];
$priceIncl = (float) $priceExcl * 1.10;
$nbPerson = (int) $_POST['nbPerson'];
$nbRooms = (int) $_POST['nbRooms'];
$nbSimpleBed = (int) $_POST['nbSimpleBed'];
$nbDoubleBed = (int) $_POST['nbDoubleBed'];
$beginDate = new DateTime($_POST['beginDate']);
$endDate = new DateTime($_POST['endDate']);
$surfaceInM2 = (float) $_POST['surfaceInM2'];
$latitude = (float) $_POST['latitude'];
$longitude = (float) $_POST['longitude'];
$postalAddress = $_POST['postalAddress'];
$city = $_POST['city'];
$noticeCount = (isset($_POST['noticeCount'])) ? $_POST['noticeCount'] : 7;
$country = (isset($_POST['country'])) ? $_POST['country'] : "France";
$streetNumber = (isset($_POST['streetNumber'])) ? $_POST['streetNumber'] : "";
$complementAddress = (isset($_POST['complementAddress'])) ? $_POST['complementAddress'] : "";
$postalCode = $_POST['postalCode'];
$arrangements = explode(",", $_POST['arrangements']);
$activites = explode(",", $_POST['activities']);
$image = $_POST['image'];
$type = TypeService::GetTypeById($_POST['type']);
$category = CategoryService::GetCategoryById($_POST['category']);

$addressObject = AddressService::CreateAddress(new Address(0, $city, $postalCode, $postalAddress, $complementAddress, $streetNumber, $country));
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

$housing = new Housing($housingID, $title, $shortDesc, $longDesc, $priceExcl, $priceIncl, $nbPerson, $nbRooms, $nbDoubleBed, $nbSimpleBed, $longitude, $latitude, true, $noticeCount, $beginDate, $endDate, new DateTime(), $surfaceInM2, $type, $category, $addressObject, $owner, $imageObject);
$housing = HousingService::UpdateHousingById($housing);
print_r($housing);

foreach ($activites as $activite) {
    $activityAndPerimeter = explode("|", $activite);
    HasForActivityService::CreateHasForActivity(new HasForActivity($housing->getHousingID(), $activityAndPerimeter[0], $activityAndPerimeter[1]));
}

foreach ($arrangements as $arrangement) {
    HasForArrangementService::CreateHasForArrangement(new HasForArrangement($housing->getHousingID(), $arrangement));
}

?>