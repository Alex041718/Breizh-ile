<?php
require_once '../../../services/SessionService.php';

// Gestion de la session
SessionService::system('owner', '/back/reservations');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des réservations</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/consulter_reservations/consulter_reservations.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");
        require_once("../../../services/ReservationService.php");
        require_once("../../../services/OwnerService.php");

        $owner = OwnerService::getOwnerById($_SESSION['user_id']);

        $reservations = ReservationService::getAllReservationsByOwnerID($owner->getOwnerID());

        $selected_reservations = array();

        Header::render(isScrolling: True, isBackOffice: True);
        OwnerNavBar::render(2);
    ?>
    <main>
        <h3>Vos réservations</h3>
        <section class="title">
            <?php
                require_once("../../components/CheckBox/CheckBox.php");
                CheckBox::render(name: "checkboxAll");
            ?>
            <p>Date de réservation</p>
            <p>Client</p>
            <p>Logement</p>
            <p>Date d'arrivée</p>
            <p>Date de départ</p>
            <p>Méthode de paiement</p>
            <p>Status</p>
            <button class="filter"><i class="fa-solid fa-filter"></i></button>
        </section>
        <section class="reservations">
            <?php if (empty($reservations)) { ?>
                <p class="no-reservation">Vous n'avez aucune réservation.</p>
            <?php } else { ?>
            <?php foreach ($reservations as $reservation) { ?>
            <div class="reservation">
                <?php
                    require_once("../../components/CheckBox/CheckBox.php");
                    CheckBox::render(name: "checkbox");
                ?>
                <p><?= $reservation->getBeginDate()->format("d / m / Y") ?></p>
                <a href="#" class="profile-picture"><img src="<?= $reservation->getClientId()->getImage()->getImageSrc() ?>" alt="profile picture">
                <?= $reservation->getClientId()->getNickname() ?>
                </a>
                <a href="#"><?= $reservation->getHousingId()->getTitle() ?></a>
                <p><?= $reservation->getBeginDate()->format("d / m / Y") ?></p>
                <p><?= $reservation->getEndDate()->format("d / m / Y") ?></p>
                <p><?= $reservation->getPayMethodId()->getLabel() ?></p>
                <p class="description-status"><?= $reservation->getStatus() ?><span class="status 
                <?=
                    match ($reservation->getStatus()) {
                        "En cours" => "in-progress",
                        "Terminée" => "done",
                        "Prochainement" => "coming",
                        default => ""
                    }
                ?>"></span></p>
                <button class="export"><i class="fa-solid fa-file-export"></i></button>
            </div>
            <?php }} ?>
        </section>
        <?php
            require_once("../../components/Button/Button.php");
            Button::render("exportation__button", "exportationButton", "Exporter la sélection", ButtonType::Owner, false, false, false, '<i class="fa-solid fa-file-export"></i>'); 
        ?>

        <script src="/owner/consulter_reservations/consulter_reservations.js"></script>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>