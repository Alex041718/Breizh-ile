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
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }

    $owner = OwnerService::GetOwnerById($_SESSION['user_id']);
    $ownerId = $owner->getOwnerID();
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];

    if (empty($startDate) || empty($endDate)) {
        header("Location: /owner/consulter_reservations/gerer_abonnements_ical.php");
        exit();
    }

    // Assuming you have a function to generate a unique token
    $token = generateUniqueToken();

    // Save the subscription details to the database (implement this function)
    // saveSubscription($ownerId, $token, $startDate, $endDate, );

    // $reservationId = $reservations[0]->getId(); // Assuming $reservations is an array of Reservation objects

    $url = "http://localhost:5555/owner/consulter_reservations/gerer_abonnements_ical.php?token=$token";

    SubscriptionService::CreateSubscription(new Subscription(null, $token, $startDate, $endDate, $ownerId), $reservations);



    header("Location: " . $url);



}

function generateUniqueToken() {
    return bin2hex(random_bytes(32));
}

