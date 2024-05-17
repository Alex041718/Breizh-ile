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

        Header::render(isScrolling: True, isBackOffice: True);
        OwnerNavBar::render();
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
            <p>Date de départ</p>
            <p>Date d'arrivée</p>
            <p>Méthode de paiement</p>
            <p>Status</p>
        </section>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>