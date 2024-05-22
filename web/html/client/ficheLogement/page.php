<?php

    // Commence le buffering de sortie
    ob_start();

    echo 'Du contenu qui sera affiché avant la redirection';

    // Nettoie le buffer de sortie et désactive le buffering
    ob_end_clean();

    if(!isset($_GET['id']) || $_GET['id'] == "") {
        header('Location: /');
        exit();
    };

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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="/client/ficheLogement/page.js"></script>
</head>

<?php

require_once("../../../models/Housing.php");

require_once("../../../services/AddressService.php");
require_once("../../../services/HousingService.php");
require_once("../../../services/TypeService.php");
require_once("../../../services/CategoryService.php");
require_once("../../../services/OwnerService.php");
require_once("../../../services/ImageService.php");
require_once("../../../services/ArrangementService.php");
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
$housing_ownerImage = $housing->getOwner()->getImage()->getImageSrc();
$housing_ownerFirstName = $housing->getOwner()->getFirstname();
$housing_ownerLastName = $housing->getOwner()->getLastname();
$housing_longDesc = $housing->getLongDesc();
$housing_priceHt = $housing->getPriceExcl();
$housingLongitude = $housing->getLongitude();
$housingLatitude = $housing->getLatitude();
$housingCity = $housing->getAddress()->getCity();

$housing_arrangements = $housing->getArrangement();



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
    <?php
        require_once("../../components/Header/header.php");
        Header::render(true);
    ?>

    <main>
        <div class="page">
            <h3 id="title"> <?php echo $housing_title ?> </h3>
            <div class="photoAndReservation">
                <div class="photo">
                    <img src="<?php echo $housing_image ?>" alt="Image Logement">
                </div>
                <form class="reservation" action="/controllers/client/clientCreateDevis.php" method="post">
                    <h3> <?php echo $housing_priceHt ?> € par nuit</h3>



                    <div class="preparation">
                        <div class="datepicker">
                            <div class="arriveeAndDepart">
                                <div class="arrivee">
                                    <p class="para--bold">Arrivée:</p>
                                    <input class="para--14px" name="startDate" id="start-date" type="date" placeholder="Ajouter une date">
                                </div>

                                <span class="vertical-line"></span>

                                <div class="depart">
                                    <p class="para--bold">Départ:</p>
                                    <input class="para--14px" name="endDate" id="end-date" type="date" placeholder="Ajouter une date">
                                </div>
                            </div>

                        </div>
                        <div class="nbrClients">
                            <button type="button" class="para--bold" id="addTravelersBtn">Ajouter des voyageurs<input name="numberPerson" id="liveTravelersCount" value="1"></button>
                            <div id="popup2" class="popup">
                                <div class="popup-content">
                                    <div class="traveler-type">
                                        <div class="adulteInfo">
                                            <span class="para--bold">Adultes:</span>
                                            <p>18 ans et +</p>
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
                                            <span class="para--bold">Enfants:</span>
                                            <p>- de 18 ans</p>
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



                    <div class="reservationBtn">
                        <button type="submit" class="para--18px para--bold" id="reserverBtn">Réserver</button>
                    </div>

                    <div class="prix">
                        <div class="calcul">
                            <div>
                                <p>
                                    <span id="nightPrice"><?php echo $housing_priceHt ?></span>
                                    <span>€ x</span>
                                    <span id="night-count">0</span> nuits
                                </p>
                            </div>
                            <div><p id="total-cost">0 €</p></div>
                        </div>

                        <div class="horizontal-line"></div>

                        <div class="total">
                            <div><p class="para--bold">Total HT</p></div>
                            <div><p class="para--bold" id="final-total">0</p></div>
                        </div>
                    </div>

                    <input type="hidden" name="isAuthenticated" value="<?php echo $isAuthenticated?>">

                    <?php if($isAuthenticated): ?>

                        <input type="hidden" name="clientID" value="<?php echo $_SESSION['user_id'] ?>">

                    <?php endif; ?>

                    <input type="hidden" name="housingID" value="<?php echo $housing->getHousingID() ?>">

                    <input type="hidden" name="ownerID" value="<?php echo $housing->getOwner()->getOwnerID() ?>">

                    <input type="hidden" name="oldPage" value="<?php echo $_SERVER['REQUEST_URI'] ?>">
                </form>

            </div>

            <div class="twodiv">
                <div class="details">
                    <h4> <?php echo $housing_shortDesc ?> </h4>
                    <div class="infoLogement">
                        <p id="nbVoyageurs"> <?php echo $housing_nbPerson ?> personnes • <?php echo $housing_nbRoom ?> chambres • <?php echo $housing_nbBed ?> lits</p>
                    </div>

                    <div class="proprio">
                        <img src=" <?php echo $housing_ownerImage ?>" alt="Proprio Image">
                        <p class="para--18px para--bold"> <?php echo $housing_ownerFirstName . ' ' . $housing_ownerLastName; ?></p>
                    </div>

                    <div class="description">
                        <div class="texte">
                            <h4>Description</h4>
                            <p class="para--18px" id="truncate-text"> <?php echo $housing_longDesc ?> </p>
                            <button type="button"><p class="para--bold" id="button-savoir">En savoir +</p></button>
                        </div>
                    </div>

                    <!-- Pop-up -->
                    <div class="popup-overlay" id="popup-overlay-savoir"></div>
                    <div class="popup" id="popup-savoir">
                        <!-- Contenu de la pop-up (description complète) -->
                        <h3 id="titleDescription">Description du logement</h3>
                        <p class="para--18px" id="full-description">
                            <!-- Le texte de la description complète sera injecté ici par JavaScript -->
                        </p>
                        <i id="close-popup" class="fa-solid fa-xmark"></i>
                    </div>

                    <button type="button" class="criteres"><p class="para--bold">Afficher les critères</p></button>

                    <!-- Overlay and Popup Criteres-->
                    <div id="overlay-critere" class="overlay-critere"></div>
                    <div id="popup-critere" class="popup-critere">
                        <div class="popup-content-critere">
                            <i id="closePopupCritereBtn" class="fa-solid fa-xmark"></i>
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
                                        <span>Parc d'attraction</span>
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
                                    <?php if (!empty($housing_arrangements)): ?>
                                        <?php foreach ($housing_arrangements as $arrangement): ?>
                                            <div class="item">
                                                <?php
                                                $label = $arrangement->getLabel();
                                                if (isset($iconMapping[$label])) {
                                                    $iconClass = $iconMapping[$label];
                                                    echo '<i class="' . $iconClass . '"></i>';
                                                }
                                                ?>
                                                <span><?php echo $label ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Aucun aménagement disponible.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="localisation">
                    <div class="local-texte">
                        <p class="para--18px">Localisation du logement</p>
                        <i class="fa-solid fa-circle-exclamation tooltip">
                            <span class="tooltip-text"> <p>La localisation exacte sera communiquée une fois la réservation terminée </p></span>
                        </i>
                    </div>
                    <div data-lat="<?= $housingLatitude ?>" data-long="<?= $housingLongitude ?>" id="map"></div>
                </div>
            </div>

            <div id="overlay"></div>

        </div>

    </main>


<?php
    require_once("../../components/Footer/footer.php");
    Footer::render();
?>
</body>
</html>
