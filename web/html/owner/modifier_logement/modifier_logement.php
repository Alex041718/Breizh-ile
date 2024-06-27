<?php
require_once '../../../services/SessionService.php';

// Gestion de la session
SessionService::system('owner', '/back/modifier-logement');

$isOwnerAuthenticated = SessionService::isOwnerAuthenticated();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un logement</title>
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
        require_once("../../components/Input/Input.php");
        require_once("../../components/ComboList/ComboList.php");
        require_once("../../components/Button/Button.php");
        require_once("../../components/ImagePicker/ImagePicker.php");

        require_once("../../../services/CategoryService.php");
        require_once("../../../services/ActivityService.php");
        require_once("../../../services/ArrangementService.php");
        require_once("../../../services/TypeService.php");
        require_once("../../../services/PerimeterService.php");

        require_once '../../../models/Housing.php';
        require_once '../../../services/HousingService.php';

        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");
        require_once("../../../services/HousingService.php");
        require_once("../../../services/OwnerService.php");

        $owner = OwnerService::getOwnerById($_SESSION['user_id']);

        $housings = HousingService::getAllHousingsByOwnerID($owner->getOwnerID());
        $_SESSION["housings"] = $housings;

        Header::render(True, True, $isOwnerAuthenticated, '/back/modifier-logement');

        //Récupération des valeurs des champs grace à l'id en paramètre
        $housing = null;
        $amenagementList = [];
        $activitiesList = [];
        if(isset($_GET['housingID'])){
            $housing = HousingService::getHousingById($_GET['housingID']);
            $amenagementList = ArrangementService::GetArrangmentsByHousingId($_GET['housingID']);
            $activitiesList = ActivityService::GetActivityByHousingId($_GET['housingID']);

        }

        $housingTitle = $housing->getTitle() ?? "";
        $housingShortDesc = $housing->getShortDesc() ?? "";
        $housingDesc = $housing->getLongDesc() ?? "";
        $housingImg = $housing->getImage()->getImageSrc() ?? "";

        $housingAddress = $housing->getAddress();
        $housingPostalCode = $housingAddress->getPostalCode() ?? "";
        $housingCity = $housingAddress->getCity() ?? "";
        $housingCountry = $housingAddress->getCountry() ?? "";
        $housingComplementAddress = $housingAddress->getComplementAddress() ?? "";
        $housingStreetNumber = $housingAddress->getStreetNumber() ?? "";
        $housingAddressLabel = $housingAddress->getPostalAddress() ?? "";
        $housingLongitude = $housing->getLongitude() ?? "";
        $housingLatitude = $housing->getLatitude() ?? "";


        $housingPriceHT = $housing->getPriceExcl() ?? "";
        $housingBeginDate = $housing->getBeginDate() ? $housing->getBeginDate()->format('Y-m-d') : '';
        $housingEndDate = $housing->getEndDate()->format('Y-m-d') ?? "";
        $housingCategory = $housing->getCategory()->getLabel() ?? "";
        $housingType = $housing->getType()->getLabel() ?? "";
        $housingSurface = $housing->getSurfaceInM2() ?? "";
        $housingNbRooms = $housing->getNbRoom() ?? "";
        $housingNbSimpleBed = $housing->getNbSimpleBed() ?? "";
        $housingNbDoubleBed = $housing->getNbDoubleBed() ?? "";
        $housingNbPerson = $housing->getNbPerson() ?? "";



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
        <input type="hidden" name="housingID" id="housingID" value=<?= htmlspecialchars($_GET['housingID']) ?>>
        <section class="contents">
            <?php
            require_once("../../components/BackComponent/BackComponent.php");
            BackComponent::render("", "", "Retour", "");
            ?>
                <section class="content description">
                    <section class="content__left">
                        <section>
                            <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, $housingTitle, 0, 100); ?>
                            <?php Input::render("content__input--large content__input--long", "shortdesc", "textarea", "Accroche", "shortdesc", "Détaillez votre logement en 3 lignes", true, $housingShortDesc, 0, 255, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                            <?php Input::render("content__input--large content__input--very-long", "longdesc", "textarea", "Description détaillée", "longdesc", "Détaillez précisement votre logement", false, $housingDesc, 0, 8000, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                            <section class="inline">
                                <?php Button::render("content__button content__button--next", "validateButton", "Mettre à jour le logement", ButtonType::Owner, "", false, true, '<i class="fa-solid fa-check"></i>'); ?>
                                <?php Button::render("content__button content__button--back","cancelButton","Annuler",ButtonType::Delete,"", false, false, '<i class="fa-solid fa-xmark"></i>');?>
                            </section>
                        </section>
                    </section>
                    <section class="content__right">
                        <?php ImagePicker::render("content__imagePicker", "imagePicker", true, $housingImg); ?>
                    </section>
                </section>
                <section class="content localisation">
                    <section class="content__left">
                        <section>
                            <section class="inline">
                                <?php Input::render("content__input--large", "postalCode", "text", "Code Postal", "postalCode", "Ex: 29200", true, $housingPostalCode, 0, 5, "[0-9]{5}"); ?>
                                <?php Input::render("content__input--large", "city", "text", "Ville", "city", "Entrez la ville de votre logement", true, $housingCity, 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                            </section>
                            <section class="inline">
                                <?php Input::render("content__input--large", "streetNumber", "text", "Numéro de rue", "streetNumber", "", false, $housingStreetNumber, 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                                <?php Input::render("content__input--large", "complementAddress", "text", "Complément d'adresse", "complementAddress", "", false, $housingComplementAddress, 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                            </section>
                            <?php Input::render("content__input--large", "postalAddress", "text", "Adresse", "postalAddress", "Entrez l'adresse de votre logement", true, $housingAddressLabel, 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                            <?php Input::render("content__input--large", "country", "text", "Pays", "country", "Pays où se situe le logement", false, $housingCountry, 0, 100, '[A-Za-zÀ-ÖØ-öø-ÿ0-9 \(\)\',.!?\/\\-&~€]+'); ?>
                            <section class="inline">
                                <?php Input::render("content__input--large", "longitude", "text", "Longitude", "longitude", "Ex: 48.202047", false, $housingLongitude, 0, 100, '^-?([0-8]?[0-9]|90)(\.[0-9]{1,10})$'); ?>
                                <?php Input::render("content__input--large", "latitude", "text", "Latitude", "latitude", "Ex: -2.932644", false, $housingLatitude, 0, 100, '^-?([0-9]{1,2}|1[0-7][0-9]|180)(\.[0-9]{1,10})$'); ?>
                            </section>
                            <section class="inline">
                                <?php Button::render("content__button content__button--next", "validateButton", "Mettre à jour le logement", ButtonType::Owner, "", false, true, '<i class="fa-solid fa-check"></i>'); ?>
                                <?php Button::render("content__button content__button--back","cancelButton","Annuler",ButtonType::Delete,"", false, false, '<i class="fa-solid fa-xmark"></i>');?>
                            </section>
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
                        <?php Input::render("content__input--large", "priceHT", "text", "Prix par nuit", "priceHT", "Prix HT", true, $housingPriceHT, 0, 8, '[0-9]+\.[0-9]{1,2}'); ?>
                        <?php Input::render("content__input--large", "beginDate", "text", "Date minimale", "beginDate", "Entrez la date minimale", false, $housingBeginDate, 0, 40, '(^0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d{4}$)'); ?>
                        <?php Input::render("content__input--large", "endDate", "text", "Date maximale", "endDate", "Entrez la date maximale", false, $housingEndDate, 0, 40, '(^0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d{4}$)'); ?>
                    </section>
                    <p>Spécifications</p>
                    <span class="separator"></span>
                    <section class="content__bottom">
                        <?php ComboList::render("content__combo", "category", "Catégorie du logement", "category", CategoryService::getAllCategoriesAsArrayOfString(), "Catégories", true, $housingCategory) ?>
                        <?php ComboList::render("content__combo", "type", "Type du logement", "type", TypeService::getAllTypesAsArrayOfString(), "Types", true, $housingType) ?>
                        <?php Input::render("content__input--large", "surface", "text", "Surface habitable", "surface", "Surface (en m²)", false, $housingSurface, 0, 4, '[0-9]{1,4}'); ?>
                    </section>
                    <section class="content__bottom">
                        <?php Input::render("content__input--large", "nbRooms", "text", "Nombre de chambres", "nbRooms", "Nombre de chambres", false, $housingNbRooms, 0, 2, '[0-9]{1,2}'); ?>
                        <?php Input::render("content__input--large", "nbSimpleBed", "text", "Nombre de lits simples", "nbSimpleBed", "Nombre de lits simples", false, $housingNbSimpleBed, 0, 2, '[0-9]{1,2}'); ?>
                        <?php Input::render("content__input--large", "nbDoubleBed", "text", "Nombre de lits doubles", "nbDoubleBed", "Nombre de lits doubles", false, $housingNbDoubleBed, 0, 2, '[0-9]{1,2}'); ?>
                    </section>
                    <section class="content__bottom">
                        <?php Input::render("content__input--large", "nbPerson", "text", "Nombre de personnes max", "nbPerson", "Nombre de personnes", false, $housingNbPerson, 0, 2, '[0-9]{1,2}'); ?>
                    </section>
                    <section class="inline">
                        <?php Button::render("content__button content__button--next", "validateButton", "Mettre à jour le logement", ButtonType::Owner, "", false, true, '<i class="fa-solid fa-check"></i>'); ?>
                        <?php Button::render("content__button content__button--back","cancelButton","Annuler",ButtonType::Delete,"", false, false, '<i class="fa-solid fa-xmark"></i>');?>
                    </section>                </section>
                <section class="content arrangements">
                    <section class="content__up">
                        <?php ComboList::render("content__combo", "arrangement", "Choisissez l'aménagement", "arrangement", ArrangementService::getAllArrangementsAsArrayOfString(), "Aménagements", false) ?>
                        <?php Button::render("content__button", "addButtonArrangements", "Ajouter", ButtonType::Owner, "", false, false); ?>
                    </section>
                    <span class="separator separator--large"></span>
                    <section class="content__bottom">
                        <div class="items items-arrangements">
                            <?php foreach($amenagementList as $amenagement): ?>
                                <div class="item-arrangement item">
                                    <p><?= htmlspecialchars($amenagement->getLabel()) ?></p>
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <section class="inline">
                        <?php Button::render("content__button content__button--next", "validateButton", "Mettre à jour le logement", ButtonType::Owner, "", false, true, '<i class="fa-solid fa-check"></i>'); ?>
                        <?php Button::render("content__button content__button--back","cancelButton","Annuler",ButtonType::Delete,"", false, false, '<i class="fa-solid fa-xmark"></i>');?>
                    </section>                </section>
                <section class="content activities">
                    <section class="content__up">
                        <?php ComboList::render("content__combo", "activity", "Choisissez l'activité", "activity", ActivityService::getAllActivitiesAsArrayOfString(), "Activités", false) ?>
                        <?php ComboList::render("content__combo", "perimeter", "Périmètre géographique", "perimeter", PerimeterService::GetAllPerimetersAsArrayOfString(), "Périmètres", false) ?>
                        <?php Button::render("content__button", "addButtonActivities", "Ajouter", ButtonType::Owner, "", false, false); ?>
                    </section>
                    <span class="separator separator--large"></span>
                    <section class="content__bottom">
                        <div class="items items-activities">
                            <?php foreach ($activitiesList as $activity) { ?>
                                <div class="item-activity item">
                                    <div class="activity-text">
                                        <p><?= $activity['activityLabel'] ?></p>
                                        <p><?= $activity['perimeterLabel'] ?></p>
                                    </div>
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                            <?php } ?>
                        </div>
                    </section>
                    <section class="inline">
                        <?php Button::render("content__button content__button--next", "validateButton", "Mettre à jour le logement", ButtonType::Owner, "", false, true, '<i class="fa-solid fa-check"></i>'); ?>
                        <?php Button::render("content__button content__button--back","cancelButton","Annuler",ButtonType::Delete,"", false, false, '<i class="fa-solid fa-xmark"></i>');?>
                    </section>

                </section>
            </section>
        <script type="module" src="modifier_logement.js"></script>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>