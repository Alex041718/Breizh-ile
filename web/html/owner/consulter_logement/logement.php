<?php
    
    if(isset($_GET["housingID"]) && $_GET["housingID"] != null) $housingID = $_GET["housingID"];
    else header("Location: /");
    

    require_once("../../../services/ReservationService.php");
    require_once("../../../services/HousingService.php");
    require_once("../../../services/OwnerService.php");
    require_once("../../../services/TypeService.php");
    require_once("../../../services/CategoryService.php");
    require_once("../../../services/ArrangementService.php");
    require_once("../../../services/PayementMethodService.php");

    require_once("../../../models/Reservation.php");
    require_once("../../../services/HousingService.php");
    $housing = HousingService::GetHousingById($housingID);

    $housingImage = $housing->getImage()->getImageSrc();
    $housingTitle = $housing->getTitle();
    $housingLongDesc = $housing->getLongDesc();
    $housingCity = $housing->getAddress()->getCity();
    $housingLongitude = $housing->getLongitude();
    $housingLatitude = $housing->getLatitude();
    $housingPostalCode = $housing->getAddress()->getPostalCode();
    $housingNbPerson = $housing->getNbPerson();
    $housingNbBed = $housing->getNbDoubleBed() + $housing->getNbSimpleBed();
    $housingNbRoom = $housing->getNbRoom();
    $ownerPicture = $housing->getOwner()->getImage()->getImageSrc();
    $ownerNickname = $housing->getOwner()->getNickname();

    require_once '../../../services/SessionService.php';
    require_once '../../../services/OwnerService.php';

    // Gestion de la session
    SessionService::system('owner', '/back/reservations');

    if($housing->getOwner()->getOwnerID() != $_SESSION["user_id"]) {
        header("Location: /back/logement");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des réservations</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/consulter_reservations/consulter_reservations.css">
    <link rel="stylesheet" href="/owner/consulter_logement/logement.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../style/ui.css">
    <script src="/client/ficheLogement/page.js"></script>
    <link rel="stylesheet" href="/client/ficheLogement/logement.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");
        require_once("../../../services/ReservationService.php");
        require_once("../../../services/OwnerService.php");

        $owner = OwnerService::getOwnerById($_SESSION['user_id']);

        $reservations = ReservationService::getAllReservationsByOwnerID($owner->getOwnerID());
        $_SESSION["reservations"] = $reservations;
        
        $selected_reservations = array();

        Header::render(isScrolling: True, isBackOffice: True);
    ?>
    <nav class="logement-nav-bar">
        <a href="/back/logements" class="logement-nav-bar__back">
            <i class="fa-solid fa-arrow-left"></i>
            <p>Logements</p>
        </a>
        <a>Prévisualisation de "<?= $housingTitle ?>"</a>
    </nav>
    <main class="logement logement--fiche">
        <h2><?= $housingCity . " - " . $housingPostalCode ?></h2>
        <section class="logement__top">
            <div class="logement__top__image">
                <img src="<?= $housingImage ?>" alt="Image Logement" />
            </div>
            <div class="logement__top__reservation">
                <h3>60€ la nuit</h3>
                <div class="logement__top__reservation__options">
                    <div class="datepicker logement__top__reservation__options__dates">
                        <div class="options__arrivee" type="dateStart">
                            <h4>Arrivée<h4>
                            <input class="para--14px" name="startDate" id="start-date" type="date" placeholder="Ajouter une date">
                        </div>
                        <div class="options__depart">
                            <h4>Départ<h4>
                            <input class="para--14px" name="endDate" id="end-date" type="date" placeholder="Ajouter une date">
                        </div>
                    </div>
                    <div class="logement__top__reservation__options__voyageurs">
                        <button class="para--bold" id="addTravelersBtn">Ajouter des voyageurs</button>
                        <output id="liveTravelersCount">0</output>
                        <div id="popup2" class="popup">
                            <div class="popup-content">
                                <div class="traveler-type">
                                    <div class="adulteInfo">
                                        <h2 class="para--bold">Adultes:</h2>
                                        <p>13 ans et +</p>
                                    </div>
                                    <div class="addbtn">
                                        <button id="subtractAdultBtn">-</button>
                                        <div class="nbr">
                                            <span id="adultCount">0</span>
                                        </div>
                                        <button id="addAdultBtn">+</button>
                                    </div>
                                </div>

                                <div class="traveler-type">
                                    <div class="enfantInfo">
                                        <h2 class="para--bold">Enfants:</h2>
                                        <p>- de 12 ans</p>
                                    </div>
                                    <div class="addbtn">
                                        <button id="subtractChildBtn">-</button>
                                        <div class="nbr">
                                            <span id="childCount">0</span>
                                        </div>
                                        <button id="addChildBtn">+</button>
                                    </div>
                                </div>
                                <i id="closePopupBtn" class="fa-solid fa-xmark"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="order-btn para--18px para--bold" disabled>Réserver</button>
                <div class="logement__top__reservation__nuits">
                    <p class="nuits__calculs">150 € x 5 nuits</p>
                    <p class="nuits__total">750 €</p>
                </div>
                <hr>
                <div class="logement__top__reservation__total">
                    <p>Total</p>
                    <p class="total__total">750 €</p>
                </div>
            </div>
        </section>

        <section  class="logement__bottom">
            <div class="logement__bottom__left">
                <div class="logement__bottom__left__info">
                    <div class="logement__bottom__left__info__description">
                        <h3><?= $housingTitle ?></h3>
                        <p> 5 personnes - 4 chambres - 5 lits</p>
                    </div>
                    <div class="logement__bottom__left__host">
                        <img src="<?= $ownerPicture ?>" alt="Proprio Image">
                        <h4><?= $ownerNickname ?></h4>
                    </div>
                </div>
                <div class="logement__bottom__left__description">
                    <h3>Description</h3>
                    <p class="truncate-text para--18px" id="truncate-text">
                        <?= $housingLongDesc ?>
                    </p>
                    <p class="button-savoir" id="button-savoir">En savoir plus+</p>
                    <div class="popup-overlay" id="popup-overlay-savoir"></div>
                        <div class="popup" id="popup-savoir">
                            <!-- Contenu de la pop-up (description complète) -->
                            <h3>Description du logement</h3>
                            <p class="para--18px" id="full-description">
                                <!-- Le texte de la description complète sera injecté ici par JavaScript -->
                            </p>
                            <i id="close-popup" class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                    <button type="button" class="logement__criteria">Afficher les critères</button>
                    <!-- Overlay and Popup Criteres-->
                    <div id="overlay-critere" class="overlay-critere"></div>
                        <div id="popup-critere" class="popup-critere">
                            <div class="popup-content-critere">
                                <i id="closePopupCritereBtn" class="fa-solid fa-xmark"></i>
                                <h3>Critères du Logement</h3>
                                <div class="section">
                                    <h4>Aménagements</h4>
                                    <div class="items">
                                        <div class="item">
                                            <i class="fa-solid fa-water-ladder"></i>
                                            <span>Piscine</span>
                                        </div>
                                        <div class="item">
                                            <i class="fa-solid fa-plant-wilt"></i>
                                            <span>Jardin</span>
                                        </div>
                                        <div class="item">
                                            <i class="fa-solid fa-plant-wilt"></i>
                                            <span>Salle de sport</span>
                                        </div>
                                        <div class="item">
                                            <i class="fa-solid fa-square-parking"></i>
                                            <span>Parking privée</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="horizontal-line"></div>

                                <div class="section">
                                    <h4>Activités</h4>
                                    <div class="items">
                                        <div class="item">
                                            <i class="fa-solid fa-umbrella-beach"></i>
                                            <span>Plage</span>
                                        </div>
                                        <div class="item">
                                            <i class="fa-solid fa-paw"></i>
                                            <span>Zoo</span>
                                        </div>
                                        <div class="item">
                                            <i id="img" class="fa-regular fa-water-ladder"></i>
                                            <span>Parc d’attraction</span>
                                        </div>
                                        <div class="item">
                                            <i class="fa-solid fa-landmark"></i>
                                            <span>Musée</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
            <div class="logement__bottom__right">
                <div class="logement__bottom__right__title">
                    <h3>Localisation du logement</h3>
                    <i class="fa-solid fa-circle-exclamation tooltip">
                        <span class="tooltip-text"> <p>La localisation exacte sera communiquée une fois la réservation terminée </p></span>
                    </i>
                </div>
                <div class="logement__bottom__right__map">
                    <div data-lat="<?= $housingLatitude ?>" data-long="<?= $housingLongitude ?>" id="map"></div>
                    <p class="city"><?= $housingCity . " - " . $housingPostalCode ?></p>
                </div>
            </div>
        </section>
    </main>

    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render(True);
    ?>
</body>
</html>