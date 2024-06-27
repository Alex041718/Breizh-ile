
<?php

    require_once("../../../services/ReservationService.php");

    if(isset($_POST["beginDate"]) && $_POST["beginDate"] != "" && $_POST["beginDate"] != "null") $beginDate = $_POST["beginDate"];
    else $beginDate = null;
    if(isset($_POST["endDate"]) && $_POST["endDate"] != "" && $_POST["endDate"] != "null") $endDate = $_POST["endDate"];
    else $endDate = null;

    $dates = ReservationService::getReservationDatesByHousingID($beginDate, $endDate);


?>