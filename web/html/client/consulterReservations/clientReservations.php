<?php

// Il faut tout ceci pour récupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php'; // pour le menu du header



// Vérification de l'authentification de l'utilisateur

SessionService::system('client', '/client/reservationsListe');
$isAuthenticated = SessionService::isClientAuthenticated();



require_once '../../../services/Service.php';
require_once '../../../services/ReservationService.php';
require_once("../../components/ReservationCard/ReservationCard.php");
require_once("../../components/Header/header.php");

$client = ClientService::GetClientById($_SESSION['user_id']);
$clientReservationList = ReservationService::getReservationByClientId($client->getClientID());
//sort by begin date
usort($clientReservationList, function ($a, $b) {
    return $a->getBeginDate() <=> $b->getBeginDate();
});
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/client/consulterReservations/clientReservations.css">
    <script src="../../components/ReservationCard/ReservationCard.js"></script>
<!--    <script src="clientReservations.js"></script>-->
    <title>Reservation History</title>

</head>
header
<?php
require_once("../../components/Header/header.php");
Header::render(true,false, $isAuthenticated);
?>
<body>
<main>
    <div class="title">
        <i class="fa-regular fa-less-than"></i>
        <h2 class="title__text">Historique des réservations</h2>
    </div>
    <div class="reservation-list">
        <div class="reservation-list__container">
            <?php foreach ($clientReservationList as $index => $reservationItem) : ?>
                <div class="reservation-list__container__card" data-index="<?php echo $index; ?>">
<!--                    -->
                    <?php ReservationCard::render("reservation-list__container__card__render", "", $reservationItem); ?>
<!--                    </a>-->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php
require_once("../../components/Footer/footer.php");
Footer::render();
?>
</body>
</html>

