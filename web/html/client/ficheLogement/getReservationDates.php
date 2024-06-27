
<?php

    require_once("../../../services/ReservationService.php");

    if(isset($_POST["housingID"]) && $_POST["housingID"] != "" && $_POST["housingID"] != "null") $housingID = $_POST["housingID"];
    else $housingID = null;

    $dates = ReservationService::getReservationDatesByHousingID($housingID);
    echo json_encode($dates);


?>