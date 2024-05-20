<?php
require_once '../../../services/SessionService.php';

// Gestion de la session
SessionService::system('owner', '/owner/consulter_reservations/consulter_reservations.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des réservations</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="consulter_reservations.css">
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
        $_SESSION["reservations"] = $reservations;
        
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
            <p data-sort="date-resa">Date de réservation</p>
            <p data-sort="client">Client</p>
            <p data-sort="logement">Logement</p>
            <p data-sort="date-arrivee">Date d'arrivée</p>
            <p data-sort="date-depart">Date de départ</p>
            <p data-sort="methode-paiement">Méthode de paiement</p>
            <p data-sort="status">Status</p>
            <button class="filter"><i class="fa-solid fa-filter"></i></button>
        </section>
        <section class="reservations">
            <script src="consulter_reservations.js"></script>
        </section>
        <?php
            require_once("../../components/Button/Button.php");
            Button::render("exportation__button", "exportationButton", "Exporter la sélection", ButtonType::Owner, false, false, false, '<i class="fa-solid fa-file-export"></i>'); 
        ?>
        <section class="export-selection">
            <section class="export-selection__CSV">
                <?php
                    require_once("../../components/CheckBox/CheckBox.php");
                    CheckBox::render(name: "checkboxCSV");
                ?>
                <img src="https://cdn-icons-png.flaticon.com/512/9159/9159105.png" alt="icone CSV">
                <p>CSV</p>
            </section>
            <section class="export-selection__ICAL">
                <?php
                    require_once("../../components/CheckBox/CheckBox.php");
                    CheckBox::render(name: "checkboxICAL");
                ?>
                <img src="https://s3.amazonaws.com/s3.roaringapps.com/assets/icons/1610972759099-Calendar.png" alt="icone iCal">
                <p>iCal</p>
            </section>
        </section>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>