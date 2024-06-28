<?php
require_once '../../../services/ReservationService.php';
require_once '../../../services/SubscriptionService.php';

// Fonction pour échapper les caractères spéciaux dans les valeurs iCal
function escapeString($string) {
    return str_replace("'", chr(39), $string);
}

// Fonction pour générer le fichier iCal à partir des réservations
function generateICal(Array $reservations) {
    $ical = "BEGIN:VCALENDAR\r\n";
    $ical .= "VERSION:2.0\r\n";
    $ical .= "PRODID:-BreizhIleNONSGML v1.0//EN\r\n";

    foreach ($reservations as $reservation) {

        $address = $reservation->getHousingId()->getAddress()->getStreetNumber() . " " . $reservation->getHousingId()->getAddress()->getPostalAddress() . " - " . $reservation->getHousingId()->getAddress()->getPostalCode() . " " .  $reservation->getHousingId()->getAddress()->getCity();

        $ical .= "BEGIN:VEVENT\r\n";
        $ical .= "UID:" . $reservation->getClientID()->getMail() ."\r\n";
        $ical .= "DTSTAMP;TZID=France/Paris:" . (new DateTime("now"))->format("Ymd\THis") . "\r\n";
        $ical .= "DTSTART:" . $reservation->getBeginDate()->format('Ymd') . "\r\n";
        $ical .= "DTEND:" . $reservation->getEndDate()->format('Ymd') . "\r\n";
        $ical .= "SUMMARY:" . "Reservation - " . $reservation->getclientID()->getFirstName() . " " . $reservation->getclientID()->getLastName() . "\r\n";
        $ical .= "DESCRIPTION:" . "Reservation ID: " . $reservation->getId() . "\r\n";
        $ical .= "LOCATION:" . $address . "\r\n";
        $ical .= "END:VEVENT\r\n";
    }

    $ical .= "END:VCALENDAR\r\n";

    return htmlspecialchars_decode($ical);

}
// // Vérification des paramètres GET pour récupérer une réservation par ID
// if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['reservation_id'])) {
//     $reservationID = $_GET['reservation_id'];

//     try {
//         // Récupérer la réservation par ID
//         $reservation = ReservationService::getReservationByID($reservationID);
//         if ($reservation) {
            // Envoi des en-têtes HTTP pour télécharger le fichier iCal
            // header('Content-Type: text/calendar; charset=utf-8');
            // header('Content-Disposition: attachment; filename="calendar.ics"');



            $subscription = SubscriptionService::getSubscriptionByToken($_GET['token']);

            if(!$subscription) {
                header("Content-Length: 0");
                exit();
            } 

            $reservations = SubscriptionService::getReservationBySubscription($subscription->getId());

            header("Content-type:text/calendar; charset=utf-8");
            header('Content-Disposition: attachment; filename="calendar.ics"');
            header('Content-Length: '. strlen(generateICal($reservations)));
            header('Connection: close');
            echo html_entity_decode(generateICal($reservations));
            // Génération et affichage du fichier iCal
            exit;
//         } else {
//             echo "Reservation not found.";
//         }
//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }
// }
?>
