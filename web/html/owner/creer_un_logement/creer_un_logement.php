<?php
require_once '../../../services/SessionService.php';

// Gestion de la session
SessionService::system('owner', '/back/creer-logement');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un logement</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/creer_un_logement/creer_un_logement.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/components/Toast/Toast.css">
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        
        Header::render(isScrolling: True, isBackOffice: True);
    ?>

    <main>
        <nav>
            <ul>
                <li class="active"><a href="">Description</a></li>
                <li><a href="">Localisation</a></li>
                <li><a href="">Caractéristiques</a></li>
                <li><a href="">Aménagements</a></li>
                <li><a href="">Activités</a></li>
            </ul>
        </nav>
        <section>

        </section>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>