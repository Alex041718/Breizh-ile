<?php

// Il faut tout ceci pour récupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php'; // pour le menu du header



// Vérification de l'authentification de l'utilisateur

SessionService::system('client', '/client/reservations-liste');
$isAuthenticated = SessionService::isClientAuthenticated();

require_once '../../../services/Service.php';
require_once '../../../services/ReservationService.php';
require_once("../../components/ReservationCard/ReservationCard.php");
require_once("../../components/Header/header.php");



$client = ClientService::GetClientById($_SESSION['user_id']);
$clientReservationList = ReservationService::getReservationByClientId($client->getClientID());

// batch pour créer les factures des reservations qui n'en possèdent pas
require_once '../../../services/ReceiptService.php';
ReceiptService::createReceiptsForReservationsWithoutReceipt($client->getClientID());


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
    <script src="/components/ReservationCard/ReservationCard.js"></script>
    <title>Vos réservation</title>

</head>
<?php
require_once("../../components/Header/header.php");
Header::render(true,false, $isAuthenticated, '/client/reservations-liste');
?>
<body>
<main class="global-ui">


    <?php
        require_once("../../components/BackComponent/BackComponent.php");
        BackComponent::render("", "", "Retour", "");
    ?>

    <div class="topcontent">
        <h2 class="title">Vos réservations</h2>
        <?php require_once("../../components/Button/button.php");
        Button::render("connection__button","id","Exporter avec ICalendar",ButtonType::Client,"window.location.href = '/client/exporter'",false); ?>
    </div>

    <div class="reservation-list">

        <div class="reservation-list__container">
            <?php if (empty($clientReservationList)) : ?>
            <div class="reservation-list__container__empty">
                <h4>Aucune réservation trouvée.</h4>
                <h4>Louez un logement dès maintenant <a href="/">ici</a></h4>
            </div>

            <?php else : ?>
                <?php foreach ($clientReservationList as $index => $reservationItem) : ?>
                    <div class="reservation-list__container__card" data-index="<?php echo $index; ?>">
                        <?php ReservationCard::render("reservation-list__container__card__render", "", $reservationItem); ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php
require_once("../../components/Footer/footer.php");
Footer::render();
?>
</body>
</html>

