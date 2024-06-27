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

    if (!isset($_POST['start-date']) || !isset($_POST['end-date']) || !isset($_POST['reservationIDs'])) {
        header("Location: /owner/consulter_reservations/gerer_abonnements_ical.php");
        exit();
    }

    $owner = OwnerService::GetOwnerById($_SESSION['user_id']);
    $ownerId = $owner->getOwnerID();
    $startDate = new DateTime($_POST['start-date']);
    $endDate = new DateTime($_POST['end-date']);
    $reservationIDs = explode(",", $_POST['reservationIDs']);

    // Assuming you have a function to generate a unique token
    $token = generateUniqueToken();

    $reservations = [];

    foreach ($reservationIDs as $reservationID) {
        $reservations[] = ReservationService::getReservationByID($reservationID);
    }

    // Save the subscription details to the database (implement this function)
    // saveSubscription($ownerId, $token, $startDate, $endDate, );

    // $reservationId = $reservations[0]->getId(); // Assuming $reservations is an array of Reservation objects

    $url = "http://" . $_SERVER['HTTP_HOST'] . '/owner/consulter_reservations/gerer_abonnements_ical.php?token=' . $token;

    SubscriptionService::CreateSubscription(new Subscription(null, $token, $startDate, $endDate, $ownerId), $reservations);



    header("Location: " . $url);



}

function generateUniqueToken() {
    return bin2hex(random_bytes(32));
}

