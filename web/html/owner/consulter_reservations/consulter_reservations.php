<?php
require_once '../../../services/SessionService.php';

// Gestion de la session

SessionService::system('owner', '/back/reservations');

$isOwnerAuthenticated = SessionService::isOwnerAuthenticated();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des réservations</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/consulter_reservations/consulter_reservations.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/components/Toast/Toast.css">
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

        Header::render(True, True, $isOwnerAuthenticated, '/back/reservations');
        OwnerNavBar::render(2);
    ?>
    <main>
        <div class="top-container">
            <h3>Vos réservations</h3>
            <div class="top-container__right">
                <button class="top-container__right__button">Terminée</button>
                <button class="top-container__right__button">En cours</button>
                <button class="top-container__right__button">Prochainement</button>
                <div class="top-container__right__slider"></div>
            </div>
        </div>
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
            <p data-sort="status">Statut</p>
            <button class="filter"><i class="fa-solid fa-filter"></i></button>
        </section>
        <section class="reservations">
            <script type="module" src="/owner/consulter_reservations/consulter_reservations.js"></script>
        </section>
        <?php
            require_once("../../components/Button/Button.php");
            Button::render("exportation__button", "exportationButton", "Exporter la sélection", ButtonType::Owner, false, false, false, '<i class="fa-solid fa-file-export"></i>');
        ?>
        <section class="export-selection">
            <section class="export-selection__CSV">
                <?php
                    require_once("../../components/CheckBox/CheckBox.php");
                    CheckBox::render(name: "checkboxCSV", class: "checkboxCSV", checked: true);
                ?>
                <img src="https://static-00.iconduck.com/assets.00/csv-icon-1791x2048-ot22nr8i.png" alt="icone CSV">
                <p>CSV</p>
            </section>
            <section class="export-selection__ICAL">
                <?php
                    require_once("../../components/CheckBox/CheckBox.php");
                    CheckBox::render(name: "checkboxICAL", class: "checkboxICAL", checked: true);
                ?>
                <img src="https://s3.amazonaws.com/s3.roaringapps.com/assets/icons/1610972759099-Calendar.png" alt="icone iCal">
                <p>iCal</p>
            </section>
            <button class="closeExport"><i class="fa-solid fa-xmark"></i></button>
        </section>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>
