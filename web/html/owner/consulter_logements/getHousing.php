<?php
require_once("../../../services/HousingService.php");

session_start();

function getSort($methodName, $isReverse = false)
{
    if ($isReverse) {
        return function ($a, $b) use ($methodName) {
            $aValue = $a->$methodName();
            $bValue = $b->$methodName();
            return $bValue <=> $aValue;
        };
    } else {
        return function ($a, $b) use ($methodName) {
            $aValue = $a->$methodName();
            $bValue = $b->$methodName();
            return $aValue <=> $bValue;
        };
    }
}

function showHousings($housings) {
    if (empty($housings)) { ?>
        <p class="no-housing">Vous n'avez aucun logement.</p>
    <?php
    } else {
    foreach ($housings as $housing) { ?>
        <a href="/back/logements/<?= $housing->getHousingID() ?>" class="housing">
            <img src="<?= $housing->getImage()->getImageSrc() ?>" alt="Image de logement">
            <p><?= $housing->getTitle() ?></p>
            <p><?= $housing->getAddress()->getPostalAddress() ?></p>
            <p><?= $housing->getPriceIncl() ?></p>
            <p><?= $housing->getNbPerson() ?></p>
            <p><?= $housing->getBeginDate()->format("d / m / Y") ?></p>
            <p><?= $housing->getEndDate()->format("d / m / Y") ?></p>
            <p class="description-status"><?= $housing->getIsOnline() ? "En ligne" : "Hors ligne" ?><span class="status status--<?= $housing->getIsOnline() ? "online" : "offline" ?>"></span></p>
            <button class="trash"><i class="fa-solid fa-trash"></i></button>
    <?php 
    }}
}

$housings = $_SESSION["housings"];

if (isset($_POST["sort"])) {
    $sort = $_POST["sort"];
    $isReverse = filter_var($_POST["isReverse"], FILTER_VALIDATE_BOOLEAN);
    uasort($housings, getSort($sort, $isReverse));
}

showHousings($housings);
?>