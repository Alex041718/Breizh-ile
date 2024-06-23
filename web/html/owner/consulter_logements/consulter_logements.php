<?php
require_once '../../../services/SessionService.php';

// Gestion de la session
SessionService::system('owner', '/back/logements');

$isOwnerAuthenticated = SessionService::isOwnerAuthenticated();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des logements</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/consulter_logements/consulter_logements.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/components/Toast/Toast.css">
    <link rel="stylesheet" href="/components/Button/Button.css">
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");
        require_once("../../../services/HousingService.php");
        require_once("../../../services/OwnerService.php");

        $owner = OwnerService::getOwnerById($_SESSION['user_id']);

        $housings = HousingService::getAllHousingsByOwnerID($owner->getOwnerID());
        $_SESSION["housings"] = $housings;
        
        Header::render(True, True, $isOwnerAuthenticated, '/back/logements');
        OwnerNavBar::render(1);
    ?>
    <main>
        <h3>Vos logements</h3>
        <section class="title">
            <p data-sort="title">Titre</p>
            <p data-sort="address">Adresse</p>
            <p data-sort="price">Prix TTC</p>
            <p data-sort="nbPerson">Nombre personnes</p>
            <p data-sort="date-begin">Date début</p>
            <p data-sort="date-end">Date fin</p>
            <p data-sort="status">Status</p>
            <button class="filter"><i class="fa-solid fa-filter"></i></button>
        </section>
        <section class="housings">
            <script type="module" src="/owner/consulter_logements/consulter_logements.js"></script>
        </section>
        <?php
            require_once("../../components/Button/Button.php");
            Button::render("add__button", "addButton", "Ajouter un logement", ButtonType::Owner, "window.location.href = '/back/creer-logement';", false, false, '<i class="fa-solid fa-plus"></i>'); 
        ?>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>