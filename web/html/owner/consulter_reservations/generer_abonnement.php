<?php
require_once '../../../services/SessionService.php';
require_once '../../../services/OwnerService.php';
require_once '../../../services/ReservationService.php';

header('Content-Type: application/json');

SessionService::system('owner', '/back/reservations');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isOwnerAuthenticated = SessionService::isOwnerAuthenticated();

    if (!$isOwnerAuthenticated) {
        header("Location: /back");
        exit();
    }

    if (!isset($_POST['start-date']) || !isset($_POST['end-date'])) {
        header("Location: /owner/consulter_reservations/gerer_abonnements_ical.php?error=Veuillez%20saisir%20tous%20les%20champs.");
        exit();
    }

    $owner = OwnerService::GetOwnerById($_SESSION['user_id']);
    $ownerId = $owner->getOwnerID();
    // $reservations = $_POST['reservations'];
    $startDate = $_POST['start-date'];
    $endDate = isset($_POST['end-date']);

    // Assuming you have a function to generate a unique token
    $token = generateUniqueToken();

    // Save the subscription details to the database (implement this function)
    // saveSubscription($ownerId, $token, $startDate, $endDate, $reservations);

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