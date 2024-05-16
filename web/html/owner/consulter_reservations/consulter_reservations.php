<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des réservations</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="consulter_reservations.css">
    <link rel="stylesheet" href="../../components/OwnerNavBar/ownerNavBar.css">
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");

        Header::render(True, True);
        OwnerNavBar::render();
    ?>
    <main>
        <h3>Vos réservations</h3>
        <section class="title">
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
        </section>
    </main>
</body>
</html>