<?php

require_once("../../components/Header/header.php");
require_once("../../components/HousingCard/HousingCard.php");
require_once("../../../services/ReservationService.php");
require_once("../../../services/HousingService.php");
require_once("../../../services/OwnerService.php");
require_once("../../../services/SessionService.php");
require_once("../../../services/TypeService.php");
require_once("../../../services/CategoryService.php");
require_once("../../../services/ArrangementService.php");
require_once("../../../services/PayementMethodService.php");

$owner = OwnerService::GetOwnerById($_GET['ownerID']);

$owner_lastConnection = $owner->getLastConnection()->format('d-m-Y') ?? "jamais" ;
$owner_birthDate = $owner->getBirthDate()->format('d-m-Y');
$owner_postalAddress = $owner->getAddress()->getPostalAddress();
$owner_city = $owner->getAddress()->getCity();
$owner_postalCode = $owner->getAddress()->getPostalCode();
$owner_phone = $owner->getPhoneNumber();
$owner_email = $owner->getMail();
$owner_inscription = $owner->getCreationDate();
$owner_nickname = $owner->getNickname();
$owner_firstname = $owner->getFirstname();
$owner_lastname = $owner->getLastname();
$owner_pp = $owner->getImage()->getImageSrc();
$owner_telephone = $owner->getPhoneNumber();
$owner_mail = $owner->getMail();
$owner_isVerified = $owner->getIsValidated();

$isAuthenticated = SessionService::isClientAuthenticated();
echo "test";

$owner_housings = HousingService::getAllHousingsByOwnerID($_GET['ownerID']);

$nb_housing = sizeof($owner_housings);

$annonceText = ($nb_housing > 1 ? $nb_housing . " annonces" : ($nb_housing === 0 ? "Aucune annonce" : $nb_housing . " annonce"))

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/client/consulter_profil/consulter_profil.css" class="css">
    <link rel="stylesheet" href="/style/ui.css" class="css">
</head>
<body>
    <?php Header::render(true,false, $isAuthenticated, '/client/reservations-liste'); ?>
    <main class="global-ui">
        <?php
        require_once("../../components/BackComponent/BackComponent.php");
        BackComponent::render("backButton", "", "Retour", "");
        ?>
        <div class="page-content">
        <div class="topcontent">
            <div class="topcontent__presentation">
                <img src=<?= $owner_pp ?> alt="Photo de profil">
                <div class="topcontent__presentation__info">
                    <h3><?= $owner_firstname . " " . $owner_lastname . " (" . $owner_nickname . ")" ?></h3>
                    <p>Dernière connexion: <?= $owner_lastConnection ?></p>
                </div>
            </div>
            <h3 class="topcontent__presentation__birthdate"><?= $annonceText ?></h3>
        </div>
        <div class="bottomcontent">
            <div class="bottomcontent__column">
            
                <div class="bottomcontent__column__info">
                    <i class="fa-solid fa-circle-info"></i>
                    <h4>Carte d’identité vérifiée</h4>
                </div>
                <div class="bottomcontent__column__info">
                    <i class="fa-solid fa-house"></i>
                    <h4>Habite à <?= $owner_city ?></h4>
                </div>
                <div class="bottomcontent__column__info">
                    <i class="fa-solid fa-calendar"></i>
                    <h4>Inscrit depuis <?= $owner_inscription->format("Y") ?></h4>
                </div>
            </div>
        </div>
        <hr>
        <div class="housings-content">
            <h3>Logements</h3>
            <div class="housings-content__items">
                <?php 
                if(sizeof($owner_housings) > 0) {
                    foreach ($owner_housings as $housing) {
                        HousingCard::render($housing, "", "", "");
                    }
                 }
                 else {
                    echo "<p class='nothing'>Le propriétaire n'a aucun logement</p>";
                 } ?>
            </div>
        </div>
        </div>
    </main>
    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(false);
    ?>
</body>
</html>