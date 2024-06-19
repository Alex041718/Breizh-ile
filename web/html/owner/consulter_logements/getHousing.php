<?php
require_once("../../../services/HousingService.php");
require_once("../../components/Popup/popup.php");
require_once("../../components/Button/Button.php");

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
    $codePopUp = /*html*/ '
        <section class="description-action">
            <h3>Changer la visibilité</h3>
            <p>Êtes-vous sûr de vouloir changer la visibilité de ce logement ?</p>
        </section>
        <section class="actions">
            <button type="button" class="button undo__button button--owner--secondary button--bleu " id="undoButton" onclick="document.querySelector(\'.popUpVisibility\').classList.remove(\'popup--open\');">Annuler</button>
            <button type="button" class="button accept__button button--delete button--rouge " id="acceptButton" onclick="">Changer la visibilité</button>
        </section>
    ';

    if (empty($housings)) { ?>
        <p class="no-housing">Vous n'avez aucun logement.</p>
    <?php
    } else {
    foreach ($housings as $index=>$housing) { ?>
        <a href="/back/logements/<?= $housing->getHousingID() ?>" class="housing">
            <img src="<?= $housing->getImage()->getImageSrc() ?>" alt="Image de logement">
            <p><?= $housing->getTitle() ?></p>
            <p><?= $housing->getAddress()->getPostalAddress() ?></p>
            <p><?= $housing->getPriceIncl() ?></p>
            <p><?= $housing->getNbPerson() ?></p>
            <p><?= $housing->getBeginDate()->format("d / m / Y") ?></p>
            <p><?= $housing->getEndDate()->format("d / m / Y") ?></p>
            <p class="description-status"><?= $housing->getIsOnline() ? "En ligne" : "Hors ligne" ?><span class="status status--<?= $housing->getIsOnline() ? "online" : "offline" ?>"></span></p>
            <button data-housingid="<?= $housing->getHousingID() ?>" data-index="<?= $index ?>" id="popUpVisibility-btn" class="eye visibilityButtons" onclick="event.preventDefault()"><i class="fa-solid fa-eye"></i></button>
        </a>
    <?php 
    }}

    PopUp::render("popUpVisibility", "popUpVisibility-btn", $codePopUp);
}

$housings = $_SESSION["housings"];

if (isset($_POST["sort"])) {
    $sort = $_POST["sort"];
    $isReverse = filter_var($_POST["isReverse"], FILTER_VALIDATE_BOOLEAN);
    uasort($housings, getSort($sort, $isReverse));
}

showHousings($housings);
?>