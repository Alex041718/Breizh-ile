<?php
require_once '../../../services/SessionService.php';
require_once("../../../services/OwnerService.php");

// Gestion de la session
SessionService::system('owner', '/back/creer-logement');

$owner = OwnerService::getOwnerById($_SESSION['user_id']);
$_SESSION["owner"] = $owner;
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/Input/Input.php");
        require_once("../../components/ComboList/ComboList.php");
        require_once("../../components/Button/Button.php");
        require_once("../../components/ImagePicker/ImagePicker.php");

        require_once("../../../services/CategoryService.php");
        require_once("../../../services/ActivityService.php");
        require_once("../../../services/ArrangementService.php");
        require_once("../../../services/TypeService.php");
        require_once("../../../services/PerimeterService.php");
        
        Header::render(isScrolling: True, isBackOffice: True);
    ?>

    <main>
        <nav>
            <ul>
                <li id="description" class="active"><span>Description</span></li>
                <li id="localisation"><span>Localisation</span></li>
                <li id="specifications"><span>Caractéristiques</span></li>
                <li id="arrangements"><span>Aménagements</span></li>
                <li id="activities"><span>Activités</span></li>
            </ul>
        </nav>
        <section class="contents">
            <section class="content description">
                <section class="content__left">
                    <section>
                        <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                        <?php Input::render("content__input--large content__input--long", "shortdesc", "textarea", "Accroche", "shortdesc", "Détaillez votre logement en 3 lignes", true, '', 0, 255, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                        <?php Input::render("content__input--large content__input--very-long", "longdesc", "textarea", "Description détaillée", "longdesc", "Détaillez précisement votre logement", false, '', 0, 8000, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                        <?php Button::render("content__button content__button--next", "nextButton", "Suivant", ButtonType::Owner, "", false, false); ?>
                    </section>
                </section>
                <section class="content__right">
                    <?php ImagePicker::render("content__imagePicker", "imagePicker", true); ?>
                </section>
            </section>
            <section class="content localisation">
                <section class="content__left">
                    <section>
                        <section class="inline">
                            <?php Input::render("half content__input--large", "postalCode", "text", "Code Postal", "postalCode", "Ex: 29200", true, '', 0, 5, "[0-9]{5}"); ?>
                            <?php Input::render("wide content__input--large", "city", "text", "Ville", "city", "Entrez la ville de votre logement", true, '', 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                        </section>
                        <?php Input::render("content__input--large", "postalAddress", "text", "Addresse", "postalAddress", "Entrez l'adresse de votre logement", true, '', 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                        <section class="inline">
                            <?php Input::render("content__input--large", "longitude", "text", "Longitude", "longitude", "Ex: 48.202047", false, '', 0, 100, '^-?([0-8]?[0-9]|90)(\.[0-9]{1,10})$'); ?>
                            <?php Input::render("content__input--large", "latitude", "text", "Latitude", "latitude", "Ex: -2.932644", false, '', 0, 100, '^-?([0-9]{1,2}|1[0-7][0-9]|180)(\.[0-9]{1,10})$'); ?>
                        </section>
                        <?php Button::render("content__button content__button--next", "nextButton", "Suivant", ButtonType::Owner, "", false, false); ?>
                    </section>
                </section>
                <section class="content__right">
                    <div id="map"></div>
                </section>
            </section>
            <section class="content specifications">
                <p>Détails réservation</p>
                <span class="separator"></span>
                <section class="content__up">
                    <?php Input::render("content__input--large", "priceHT", "text", "Prix par nuit", "priceHT", "Prix HT", true, '', 0, 8, '[0-9]+\.[0-9]{1,2}'); ?>
                    <?php Input::render("content__input--large", "beginDate", "text", "Date minimale", "beginDate", "Entrez la date minimale", false, '', 0, 40, '(^0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d{4}$)'); ?>
                    <?php Input::render("content__input--large", "endDate", "text", "Date maximale", "endDate", "Entrez la date maximale", false, '', 0, 40, '(^0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d{4}$)'); ?>
                </section>
                <p>Spécifications</p>
                <span class="separator"></span>
                <section class="content__bottom">
                    <?php ComboList::render("content__combo", "category", "Catégorie du logement", "category", CategoryService::getAllCategoriesAsArrayOfString(), "Catégories", true) ?>
                    <?php ComboList::render("content__combo", "type", "Type du logement", "type", TypeService::getAllTypesAsArrayOfString(), "Types", true) ?>
                    <?php Input::render("content__input--large", "surface", "text", "Surface habitable", "surface", "Surface (en m²)", false, '', 0, 4, '[0-9]{1,4}'); ?>
                </section>
                <section class="content__bottom">
                    <?php Input::render("content__input--large", "nbRooms", "text", "Nombre de chambres", "nbRooms", "Nombre de chambres", false, '', 0, 2, '[0-9]{1,2}'); ?>
                    <?php Input::render("content__input--large", "nbSimpleBed", "text", "Nombre de lits doubles", "nbSimpleBed", "Nombre de lits simples", false, '', 0, 2, '[0-9]{1,2}'); ?>
                    <?php Input::render("content__input--large", "nbDoubleBed", "text", "Nombre de lits simples", "nbDoubleBed", "Nombre de lits doubles", false, '', 0, 2, '[0-9]{1,2}'); ?>
                </section>
                <section class="content__bottom">
                    <?php Input::render("content__input--large", "nbPerson", "text", "Nombre de personnes max", "nbPerson", "Nombre de personnes", false, '', 0, 2, '[0-9]{1,2}'); ?>
                </section>
                <?php Button::render("content__button content__button--next", "nextButton", "Suivant", ButtonType::Owner, "", false, false); ?>
            </section>
            <section class="content arrangements">
                <section class="content__up">
                    <?php ComboList::render("content__combo", "arrangement", "Choisissez l'aménagement", "arrangement", ArrangementService::getAllArrangementsAsArrayOfString(), "Aménagements", false) ?>
                    <?php Button::render("content__button", "addButtonArrangements", "Ajouter", ButtonType::Owner, "", false, false); ?>
                </section>
                <span class="separator separator--large"></span>
                <section class="content__bottom">
                    <div class="items items-arrangements">
                        
                    </div>
                </section>
                <?php Button::render("content__button content__button--next", "nextButton", "Suivant", ButtonType::Owner, "", false, false); ?>
            </section>
            <section class="content activities">
                <section class="content__up">
                    <?php ComboList::render("content__combo", "activity", "Choisissez l'activité", "activity", ActivityService::getAllActivitiesAsArrayOfString(), "Activités", false) ?>
                    <?php ComboList::render("content__combo", "perimeter", "Périmètre géographique", "perimeter", PerimeterService::GetAllPerimetersAsArrayOfString(), "Périmètres", false) ?>
                    <?php Button::render("content__button", "addButtonActivities", "Ajouter", ButtonType::Owner, "", false, false); ?>
                </section>
                <span class="separator separator--large"></span>
                <section class="content__bottom">
                    <div class="items items-activities">
                        
                    </div>
                </section>
                <?php Button::render("content__button content__button--next", "validateButton", "Valider la création du logement", ButtonType::Owner, "", false, false, '<i class="fa-solid fa-check"></i>'); ?>
            </section>
        </section>
        <script type="module" src="/owner/creer_un_logement/creer_un_logement.js"></script>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>