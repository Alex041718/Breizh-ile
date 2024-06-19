<?php
require_once("../../../services/HousingService.php");
session_start();

$housingID = $_POST['housingID'];
$housing = HousingService::getHousingById($housingID);

if ($housing->getOwner()->getOwnerID() == $_SESSION['user_id']) {
    HousingService::changeVisibility($housing);
    echo json_encode(["success" => "Visibilité du logement modifiée"]);
} else {
    echo json_encode(["error" => "Vous n'êtes pas le propriétaire de ce logement"]);
}
?>
