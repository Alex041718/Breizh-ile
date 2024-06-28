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
        <div class="reservation" data-reservationID="<?= $reservation->getId() ?>">
            <?php require_once("../../components/CheckBox/CheckBox.php"); CheckBox::render(name: "checkbox"); ?>
            <p><?= $reservation->getCreationDate()->format("d / m / Y") ?></p>
            <a href="/client/profil/<?= $reservation->getHousingID()->getOwner()->getOwnerID() ?>" class="profile-picture"><img src="<?= $reservation->getHousingID()->getOwner()->getImage()->getImageSrc() ?>" alt="profile picture"><?= $reservation->getHousingID()->getOwner()->getNickname() ?></a>
            <a href="#"><?= $reservation->getHousingID()->getTitle() ?></a>
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

if (isset($_POST["filter"])) {
    $filter = $_POST["filter"];
    $filter_values = ["Terminée", "En cours", "Prochainement"];

    $reservations = array_filter($reservations, fn($reservation) => $reservation->getStatus() === $filter_values[$filter]);
}

showReservations($reservations);
?>