<?php
require_once("../../../services/ReservationService.php");

session_start();

function getSort($methodName, $isReverse = false)
{
    if ($isReverse) {
        return function ($a, $b) use ($methodName) {
            $aValue = $a->$methodName();
            $bValue = $b->$methodName();
            return $bValue <=> $aValue;
        };
    } else {
        return function ($a, $b) use ($methodName) {
            $aValue = $a->$methodName();
            $bValue = $b->$methodName();
            return $aValue <=> $bValue;
        };
    }
}

function showReservations($reservations) {
    if (empty($reservations)) { ?>
        <p class="no-reservation">Vous n'avez aucune réservation.</p>
    <?php 
    } else {
    foreach ($reservations as $reservation) { ?>
        <div class="reservation">
            <?php require_once("../../components/CheckBox/CheckBox.php"); CheckBox::render(name: "checkbox"); ?>
            <p><?= $reservation->getBeginDate()->format("d / m / Y") ?></p>
            <a href="#" class="profile-picture"><img src="<?= $reservation->getClientId()->getImage()->getImageSrc() ?>" alt="profile picture"><?= $reservation->getClientId()->getNickname() ?></a>
            <a href="#"><?= $reservation->getHousingId()->getTitle() ?></a>
            <p><?= $reservation->getBeginDate()->format("d / m / Y") ?></p>
            <p><?= $reservation->getEndDate()->format("d / m / Y") ?></p>
            <p><?= $reservation->getPayMethodId()->getLabel() ?></p>
            <p class="description-status"><?= $reservation->getStatus() ?><span class="status status--<?= match ($reservation->getStatus()) {
                "En cours" => "in-progress",
                "Terminée" => "done",
                "Prochainement" => "coming",
                default => ""
            } ?>"></span></p>
            <a href="/back/detail-reservation?reservationID=<?= $reservation->getId() ?>" class="goTo"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
    <?php 
    }}
}

$reservations = $_SESSION["reservations"];

if (isset($_POST["sort"])) {
    $sort = $_POST["sort"];
    $isReverse = filter_var($_POST["isReverse"], FILTER_VALIDATE_BOOLEAN);
    uasort($reservations, getSort($sort, $isReverse));
}

showReservations($reservations);
?>