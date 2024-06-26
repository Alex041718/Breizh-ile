<?php
require_once '../../../services/SessionService.php';
require_once '../../../services/OwnerService.php';
require_once '../../../services/ReservationService.php';

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
    $reservations = $_POST['reservations'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if (empty($reservations) || empty($startDate) || empty($endDate)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit();
    }

    // Assuming you have a function to generate a unique token
    $token = generateUniqueToken();

    // Save the subscription details to the database (implement this function)
    saveSubscription($ownerId, $token, $startDate, $endDate, $reservations);

    // $reservationId = $reservations[0]->getId(); // Assuming $reservations is an array of Reservation objects

    $url = "http://localhost:5555/owner/consulter_reservations/iCal.php?token=$token&startDate=$startDate&endDate=$endDate";
    echo json_encode(['success' => true, 'url' => $url]);
}

function generateUniqueToken() {
    return bin2hex(random_bytes(16));
}

function saveSubscription($ownerId, $token, $startDate, $endDate, $reservations) {
    // Implement the logic to save the subscription details to the database
    // Example:
    // INSERT INTO subscriptions (owner_id, token, start_date, end_date, reservations) VALUES (?, ?, ?, ?, ?)
}
