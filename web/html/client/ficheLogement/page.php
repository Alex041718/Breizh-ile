<?php
// ------------------- Systeme de session -------------------
// Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php'; // pour le menu du header

// Vérification de l'authentification de l'utilisateur

$isAuthenticated = SessionService::isClientAuthenticated();

if ((!isset($_GET['id']) || $_GET['id'] == "")) {
    header('Location: /');
    exit();
}
;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Logement</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/client/ficheLogement/page.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="/client/ficheLogement/page.js"></script>
</head>

<?php

require_once ("../../components/Popup/popup.php");

require_once ("../../../models/Housing.php");

require_once ("../../../services/AddressService.php");
require_once ("../../../services/HousingService.php");
require_once ("../../../services/TypeService.php");
require_once ("../../../services/CategoryService.php");
require_once ("../../../services/OwnerService.php");
require_once ("../../../services/ImageService.php");
require_once ("../../../services/ArrangementService.php");
require_once ("../../../services/HasForArrangementService.php");
// require_once("../../../services/ActivityService.php");

$housing = HousingService::GetHousingById($_GET['id']);

$housing_title = $housing->getTitle();
$housing_shortDesc = $housing->getshortDesc();
$housing_nbPerson = $housing->getNbPerson();
$housing_nbRoom = $housing->getNbRoom();
$housing_nbDoubleBed = $housing->getNbDoubleBed();
$housing_nbSimpleBed = $housing->getNbSimpleBed();
$housing_nbBed = $housing_nbDoubleBed + $housing_nbSimpleBed;
$housing_image = $housing->getImage()->getImageSrc();
$housing_ownerID = $housing->getOwner()->getOwnerID();
$housing_ownerImage = $housing->getOwner()->getImage()->getImageSrc();
$housing_ownerFirstName = $housing->getOwner()->getFirstname();
$housing_ownerLastName = $housing->getOwner()->getLastname();
$housing_longDesc = $housing->getLongDesc();
$housing_priceHt = $housing->getPriceIncl();
$housing_priceHt_format = number_format($housing_priceHt, 2, '.', '');
$housingLongitude = $housing->getLongitude();
$housingLatitude = $housing->getLatitude();
$housingCity = $housing->getAddress()->getCity();
$housingPostalCode = $housing->getAddress()->getPostalCode();

// $housing_arrangements = $housing->getArrangement();

$iconMapping = [
    'Jardin' => 'fa-solid fa-plant-wilt',
    'Balcon' => 'fa-solid fa-door-open',
    'Terrasse' => 'fa-solid fa-chair',
    'Piscine' => 'fa-solid fa-swimmer',
    'Jacuzzi' => 'fa-solid fa-hot-tub'
    // Ajouter d'autres correspondances ici
];

?>

