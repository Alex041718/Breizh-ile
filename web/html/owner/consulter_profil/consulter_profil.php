<?php

if(!isset($_GET['clientID']) || $_GET['clientID'] == "") {
    header('Location: /back/logements');
    exit();
};

require_once("../../components/Header/header.php");
require_once("../../../services/ReservationService.php");
require_once("../../../services/HousingService.php");
require_once("../../../services/ClientService.php");
require_once("../../../services/TypeService.php");
require_once("../../../services/CategoryService.php");
require_once("../../../services/ArrangementService.php");
require_once("../../../services/PayementMethodService.php");

$client = ClientService::GetClientById($_GET['clientID']);

$owner_lastConnection = $client->getLastConnection()->format('d-m-Y') ?? "jamais" ;
$owner_birthDate = $client->getBirthDate()->format('d-m-Y');
$owner_postalAddress = $client->getAddress()->getPostalAddress();
$owner_city = $client->getAddress()->getCity();
$owner_postalCode = $client->getAddress()->getPostalCode();
$owner_phone = $client->getPhoneNumber();
$owner_email = $client->getMail();
$owner_inscription = $client->getCreationDate();
$owner_nickname = $client->getNickname();
$owner_firstname = $client->getFirstname();
$owner_lastname = $client->getLastname();
$owner_pp = $client->getImage()->getImageSrc();
$owner_telephone = $client->getPhoneNumber();
$owner_mail = $client->getMail();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./consulter_profil.css" class="css">
</head>
<body>
    <?php Header::render(isScrolling: True, isBackOffice: True); ?>
    <main>
        <div class="topcontent">
            <div class="topcontent__presentation">
                <img src=<?= $owner_pp ?> alt="Photo de profil">
                <div class="topcontent__presentation__info">
                    <h3><?= $owner_firstname . " " . $owner_lastname . " (" . $owner_nickname . ")" ?></h3>
                    <p>Dernière connexion: <?= $owner_lastConnection ?></p>
                </div>
            </div>
            <h3 class="topcontent__presentation__birthdate">Né le <?= $owner_birthDate ?></h3>
        </div>
        <div class="bottomcontent">
            <div class="bottomcontent__column">
                <div class="bottomcontent__column__info">
                    <i class="fa-solid fa-house"></i>
                    <h4><?=$owner_postalAddress . " - " . $owner_postalCode . " " . $owner_city ?></h4>
                </div>
                <div class="bottomcontent__column__info">
                    <i class="fa-solid fa-phone"></i>
                    <h4><?= $owner_phone ?></h4>
                </div>
            </div>
            <div class="bottomcontent__column">
                <div class="bottomcontent__column__info">
                    <i class="fa-solid fa-envelope"></i>
                    <h4><?= $owner_email ?></h4>
                </div>
                <div class="bottomcontent__column__info">
                    <i class="fa-solid fa-calendar"></i>
                    <h4>Inscrit depuis <?= $owner_inscription->format("Y") ?></h4>
                </div>
            </div>
        </div>
    </main>
    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>