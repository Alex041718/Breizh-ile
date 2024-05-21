<?php

    if(!isset($_GET['reservationID']) || $_GET['reservationID'] == "") {
        header('Location: /owner/consulter_reservations/consulter_reservations.php');
        exit();
    };

    require_once '../../../services/SessionService.php';

    // Gestion de la session
    SessionService::system('owner', '/back/reservations');


    require_once("../../../services/ReservationService.php");
    require_once("../../../services/HousingService.php");
    require_once("../../../services/OwnerService.php");
    require_once("../../../services/TypeService.php");
    require_once("../../../services/CategoryService.php");
    require_once("../../../services/ArrangementService.php");
    require_once("../../../services/PayementMethodService.php");

    require_once("../../../models/Reservation.php");

    $reservationIsOK = false;

    $owner = OwnerService::getOwnerById($_SESSION['user_id']);

    $allReservations = ReservationService::getAllReservationsByOwnerID($owner->getOwnerID());

    foreach ($allReservations as $key => $reservationTmp) {
        if ($_GET['reservationID'] == $reservationTmp->getId()){
            $reservationIsOK = true;
        }
    }

    if (!$reservationIsOK){
        header('Location: /owner/consulter_reservations/consulter_reservations.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/consulter_detail_reservation/consulter_detail_reservation.css">
    <link rel="stylesheet" href="/components/SearchBar/SearchBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
    <link rel="stylesheet" href="/components/Header/header.css">

    <script src="/owner/consulter_detail_reservation/consulter_detail_reservation.js"></script>

    <?php // Date picker ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>



<?php

    require_once("../../components/Header/header.php");
    Header::render(true,);

    $reservation = ReservationService::getReservationByID($_GET['reservationID']);
    $housing = HousingService::GetHousingById($reservation->getHousingId()->getHousingID());


    $reservation_dateDebut = $reservation->getBeginDate();
    $reservation_dateFin =  $reservation->getEndDate();
    $reservation_image =  $housing->getImage()->getImageSrc();
    $reservation_titre =  $housing->getTitle();
    $reservation_type =  $housing->getType()->getlabel();
    $reservation_prixExcl =  $housing->getPriceExcl();
    $reservation_prixIncl =  $housing->getPriceIncl();
    $reservation_nbJours =  ReservationService::getNbJoursReservation($reservation_dateDebut, $reservation_dateFin);
    $reservation_serviceCharge =  $reservation->getServiceCharge();
    $reservation_touristTax =  $reservation->getTouristTax();
    $reservation_nbPersonnes =  $reservation->getNbPerson();
    $reservation_prixCalc = $reservation_prixExcl * $reservation_nbJours * $reservation_nbPersonnes;



    $client_pp = $reservation->getClientId()->getImage()->getImageSrc();
    $client_telephone = $reservation->getClientId()->getPhoneNumber();
    $client_mail = $reservation->getClientID()->getMail();

    $reservation_longitude = $housing->getLongitude();
    $reservation_latitude = $housing->getLatitude();
    $reservation_postalCode = $housing->getAddress()->getPostalCode();
    $reservation_city = $housing->getAddress()->getCity();
    $reservation_postalAdress = $housing->getAddress()->getPostalAddress();


    $reservation_prixTTC = $reservation_prixIncl * $reservation_nbJours * $reservation_nbPersonnes + $reservation_serviceCharge + $reservation_touristTax;

?>

    <main>
        <div class="title">
            <div class="title__arrow">
                <img src="/assets/images/fleche.png" id="fleche" alt="fleche">
                <h2>Ma réservation</h2>
            </div>
            <div class="title__date">
                <h5>Voyage  à Lannion du <?= $reservation_dateDebut->format('d-m-Y').' au '.$reservation_dateFin->format('d-m-Y') ?></h5>
            </div>
        </div>
        <article class="informations">
            <section class="informations__left">
                <div class="informations__left__logement">
                    <img src=<?= $reservation_image ?>>
                    <div class="informations__left__logement__info">
                        <h3><?= $reservation_titre ?></h3>
                        <p class="para--18px"><?= $reservation_type ?></p>
                    </div>
                </div>
                <hr>
                <div class="informations__left__detail">
                    <h3>Détails du prix</h3>
                    <div>
                        <p class="para--18px"><?= $reservation_prixExcl ?> € x <?= $reservation_nbJours ?> nuits x <?= $reservation_nbPersonnes  ?> occupant(s)</p>
                        <p class="para--18px"><?= $reservation_prixCalc ?> €</p>
                    </div>
                    <div>
                        <p class="para--18px" >Frais de service</p>
                        <p class="para--18px"><?= $reservation_serviceCharge ?> €</p>
                    </div>
                    <div>
                        <p class="para--18px">Taxee de séjour</p>
                        <p class="para--18px"><?= $reservation_touristTax ?> €</p>
                    </div>
                </div>
                <hr>
                <div class="informations__left__total">
                    <div>
                        <h3>Total TTC</h3>
                        <p class="para--18px"><?= $reservation_prixTTC ?> €</p>
                    </div>
                </div>
            </section>
            <section class="informations__right">
                <div class="informations__right__desc">
                    <img src=<?=$client_pp?> alt="">
                    <div class="informations__right__desc__info">
                        <div class="informations__right__desc__info__perso">
                            <h3><?= $client_telephone ?></h3>
                            <p><?= $client_mail ?></p>
                        </div>
                        <div class="informations__right__desc__info__vide">

                        </div>
                        <div class="informations__right__desc__info__icons">
                            <i id="telephone" class="fa-solid fa-phone"></i>
                            <i id="mail" class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                </div>
                <div class="informations__right__localisation">
                    <h3 class="loca">Localisation</h3>
                    <div id="map"></div>
                    <div>
                        <p class="para--18px"><?= $reservation_postalCode.' '.$reservation_city?>,</p>
                        <p id="" class="para--18px"><?= $reservation_postalAdress ?></p>
                        <p id="adresse" class="para--18px"><?= $reservation_postalAdress ?></p>
                        <br>
                        <p class="para--14px">Longitude: <?=$reservation_longitude?>,  Latitude: <?=$reservation_latitude?></p>
                        <p id="longitude" style="display:none"><?= $reservation_longitude?></p>
                        <p id="latitude" style="display:none"><?= $reservation_latitude?></p>
                    </div>
                </div>
            </section>
        </article>

    </main>

<?php
    require_once("../../components/Footer/footer.php");
    Footer::render();
?>

</html>
