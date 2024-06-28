<?php
require_once '../../../services/SessionService.php';
require_once '../../../services/OwnerService.php';
require_once '../../../services/ReservationService.php';
require_once '../../../services/SubscriptionService.php';

header('Content-Type: application/json');

SessionService::system('client', '/');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isClientAuthenticated = SessionService::isClientAuthenticated();

    if (!$isClientAuthenticated) {
        header("Location: /");
        exit();
    }

    if (!isset($_POST['start-date']) || !isset($_POST['end-date']) || !isset($_POST['reservationIDs'])) {
        header("Location: /client/consulter_reservations/gerer_abonnements_ical.php?error=Veuillez%20saisir%20tous%20les%20champs.");
        exit();
    }

    $client = ClientService::GetClientById($_SESSION['user_id']);
    $clientId = $client->getClientID();
    $startDate = new DateTime($_POST['start-date']);
    $endDate = new DateTime($_POST['end-date']);
    $reservationIDs = explode(",", $_POST['reservationIDs']);

    // Assuming you have a function to generate a unique token
    $token = generateUniqueToken();

    $reservations = [];
    $clientReservations = ReservationService::getAllReservationsByClientID($clientId);

    // Initialiser une liste vide pour stocker les IDs
    $clientReservationIDs = [];

    // Parcourir chaque objet de réservation et récupérer son ID
    foreach ($clientReservations as $reservation) {
        $clientReservationIDs[] = $reservation->getId();
    }

    foreach ($reservationIDs as $reservationID) {
        if(!in_array($reservationID, $clientReservationIDs)) continue;
        $reservations[] = ReservationService::getReservationByID($reservationID);
    }

    $url = "http://" . $_SERVER['HTTP_HOST'] . '/client/consulter_reservations/gerer_abonnements_ical.php?token=' . $token;

    SubscriptionService::CreateSubscription(new Subscription(null, $token, $startDate, $endDate, $clientId), $reservations);



    header("Location: " . $url);



}

function generateUniqueToken() {
    return bin2hex(random_bytes(32));
}

