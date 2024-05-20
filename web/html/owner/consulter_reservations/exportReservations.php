<?php 
require_once("../../../services/ReservationService.php");

$CSV = 0;
$ICAL = 1;

session_start();
$reservations = $_SESSION["reservations"];

$reservations_index_selected = explode(",", $_POST["reservations"]);
$reservations_selected = array();

foreach ($reservations_index_selected as $index) {
    array_push($reservations_selected, $reservations[$index]);
}

function exportReservationToCSV($reservations) {
    $csvContent = "Date de réservation;Client;Logement;Date d'arrivée;Date de départ;Charge de service; Taxe de séjour; Méthode de paiement; Status\n";

    foreach ($reservations as $reservation) {
        $csvContent .= $reservation->getBeginDate()->format("d/m/Y") . ";";
        $csvContent .= $reservation->getClientId()->getNickname() . ";";
        $csvContent .= $reservation->getHousingId()->getTitle() . ";";
        $csvContent .= $reservation->getBeginDate()->format("d/m/Y") . ";";
        $csvContent .= $reservation->getEndDate()->format("d/m/Y") . ";";
        $csvContent .= $reservation->getServiceCharge() . ";";
        $csvContent .= $reservation->getTouristTax() . ";";
        $csvContent .= $reservation->getPayMethodId()->getLabel() . ";";
        $csvContent .= $reservation->getStatus() . "\n";
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="reservations_' . time() . '.csv"');
    header('Content-Length: ' . strlen($csvContent));

    echo $csvContent;
    exit;
}

function exportReservationToICAL($reservations) {
    $iCalContent = "BEGIN:VCALENDAR\n";
    $iCalContent .= "VERSION:2.0\n";
    $iCalContent .= "PRODID:-//Breizhil/Breizhil//FR\n";

    foreach ($reservations as $reservation) {
        $iCalContent .= "BEGIN:VEVENT\n";
        $iCalContent .= "DTSTART:" . $reservation->getBeginDate()->format("Ymd") . "T080000\n";
        $iCalContent .= "DTEND:" . $reservation->getEndDate()->format("Ymd") . "T180000\n";
        $iCalContent .= "SUMMARY:" . $reservation->getHousingId()->getTitle() . "\n";
        $iCalContent .= "LOCATION:" . $reservation->getHousingId()->getAddress()->getPostalAddress() . "\n";
        $iCalContent .= "END:VEVENT\n";
        $iCalContent .= "";
    }

    $iCalContent .= "END:VCALENDAR\n";

    header('Content-Type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename="reservations_' . time() . '.ics"');
    header('Content-Length: ' . strlen($iCalContent));

    echo $iCalContent;
    exit;
}

    
switch ($_POST["type"]) {
    case $CSV:
        exportReservationToCSV($reservations_selected);
        break;
    case $ICAL:
        exportReservationToICAL($reservations_selected);
        break;
    default:
        break;
}
?>