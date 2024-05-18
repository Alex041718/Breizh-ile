<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des réservations</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="consulter_reservations.css">
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");
        require_once("../../../services/ReservationService.php");

        $reservations = ReservationService::getAllReservationsByOwnerID(470);

        Header::render(isScrolling: True, isBackOffice: True);
        OwnerNavBar::render(2);
    ?>
    <main>
        <h3>Vos réservations</h3>
        <section class="title">
            <?php
                require_once("../../components/CheckBox/CheckBox.php");
                CheckBox::render(name: "checkbox");
            ?>
            <p>Date de réservation</p>
            <p>Client</p>
            <p>Logement</p>
            <p>Date d'arrivée</p>
            <p>Date de départ</p>
            <p>Méthode de paiement</p>
            <p>Status</p>
        </section>
        <section class="reservations">
            <?php foreach ($reservations as $reservation) { ?>
            <div class="reservation">
                <?php
                    require_once("../../components/CheckBox/CheckBox.php");
                    CheckBox::render(name: "checkbox");
                ?>
                <p><?= $reservation->getBeginDate()->format("d / m / Y") ?></p>
                <a href="#" class="profile-picture"><img src="https://as2.ftcdn.net/v2/jpg/00/64/67/63/1000_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg" alt="profile picture"> Paul</a>
                <a href="#"><?= $reservation->getHousingId()->getTitle() ?></a>
                <p><?= $reservation->getBeginDate()->format("d / m / Y") ?></p>
                <p><?= $reservation->getEndDate()->format("d / m / Y") ?></p>
                <p><?= $reservation->getId() ?></p>
                <p><?= $reservation->getStatus() ?><span class="status 
                <?=
                    match ($reservation->getStatus()) {
                        "En cours" => "in-progress",
                        "Terminée" => "done",
                        "Prochainement" => "coming",
                        default => ""
                    }
                ?>"></span></p>
            </div>
            <?php } ?>
        </section>
        <?php
            require_once("../../components/Button/Button.php");
            Button::render("exportation__button", "exportationButton", "Exporter la sélection", ButtonType::Owner, false, false, false); 
        ?>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>