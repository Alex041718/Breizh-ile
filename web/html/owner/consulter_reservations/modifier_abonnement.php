<?php
require_once '../../../services/SessionService.php';
require_once '../../../services/OwnerService.php';
require_once '../../../services/ReservationService.php';
require_once '../../../services/SubscriptionService.php';

header('Content-Type: application/json');

SessionService::system('owner', '/back/reservations');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isOwnerAuthenticated = SessionService::isOwnerAuthenticated();

    if (!$isOwnerAuthenticated) {
        header("Location: /");
        exit();
    }

    if (!isset($_POST['token']) || !isset($_POST['start-date']) || !isset($_POST['end-date']) || !isset($_POST['reservationIDs'])) {
        header("Location: /owner/consulter_reservations/gerer_abonnements_ical.php?error=Veuillez%20saisir%20tous%20les%20champs.");
        exit();
    }

    $owner = OwnerService::GetOwnerById($_SESSION['user_id']);
    $token = $_POST['token'];
    $ownerId = $owner->getOwnerID();
    $startDate = new DateTime($_POST['start-date']);
    $endDate = new DateTime($_POST['end-date']);
    $reservationIDs = explode(",", $_POST['reservationIDs']);

    // Assuming you have a function to generate a unique token

    $reservations = [];
    $ownerReservations = ReservationService::getAllReservationsByOwnerID($ownerId);

    // Initialiser une liste vide pour stocker les IDs
    $ownerReservationIDs = [];

    // Parcourir chaque objet de réservation et récupérer son ID
    foreach ($ownerReservations as $reservation) {
        $ownerReservationIDs[] = $reservation->getId();
    }

    foreach ($reservationIDs as $reservationID) {
        if(!in_array($reservationID, $ownerReservationIDs)) continue;
        $reservations[] = ReservationService::getReservationByID($reservationID);
    }

    $url = "http://" . $_SERVER['HTTP_HOST'] . '/owner/consulter_reservations/gerer_abonnements_ical.php?token=' . $token;

    $id = SubscriptionService::getSubscriptionByToken($token)->getId();


    SubscriptionService::deleteSubscriptionByToken(SubscriptionService::getSubscriptionByToken($token));
    SubscriptionService::CreateSubscription(new Subscription($id, $token, $startDate, $endDate, $ownerId), $reservations);



    header("Location: " . $url);



}

function generateUniqueToken() {
    return bin2hex(random_bytes(32));
}

