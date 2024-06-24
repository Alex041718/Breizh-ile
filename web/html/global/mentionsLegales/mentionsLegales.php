<?php 
    // ------------------- Systeme de session -------------------
    // Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
    require_once '../../../models/Client.php';
    require_once '../../../services/ClientService.php';
    require_once '../../../services/SessionService.php'; // pour le menu du header

    // Vérification de l'authentification de l'utilisateur

    $isAuthenticated = SessionService::isClientAuthenticated();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales</title>

    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="mentionsLegales.css">
</head>
<body>
    <p id="auth" style="display:none"><?=$isAuthenticated?></p>
    <?php
    require_once("../../components/Header/header.php");
    Header::render(true,false, $isAuthenticated);
    ?>

    <main class="global-ui">
        <div class="mentions-legales">
            <h2>Mentions Légales</h2>

            <div class="publication">
                <h3>Responsable de la publication :</h3>
                <p class="para--18px">Mr. El Younsi Rayane<br>+33 6 11 23 34 67</p>
            </div>

            <div class="hebergeur">
                <h3>Hébergeur :</h3>
                <p class="para--18px">Bigpapoo&Co, 35 Av. Charles De Gaulle, 02 45 67 38 34, bigpapoo@hotmail.fr</p>
            </div>

            <div class="donnees-personnelles">
                <h3>Données à caractère personnel :</h3>
                <p class="para--18px">Les informations collectées sur ce site sont traitées conformément à notre politique de confidentialité. En utilisant ce site, vous consentez à ce que vos données soient collectées et utilisées selon les termes de cette politique.</p>
            </div>

            <div class="droit-auteur">
                <h3>Droit d'auteur :</h3>
                <p class="para--18px">Tous les contenus présents sur ce site, tels que les textes, les images, les logos, sont la propriété exclusive de Breizh’Ile ou de ses partenaires, et sont protégés par les lois nationales et internationales sur le droit d'auteur et la propriété intellectuelle.</p>
            </div>

            <div class="cookies">
                <h3>Cookies :</h3>
                <p class="para--18px">Ce site utilise des cookies pour améliorer votre expérience de navigation. En poursuivant votre navigation sur ce site, vous acceptez l'utilisation de cookies conformément à notre politique en matière de cookies.</p>
            </div>

            <div class="liens-externes">
                <h3>Liens externes :</h3>
                <p class="para--18px">Ce site peut contenir des liens vers des sites externes sur lesquels Breizh’Ile n'exerce aucun contrôle. Nous déclinons toute responsabilité quant au contenu de ces sites externes.</p>
            </div>

            <div class="litiges">
                <h3>Litiges</h3>
                <p class="para--18px">Tout litige relatif à l'utilisation de ce site est soumis au droit applicable en France, et sera de la compétence exclusive des tribunaux de Saint-Brieuc.</p>
            </div>

            <div class="contact">
                <h3>Contact :</h3>
                <p class="para--18px">Pour toute question ou demande concernant ces mentions légales, veuillez nous contacter à l'adresse suivante :<br>22 rue de la Crêpe, 22300 - Lannion ou par courriel à contact@breizh-ile.com.</p>
            </div>
        </div>
    </main>
    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render();
    ?>
</body>
</html>