<body>
    <p id="auth" style="display:none"><?= $isAuthenticated ?></p>
    <?php
    require_once ("../../components/Header/header.php");
    Header::render(true, false, $isAuthenticated, '/logement?id=' . $_GET['id']);
    ?>

    <main>

        <div class="page">
            <?php
            require_once ("../../components/BackComponent/BackComponent.php");
            BackComponent::render("", "back-arrow", "Retour", "");
            ?>
            <span id="title" style="display: flex; align-items: center">
                <h2>
                    <?= $housingCity . " - " . $housingPostalCode ?>
                </h2>
            </span>


            <div class="photoAndReservation">
                <div class="photo">
                    <img src="<?php echo $housing_image ?>" alt="Image Logement">
                </div>
                <form class="reservation" action="/controllers/client/clientCreateDevis.php" method="post">
                    <div class="price">
                        <h2> <?php echo $housing_priceHt_format . ' €' ?></h2>
                        <p class="para--18px para--bold">/ nuit</p>
                    </div>

                    <div class="preparation">
                        <div class="datepicker">
                            <div class="arriveeAndDepart">
                                <div class="arrivee">
                                    <p class="para--bold">Arrivée:</p>
                                    <input class="para--14px" name="startDate" id="start-date" type="date"
                                        placeholder="Ajouter une date">
                                </div>

                                <span class="vertical-line"></span>

                                <div class="depart">
                                    <p class="para--bold">Départ:</p>
                                    <input class="para--14px" name="endDate" id="end-date" type="date"
                                        placeholder="Ajouter une date">
                                </div>
                            </div>

                        </div>
                        <div class="nbrClients">
                            <button type="button" class="para--bold" id="addTravelersBtn">Ajouter des voyageurs<input
                                    name="numberPerson" id="liveTravelersCount" value="1"></button>
                            <?php Popup::render(
                                "popupVoyageurs",
                                "addTravelersBtn",
                                '
                                <div class="traveler-type">
                                    <div class="adulteInfo">
                                        <h3>Adultes:</h3>
                                        <p class="para--20px">18 ans et +</p>
                                    </div>
                                    <div class="addbtn">
                                        <button type="button" id="subtractAdultBtn">-</button>
                                        <div class="nbr">
                                            <span id="adultCount">1</span>
                                        </div>
                                        <button type="button" id="addAdultBtn">+</button>
                                    </div>
                                </div>

                                <div class="traveler-type">
                                    <div class="enfantInfo">
                                        <h3>Enfants:</h3>
                                        <p class="para--20px">- de 18 ans</p>
                                    </div>
                                    <div class="addbtn">
                                        <button type="button" id="subtractChildBtn">-</button>
                                        <div class="nbr">
                                            <span id="childCount">0</span>
                                        </div>
                                        <button type="button" id="addChildBtn">+</button>
                                    </div>
                                </div>
                            '
                            )
                                ?>
                        </div>
                    </div>

                    <div class="reservationBtn">
                        <button type="submit" class="para--18px para--bold" id="reserverBtn">Réserver</button>
                        <div id="message" style="display: none;">Veuillez sélectionner vos dates d'arrivée et de départ
                            !</div>
                    </div>

                    <div class="prix">
                        <div class="calcul">
                            <div>
                                <p>
                                    <span id="nightPrice"
                                        class="para--18px"><?php echo $housing_priceHt_format ?></span>
                                    <span class="para--18px">€ x</span>
                                    <span id="night-count" class="para--18px">0</span> nuits
                                </p>
                            </div>
                            <div>
                                <p id="total-cost" class="para--18px">0 €</p>
                            </div>
                        </div>

                        <div class="horizontal-line"></div>

                        <div class="total">
                            <div>
                                <p class="para--18px para--bold">Total HT</p>
                            </div>
                            <div>
                                <p class="para--18px para--bold" id="final-total">0</p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="isAuthenticated" value="<?php echo $isAuthenticated ?>">

                    <?php if ($isAuthenticated): ?>

                        <input type="hidden" name="clientID" value="<?php echo $_SESSION['user_id'] ?>">

                    <?php endif; ?>

                    <input type="hidden" name="housingID" value="<?php echo $housing->getHousingID() ?>">

                    <input type="hidden" name="ownerID" value="<?php echo $housing->getOwner()->getOwnerID() ?>">

                    <input type="hidden" name="oldPage" value="<?php echo $_SERVER['REQUEST_URI'] ?>">
                </form>

            </div>

            <div class="twodiv">
                <div class="details">
                    <h3> <?php echo $housing_shortDesc ?> </h3>
                    <div class="infoLogement">
                        <p id="nbVoyageurs" class="para--18px"> <?php echo $housing_nbPerson ?> personnes •
                            <?= $housing_nbRoom != 0 ? $housing_nbRoom : "1" ?> chambres • <?= $housing_nbBed ?> lits</p>
                    </div>

                    <a href="client/profil/<?= $housing_ownerID ?>" class="proprio">
                        <img src=" <?php echo $housing_ownerImage ?>" alt="Proprio Image">
                        <p class="para--18px"> <?php echo $housing_ownerFirstName . ' ' . $housing_ownerLastName; ?></p>
                    </a>

                    <div class="description">
                        <div class="texte">
                            <h4>Description</h4>
                            <p class="para--18px" id="truncate-text"> <?php echo $housing_longDesc ?> </p>
                            <button type="button">
                                <p class="para--bold" id="button-savoir">En savoir +</p>
                            </button>
                        </div>
                    </div>

                    <?php Popup::render(
                        "popupSavoir",
                        "button-savoir",
                        '
                        <!-- Contenu de la pop-up (description complète) -->
                        <h3 id="titleDescription">Description du logement</h3>
                        <p class="para--18px" id="full-description">
                            <!-- Le texte de la description complète sera injecté ici par JavaScript -->
                        </p>
                    '
                    ); ?>

                    <button type="button" id="criteres">
                        <p class="para--bold">Afficher les critères</p>
                    </button>

                    <?php
                    $popupContent = '
                        <h3>Critères du Logement</h3>
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
                                    <i class="fa-solid fa-candy-cane"></i>
                                    <span>Parc d\'attraction</span>
                                </div>
                                <div class="item">
                                    <i class="fa-solid fa-landmark"></i>
                                    <span>Musée</span>
                                </div>
                            </div>
                        </div>

                        <div class="horizontal-line"></div>

                        <div class="section">
                            <h4>Aménagements</h4>
                            <div class="items">
                    ';

                    if (!empty($housing_arrangements)) {
                        foreach ($housing_arrangements as $arrangement) {
                            $label = $arrangement->getLabel();
                            $iconClass = isset($iconMapping[$label]) ? $iconMapping[$label] : '';
                            $popupContent .= '<div class="item"><i class="' . $iconClass . '" id="iconWeb"></i><span>' . $label . '</span></div>';
                        }
                    } else {
                        $popupContent .= '<p>Aucun aménagement disponible.</p>';
                    }

                    $popupContent .= '
                            </div>
                        </div>
                    ';

                    Popup::render("popupCriteres", "criteres", $popupContent);
                    ?>

                </div>

                <div class="localisation">
                    <div class="local-texte">
                        <p class="para--18px">Localisation du logement</p>
                        <i class="fa-solid fa-circle-exclamation tooltip">
                            <span class="tooltip-text">
                                <p>La localisation exacte sera communiquée une fois la réservation terminée </p>
                            </span>
                        </i>
                    </div>
                    <div data-lat="<?= $housingLatitude ?>" data-long="<?= $housingLongitude ?>" id="map"></div>

                </div>
            </div>

            <div id="overlay"></div>

        </div>

    </main>


    <?php
    require_once ("../../components/Footer/footer.php");
    Footer::render();
    ?>
</body>

</html>