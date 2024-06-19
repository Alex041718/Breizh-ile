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
            <button class="eye visibilityButtons" onclick="
            event.preventDefault();

            let formData = new FormData();
            formData.append('housingID', <?= $housing->getHousingID() ?>);

            fetch('/owner/consulter_logements/changeHousingVisibility.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())

            const currentHousings = document.querySelectorAll('.housing')[<?= $index ?>];

            if (currentHousings.querySelector('.status').classList.contains('status--online')) {
                currentHousings.querySelector('.status').classList.remove('status--online');
                currentHousings.querySelector('.status').classList.add('status--offline');
                currentHousings.querySelector('.description-status').innerHTML = currentHousings.querySelector('.description-status').innerHTML.replace('En ligne', 'Hors ligne');
            } else {
                currentHousings.querySelector('.status').classList.remove('status--offline');
                currentHousings.querySelector('.status').classList.add('status--online');
                currentHousings.querySelector('.description-status').innerHTML = currentHousings.querySelector('.description-status').innerHTML.replace('Hors ligne', 'En ligne');
            }

            "><i class="fa-solid fa-eye"></i></button>
        </a>
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