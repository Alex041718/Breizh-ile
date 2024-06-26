<?php
require_once '../../../services/ReservationService.php';

// Fonction pour échapper les caractères spéciaux dans les valeurs iCal
function escapeString($string) {
    return preg_replace('/([\,;])/', '\\\\$1', $string);
}

// Fonction pour générer le fichier iCal à partir des réservations
function generateICal($reservations) {
    $ical = "BEGIN:VCALENDAR\r\n";
    $ical .= "VERSION:2.0\r\n";
    $ical .= "PRODID:-//Your Company//NONSGML v1.0//EN\r\n";

    foreach ($reservations as $reservation) {
        $ical .= "BEGIN:VEVENT\r\n";
        $ical .= "UID:" . uniqid() . "@yourdomain.com\r\n";
        $ical .= "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n";
        $ical .= "DTSTART:" . $reservation->getBeginDate()->format('Ymd\THis\Z') . "\r\n";
        $ical .= "DTEND:" . $reservation->getEndDate()->format('Ymd\THis\Z') . "\r\n";
        $ical .= "SUMMARY:" . escapeString("Reservation for " . $reservation->getClientId()->getName()) . "\r\n";
        $ical .= "DESCRIPTION:" . escapeString("Reservation ID: " . $reservation->getId() . ", Status: " . $reservation->getStatus()) . "\r\n";
        $ical .= "LOCATION:" . escapeString($reservation->getHousingId()->getAddress()) . "\r\n";
        $ical .= "END:VEVENT\r\n";
    }

    $ical .= "END:VCALENDAR\r\n";

    return $ical;
}
// // Vérification des paramètres GET pour récupérer une réservation par ID
// if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['reservation_id'])) {
//     $reservationID = $_GET['reservation_id'];

//     try {
//         // Récupérer la réservation par ID
//         $reservation = ReservationService::getReservationByID($reservationID);
//         if ($reservation) {
            // Envoi des en-têtes HTTP pour télécharger le fichier iCal
            header('Content-Type: text/calendar; charset=utf-8');
            header('Content-Disposition: attachment; filename="calendar.ics"');
            
            // Génération et affichage du fichier iCal
            echo generateICal($reservation);
            exit;
//         } else {
//             echo "Reservation not found.";
//         }
//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }
// }
?>
