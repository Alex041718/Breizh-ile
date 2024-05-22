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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/Input/Input.php");
        require_once("../../components/Button/Button.php");
        require_once("../../components/ImagePicker/ImagePicker.php");
        require_once("../../components/Image/Image.php");
        
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
                        <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                        <?php Input::render("content__input--large content__input--long", "shortdesc", "textarea", "Accroche", "shortdesc", "Détaillez votre logement en 3 lignes", true, '', 0, 255); ?>
                        <?php Input::render("content__input--large content__input--very-long", "longdesc", "textarea", "Description détaillée", "longdesc", "Détaillez précisement votre logement", false, '', 0, 8000); ?>
                        <?php Button::render("content__button content__button--next", "nextButton", "Suivant", ButtonType::Owner, "", false, false); ?>
                    </section>
                </section>
                <section class="content__right">
                    <?php ImagePicker::render("content__imagePicker", "imagePicker"); ?>
                </section>
            </section>
            <section class="content localisation">
                <section class="content__left">
                    <section>
                        <section class="inline">
                            <?php Input::render("half content__input--large", "postalCode", "text", "Code Postal", "postalCode", "Ex: 29200", true, '', 0, 100); ?>
                            <?php Input::render("wide content__input--large", "city", "text", "Ville", "city", "Entrez la ville de votre logement", true, '', 0, 100); ?>
                        </section>
                        <?php Input::render("content__input--large", "postalAddress", "text", "Addresse", "postalAddress", "Entrez l'adresse de votre logement", true, '', 0, 100); ?>
                        <section class="inline">
                            <?php Input::render("content__input--large", "longitude", "text", "Longitude", "longitude", "Ex: 48.202047", false, '', 0, 100); ?>
                            <?php Input::render("content__input--large", "latitude", "text", "Latitude", "latitude", "Ex: -2.932644", false, '', 0, 100); ?>
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
                    <?php Input::render("content__input--large", "title", "text", "Prix par nuit", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                    <?php Input::render("content__input--large", "title", "text", "Nombre minimum de nuit", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                    <?php Input::render("content__input--large", "title", "text", "Délai minimum entre réservation et arrivée", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                </section>
                <p>Spécifications</p>
                <span class="separator"></span>
                <section class="content__bottom">
                    <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                    <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                    <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                    <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                    <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                    <?php Input::render("content__input--large", "title", "text", "Title", "title", "Entrez un titre pour votre logement", true, '', 0, 100); ?>
                </section>
                <?php Button::render("content__button content__button--next", "nextButton", "Suivant", ButtonType::Owner, "", false, false); ?>
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