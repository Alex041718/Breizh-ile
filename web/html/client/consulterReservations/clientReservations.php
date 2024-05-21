<?php
require_once '../../../services/Service.php';
require_once '../../../services/ReservationService.php';
require_once("../../components/ReservationCard/ReservationCard.php");
require_once("../../components/Header/header.php");
$clientReservationList = ReservationService::getReservationByClientId(1);
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
    <link rel="stylesheet" href="../style/ui.css">
    <link rel="stylesheet" href="clientReservations.css">
<!--    <script src="clientReservations.js"></script>-->
    <title>Reservation History</title>
<!--    FIXME : trouver une alternative a l'affichage des reservations-->
<!--    <style>-->
<!--        .reservation-card.hidden {-->
<!--            display: none;-->
<!--        }-->
<!--    </style>-->
</head>
<body>
<?php
require_once("../../components/Header/header.php");
Header::render(true);
?>
<div class="title">
    <i class="fa-regular fa-greater-than"></i>
    <h2 class="title__text">Historique de réservation</h2>
</div>
<div class="reservation-list">
    <div class="reservation-list__container">
        <?php foreach ($clientReservationList as $index => $reservationItem) : ?>
            <div class="reservation-list__container__card" data-index="<?php echo $index; ?>">
                <?php ReservationCard::render("reservation-list__container__card__render", "", $reservationItem); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
require_once("../components/Footer/footer.php");
Footer::render();
?>
</body>
</html>

